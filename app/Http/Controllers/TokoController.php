<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Toko::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('act', function($data){
                return view('pages.toko.modal.action', compact('data'));
            })
            ->rawColumns(['act'])->make(true);
        }
        return view('pages.toko.index');
    }
    public function store(Request $request)
    {
        $validate = [
            'kd_toko'   => 'required|unique:tokos',
            'nm_toko'   => 'required',
            'alamat'    => 'required',
            'username'  => 'required|unique:users',
            'password'  => 'required'
        ];
        $pesan = [
            'kd_toko.required'  => 'Masukkan Kode Toko',
            'nm_toko.required'  => 'Masukkan Nama Toko',
            'alamat.required'   => 'Masukkan Alamat Toko',
            'username.required' => 'Masukkan Username',
            'password.required' => 'Masukkan Password'
        ];
        $validation = Validator::make($request->all(),$validate,$pesan);
        if($validation->fails()){
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try{
            Toko::create([
                'kd_toko'   => $request->kd_toko,
                'nm_toko'   => $request->nm_toko,
                'alamat'    => $request->alamat
            ]);
            User::create([
                'kd_toko'   => $request->kd_toko,
                'username'  => $request->username,
                'password'  => Hash::make($request->password),
                'name'      => $request->nm_toko,
                'level'     => 'Toko'
            ]);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Ditambahkan'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
    public function edit($id)
    {
        $data = Toko::select('tokos.*','users.username')->join('users','users.kd_toko','=','tokos.kd_toko')->findOrFail($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 200);
    }
    public function update(Request $request,$id)
    {
        $toko = Toko::find($id);
        $validate = [
            'kd_toko'   => 'required|unique:tokos,kd_toko,'.$id,
            'nm_toko'   => 'required',
            'alamat'    => 'required',
            'username'  => 'required|unique:users,kd_toko,'.$toko->kd_toko
        ];
        $pesan = [
            'kd_toko.required'  => 'Masukkan Kode Toko',
            'nm_toko.required'  => 'Masukkan Nama Toko',
            'alamat.required'   => 'Masukkan Alamat',
            'username.required' => 'Masukkan Username'
        ];
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
                'kd_toko'   => $request->kd_toko,
                'nm_toko'   => $request->nm_toko,
                'alamat'    => $request->alamat
            ];
            $data_user = [
                'kd_toko'   => $request->kd_toko,
                'username'  => $request->username,
                'name'      => $request->nm_toko,
                'level'     => 'Toko'
            ];
            if(!empty($request->password)){
                $data_user += ['password' => Hash::make($request->password)];
            }
            Toko::find($id)->update($data);
            User::where(['kd_toko' => $request->kd_toko])->update($data_user);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Diupdate'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data = Toko::find($id);
            User::where(['kd_toko' => $data->kd_toko])->delete();
            $data->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Dihapus'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' =>$e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
}
