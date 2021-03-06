<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        switch (\Auth::user()->division_id) {
            case 1:
                $data['users'] = User::where([
                    ['division_id' , '!=', 1],
                ])->with('division')->orderBy('id', 'asc')->get();
                break;
            case 2:
                $data['users'] = User::where([
                    ['division_id' , '!=', 1],
                    ['division_id' , '!=', 2],
                ])->with('division')->orderBy('id', 'asc')->get();
                break;
        }
        
        $data['products'] = Product::all();

        if(\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2  )
        {
            return view('dashboard.index', $data);
        }
        return view('dashboard.index-division', $data);
    }
}