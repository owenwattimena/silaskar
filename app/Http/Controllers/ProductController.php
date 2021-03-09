<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;

class ProductController extends Controller
{
    //
    public function index(){
        return view('product.index');
    }
    
    public function getProducts(){
        $products = Product::orderBy('id', 'desc')->get();
        return response()->json(["data" => $products], 200);
    }

    // public function create(){
        
    //     return view('product.create');
    // }

    // public function edit($id){
    //     $data['product'] = Product::findOrFail($id);
    //     return view('product.edit', $data);
    // }

    public function post(Request $request){
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'unit_price' => 'required',
        ]);

        $product                = new Product;
        $product->name          = $request->name; 
        $product->unit          = $request->unit; 
        $product->unit_price    = $request->unit_price; 
        if($product->save())
        {
            return ResponseFormatter::success($product, "Data barang berhasil ditambahkan");
        }
        return ResponseFormatter::error(null, "Data barang gagal ditambahkan", 200);
        
    }
    
    public function put(Request $request, $id){
        $request->validate([
            'edit_name' => 'required',
            'edit_unit' => 'required',
            'edit_unit_price' => 'required',
        ]);

        $product                = Product::findOrFail($id);
        $product->name          = $request->edit_name; 
        $product->unit          = $request->edit_unit; 
        $product->unit_price    = $request->edit_unit_price; 
        if($product->save())
        {
            return ResponseFormatter::success($product, "Data barang berhasil diubah");
        }
        return ResponseFormatter::error($product, "Data barang gagal diubah", 200);
    }

    public function delete($id){
        $product    = Product::findOrFail($id);
        // dd($product);
        try {
            if($product->delete())
            {
                return ResponseFormatter::success($product, "Data barang berhasil dihapus");
            }
            return ResponseFormatter::error($product, "Data barang gagal dihapus", 200);
            
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1451'){
                return ResponseFormatter::error($product, "Data barang tidak dapat dihapus! $product->name memiliki relasi dengan data transaksi.", 200);
                $alert = [
                    "type" => "alert-danger",
                    "msg"  => "Data barang tidak dapat dihapus! $product->name memiliki relasi dengan data transaksi."
                ];
                return redirect()->route('product')->with($alert);
            }
        }
    }
}