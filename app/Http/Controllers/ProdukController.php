<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Produk::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('act', function($data) {
                return view('pages.produk.modal.action', compact('data'));
            })
            ->rawColumns(['act'])->make(true);
        }
        return view('pages.produk.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'plu'       => 'required|unique:produks',
            'nm_produk' => 'required'
        ];
        $pesan = [
            'plu.required'          => 'Masukkan Plu',
            'nm_produk.required'    => 'Masukkan Nama Produk'
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
            Produk::create([
                'plu'       => $request->plu,
                'nm_produk' => $request->nm_produk
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
        $data = Produk::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 200);
    }
    public function update(Request $request,$id)
    {
        Produk::find($id);
        $validate = [
            'plu'       => 'required|unique:produks,plu,'.$id,
            'nm_produk' => 'required'
        ];
        $pesan = [
            'plu.required'          => 'Masukkan Plu',
            'nm_produk.required'    => 'Masukkan Nama Produk'
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
                'plu'       => $request->plu,
                'nm_produk' => $request->nm_produk
            ];
            Produk::find($id)->update($data);
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
            Produk::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Dihapus'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
}
