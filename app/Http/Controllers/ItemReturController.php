<?php

namespace App\Http\Controllers;

use App\Models\Faktur;
use App\Models\ItemRetur;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemReturController extends Controller
{
    public function index()
    {
        return view('pages.retur.index');
    }
    public function store(Request $request)
    {
        $validate = [
            'no_faktur'     => 'required',
            'tgl_faktur'    => 'required',
            'tgl_tiba'      => 'required',
            'pejabat'       => 'required',
            'no_plat_mu'    => 'required'
        ];
        $pesan = [
            'no_faktur.required'    => 'Masukkan No Faktur',
            'tgl_faktur.required'   => 'Masukkan Tanggal Faktur',
            'tgl_tiba.required'     => 'Masukkan Tanggal Tiba',
            'pejabat.required'      => 'Masukkan Pejabat',
            'no_plat_mu.required'   => 'Masukkan No Plat'
        ];
        $validation = Validator::make($request->all(),$validate,$pesan);
        if($validation->fails()){
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        if(!$request->urut){
            return response()->json([
                'status'    => 'waning',
                'messages'  => 'Data Item Retur Belum Ada'
            ], 422);
        }

        DB::beginTransaction();
        try{
            $data = [
                'kd_toko'       => auth()->user()->kd_toko,
                'no_faktur'     => $request->no_faktur,
                'tgl_faktur'    => $request->tgl_faktur,
                'tgl_tiba'      => $request->tgl_tiba,
                'pejabat'       => $request->pejabat,
                'no_plat_mu'    => $request->no_plat_mu,
                'created_at'    => Carbon::now(),
                'user_id'       => auth()->user()->id
            ];
            $result = Faktur::create($data);
            $data_list_item = [];
            foreach($request->urut as $key => $item) {
                $data_item = [
                    'faktur_id'     => $result->id,
                    'kd_toko'       => auth()->user()->kd_toko,
                    'produk_id'     => $request->input('produk_id'.$item),
                    'qty'           => $request->input('qty'.$item),
                    'bta'           => $request->input('bta'.$item),
                    'sb'            => $request->input('sb'.$item),
                    'bl'            => $request->input('bl'.$item),
                    'bk'            => $request->input('bk'.$item),
                    'bnf'           => $request->input('bnf'.$item),
                    'brp'           => $request->input('brp'.$item),
                    'keterangan'    => $request->input('keterangan'.$item)
                ];
                ItemRetur::create($data_item);
            }
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Ditambahkan'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
    public function find($id)
    {
        try{
            $result = Faktur::select('fakturs.*','tokos.nm_toko')
            ->with(['item_retur' => function($q) {
                $q->select('item_returs.*','produks.plu','produks.nm_produk');
                $q->leftJoin('produks','produks.id','=','item_returs.produk_id');
            }])
            ->leftJoin('tokos','tokos.kd_toko','=','fakturs.kd_toko')->find($id);

            if(auth()->user()->level == 'Admin' && $result->status == 'Belum Dilihat') {
                Faktur::find($id)->update(['status' => 'Dilihat']);
            }
            return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $result], 201);
            // return response()->json($this->success($result), 201);
        }catch(QueryException $e){
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }
    }
    public function update_status(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            foreach($request->urut as $key => $item) {
                ItemRetur::find($request->input('item_id'.$item))->update([
                    'status'    => $request->input('status'.$item),
                    'catatan'   => $request->input('catatan'.$item)
                ]);
            }
            Faktur::find($id)->update(['status' => 'Selesai']);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Diupdate'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
}
