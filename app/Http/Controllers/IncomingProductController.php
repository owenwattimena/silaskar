<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\IncomingProduct;
use App\Helpers\ResponseFormatter;

class IncomingProductController extends Controller
{
    public function index(){
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['incomingProducts'] = IncomingProduct::with('product')->orderBy('id', 'desc')->get();
        return view('incoming-product.index',$data);
    }

    public function all(){
        $incomingProducts = IncomingProduct::with('product')->orderBy('id', 'desc')->get();
        return ResponseFormatter::success($incomingProducts, "Data berhasil diambil.");
    }

    // public function create(){
    //     $data['products'] = Product::orderBy('name', 'asc')->get();
    //     return view('incoming-product.create', $data);
    // }
    
    // public function edit($id){
    //     $data['products'] = Product::orderBy('name', 'asc')->get();
    //     $data['incomingProduct'] = IncomingProduct::findOrFail($id);
    //     return view('incoming-product.edit', $data);
    // }

    public function post(Request $request)
    {
        
        $request->validate([
        'created_at' => 'required',
        'product_id' => 'required|numeric',
        'stock'      => 'required|numeric',
        ]);
        
        $product        = Product::findOrFail($request->product_id);
        
        $incomingProduct                 = new IncomingProduct;
        $incomingProduct->created_at     = $request->created_at;
        $incomingProduct->updated_at     = $request->created_at;
        $incomingProduct->product_id     = $request->product_id;
        $incomingProduct->stock_quantity = $request->stock;
        $incomingProduct->total          = $request->stock * $product->unit_price;
        $incomingProduct->user_id        = \Auth::user()->id;
        // return ResponseFormatter::success($incomingProduct->user_id, "test");

        if($incomingProduct->save()){
            $product->stock += $request->stock;
            $product->save();
            return ResponseFormatter::success($incomingProduct, "Data transaksi berhasil ditambahkan");
        }
        return ResponseFormatter::error(null, "Data transaksi gagal ditambahkan", 200);

        
    }
    
    public function put(Request $request, $id)
    {
        
        
        $request->validate([
            'edit_created_at' => 'required',
            'edit_product_id' => 'required|numeric',
            'edit_stock'      => 'required|numeric',
        ]);
        $product        = Product::findOrFail($request->edit_product_id);
        
        $incomingProduct                 = IncomingProduct::findOrFail($id);
        $incomingProduct->created_at     = $request->edit_created_at;
        $incomingProduct->updated_at     = $request->edit_created_at;
        $incomingProduct->product_id     = $request->edit_product_id;
        
        $old_stock                       = $incomingProduct->stock_quantity;
        $incomingProduct->stock_quantity = $request->edit_stock;
        
        $incomingProduct->total          = $request->edit_stock * $product->unit_price;
        
        $incomingProduct->user_id        = \Auth::user()->id;
        
        // return ResponseFormatter::success($id, "Data transaksi berhasil diubah");
        if($incomingProduct->save()){
            $product->stock = ($product->stock - $old_stock) + $request->edit_stock;
            $product->save();
            return ResponseFormatter::success($incomingProduct, "Data transaksi berhasil diubah");

        }
        return ResponseFormatter::error(null, "Data transaksi gagal diubah", 200);

    }

    public function delete($id){
        $incomingProduct    = IncomingProduct::findOrFail($id);

        $stock              = $incomingProduct->stock_quantity;
        $product_id         = $incomingProduct->product_id;


        if($incomingProduct->delete())
        {
            $product        = Product::findOrFail($product_id);
            $product->stock -= $stock;
            $product->save();
            return ResponseFormatter::success($product, "Data transaksi berhasil dihapus");

        }
        return ResponseFormatter::error($product, "Data transaksi gagal dihapus! ", 200);

        $alert = [
            "type" => "alert-danger",
            "msg"  => "Data transaksi barang gagal dihapus!"
        ];
        return redirect()->route('incoming-product')->with($alert);
    }
}