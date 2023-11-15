<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('act', function($data) {
                return view('pages.user.modal.action', compact('data'));
            })
            ->rawColumns(['act'])->make(true);
        }
        return view('pages.user.index');
    }
    public function store(Request $request)
    {
        $validate = [
            'username'  => 'required|unique:users',
            'password'  => 'required',
            'name'      => 'required'
        ];
        $message = [
            'username.required' => 'Masukkan Username',
            'password.required' => 'Masukkan Password',
            'name.required'     => 'Masukkan Nama'
        ];

        $validation = Validator::make($request->all(),$validate,$message);
        if($validation->fails()){
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try{
            User::create([
                'username'  => $request->username,
                'password'  => Hash::make($request->password),
                'name'      => $request->name,
                'level'     => 'Admin',
                'user_id'   => auth()->user()->id
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
        $data = User::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }
    public function update(Request $request, $id)
    {
        $validate = [
            'username'  => 'required|unique:users',
            'password'  => 'required',
            'name'      => 'required'
        ];
        $message = [
            'username.required' => 'Masukkan Username',
            'password.required' => 'Masukkan Password',
            'name.required'     => 'Masukkan Nama'
        ];

        $validation = Validator::make($request->all(), $validate,$message);
        if($validation->fails()){
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        try{
            $data = [
                'username'  => $request->username,
                'name'      => $request->name,
                'level'     => 'Admin',
                'user_id'   => auth()->user()->id
            ];
            if(!empty($request->password)) {
                $data += ['password' => Hash::make($request->password)];
            }
            User::find($id)->update($data);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Di Update'], 201);
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
            User::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Terhapus'], 201);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }finally{
            DB::commit();
        }
    }
}
