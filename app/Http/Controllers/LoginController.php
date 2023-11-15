<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if(!empty(auth()->user()->id)) {
            return redirect('/');
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $validate = [
            'username'  => 'required',
            'password'  => 'required'
        ];
        $message = [
            'username.required'  => 'Masukkan Username yang Benar',
            'password.required'  => 'Masukkan Password yang Benar'
        ];
        $validation = Validator::make($request->all(), $validate, $message);
        if($validation->fails()) {
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $credentials = $request->only('username','password');
            $token = auth()->attempt($credentials);
            if(!$token) {
                return response()->json(['status' => 'warning', 'messages' => 'Login Gagal'], 422);
            }
            return response()->json(['status' => 'success', 'messages' => 'Login Success', 'data' => $token], 201);
        } catch(QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
