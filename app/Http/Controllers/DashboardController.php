<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use App\Models\ItemRetur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $result = Faktur::select('fakturs.*','tokos.nm_toko')
            ->leftJoin('tokos','tokos.kd_toko','=','fakturs.kd_toko');
            if(auth()->user()->level != 'Admin') {
                $result = $result->where('tokos.kd_toko', auth()->user()->kd_toko);
            }
            $result = $result->get();

            return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('act', function($data) {
                return view('pages.dashboard.modal.action', compact('data'));
            })
            ->rawColumns(['act'])->make(true);
        }
        if(auth()->user()->level == 'Admin') {
            $BelumDilihat = Faktur::where(['status' => 'Belum Dilihat'])->count();
            $Selesai = Faktur::where(['status' => 'Selesai'])->count();
            $Terima = Faktur::where(['status' => 'Terima'])->count();
            $Tolak = Faktur::where(['status' => 'Tolak'])->count();
        }else{
            $BelumDilihat = Faktur::where(['status' => 'Belum Dilihat', 'kd_toko' => auth()->user()->kd_toko])->count();
            $Selesai = Faktur::where(['status' => 'Selesai', 'kd_toko' => auth()->user()->kd_toko])->count();
            $Terima = Faktur::where(['status' => 'Terima', 'kd_toko' => auth()->user()->kd_toko])->count();
            $Tolak = Faktur::where(['status' => 'Tolak', 'kd_toko' => auth()->user()->kd_toko])->count();
        }

        $data = [
            'Belum Dilihat' => $BelumDilihat,
            'Sudah Selesai' => $Selesai,
            'Diterima'      => $Terima,
            'Ditolak'       => $Tolak
        ];
        return view('pages.dashboard.index', compact('data'));
    }
    public function realtime_update_status()
    {
        $date_now = Carbon::now();
        $faktur = Faktur::where('status', '!=', 'Selesai')->get();
        $data = [];
        foreach($faktur as $item) {
            $start_date = Carbon::parse($item->created_at);
            $duration = $start_date->diffInHours($date_now);
            if($duration >= 24) {
                Faktur::find($item->id)->update(['status' => 'Selesai']);
                ItemRetur::where(['faktur_id' => $item->id])->update(['status' => 'Terima']);
            }
            $data[] = $duration;
        }
        return response()->json($data, 201);
    }
    public function setSetting(Request $request)
    {
        $validate = ['password' => 'required'];
        $pesan = ['password.required' => 'Masukkan Password Baru !'];

        $validation = Validator::make($request->all(),$validate,$pesan);
        if($validation->fails()){
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try{
            $data = [
                'password'  => Hash::make($request->password)
            ];
            User::find(auth()->user()->id)->update($data);
            return response()->json(['status' => 'success', 'messages' => 'Password Berhasil Diganti'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
}
