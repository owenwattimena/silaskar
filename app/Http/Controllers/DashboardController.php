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
                    $data['users'] = User::where([
                        ['division_id' , '!=', 1]
                    ])->with('division')->orderBy('id', 'asc')->get();
                    break;
                case 2:
                    $data['users'] = User::where([
                        ['division_id' , '!=', 1],
                        ['division_id' , '!=', 2]
                    ])->with('division')->orderBy('id', 'asc')->get();
                    break;
            }
            
            $data['products'] = Product::all();
            return view('dashboard.index', $data);
        }
        else{

            // $data['requestAccepted'] = ProductCameOut::where([
            //     ['status' , '==' , 'disetujui'],
            //     ['user_id' , '==' , \Auth::user()->id]
            // ])->get();
            // $data['requestRejected'] = ProductCameOut::where([
            //     ['status' , '==' , 'Ditolak'],
            //     ['user_id' , '==' , \Auth::user()->id]
            // ])->get();
            $data['requestAccepted'] = ProductCameOut::where('status', 'Disetujui')->where('user_id', \Auth::user()->id)->get();
            $data['requestRejected'] = ProductCameOut::where('status', 'Ditolak')->where('user_id', \Auth::user()->id)->get();
            // dd($data);
            return view('dashboard.index-division', $data);
        }
    }
}