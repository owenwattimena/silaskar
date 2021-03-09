<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCameOut;

class DashboardController extends Controller
{
    //
    public function index(){
        
        if(\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2  )
        {
            switch (\Auth::user()->division_id) {
                case 1:
                    $user = [
                        ['division_id' , '!=' ,1]
                    ];
                    break;
                case 2:
                        $user = [
                            ['division_id' , '!=' ,1],
                            ['division_id' , '!=' ,2],
                        ];
                    break;
            }
                
            $data['users'] = User::where($user)->get()->count();
            $data['products'] = Product::all()->count();
            return view('dashboard.index', $data);
        }
        else{
            $requestAccepted = [
                ['status' , '=', 'Disetujui'],
                ['user_id' , '=', \Auth::user()->id]
            ];
            $data['requestAccepted'] = ProductCameOut::where($requestAccepted)->get();
            $data['requestRejected'] = ProductCameOut::where(
                [
                    ['status' , '=', 'Ditolak'],
                    ['user_id' , '=', \Auth::user()->id]
                ]
            )->get();
            return view('dashboard.index-division', $data);
        }
    }
}