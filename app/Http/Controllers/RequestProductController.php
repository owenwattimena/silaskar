<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCameOut;
use App\Helpers\ResponseFormatter;

class RequestProductController extends Controller
{
    //
    public function index()
    {
        $data['products'] = Product::orderBy('name', 'asc')->get();

        return view('request-product.index', $data);
    }

    public function all(){
        $requestProduct = ProductCameOut::where('division_id', \Auth::user()->division_id)->with(['product', 'user'])->orderBy('id', 'desc')->get();
        return ResponseFormatter::success($requestProduct, "Data berhasil diambil.");
    }

    public function post(Request $request)
    {
        
        $request->validate([
            'created_at' => 'required',
            'product_id' => 'required|numeric',
            'stock'      => 'required|numeric',
        ]);
        
        $product        = Product::findOrFail($request->product_id);
        
        $productCameOut                            = new ProductCameOut;
        $productCameOut->created_at                = $request->created_at;
        $productCameOut->updated_at                = $request->created_at;
        $productCameOut->product_id                = $request->product_id;
        $productCameOut->stock_quantity            = $request->stock;
        $productCameOut->total                     = $product->unit_price * $request->stock;
        $productCameOut->user_id                   = \Auth::user()->id;
        $productCameOut->division_id               = \Auth::user()->division_id;
        $productCameOut->description_of_request    = $request->description_of_request;
        // return ResponseFormatter::success($productCameOut->user_id, "test");

        if($productCameOut->save()){
            return ResponseFormatter::success($productCameOut, "Data transaksi berhasil ditambahkan");
        }
        return ResponseFormatter::error(null, "Data transaksi gagal ditambahkan", 200);
    }
}