<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){

        return view('Auth/login');
    }

    public function login(Request $request){
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required|min:3'
            ]
        );
        $start = date('08:00:00');
        $end = date('16:00:00');
        $now = date('H:i:s');
        // if($now < $start || $now > $end){
        //     $alert = [
        //         "type" => "alert-danger",
        //         "msg"  => "Diluar jam kerja!"
        //     ];
        //     return redirect()->back()->with($alert);
        // }

        $username   = $request->username;
        $password   = $request->password;

        $user       = User::where('username', $username)->with('division')->first();

        if($user)
        {
            if($user->status != 'active'){
                $alert = [
                    "type" => "alert-danger",
                    "msg"  => "Akun anda di blokir. Hubungi administrator untuk mengaktifkan."
                ];
                return redirect()->back()->with($alert);
            }
            if(Hash::check($password, $user->password))
            {
                \Auth::login($user);
                \Auth::loginUsingId($user->id);
                return redirect()->route('dashboard');
            }
        }
        $alert = [
            "type" => "alert-danger",
            "msg"  => "Masukan username dan password yang benar"
        ];
        return redirect()->back()->with($alert);

    }
}