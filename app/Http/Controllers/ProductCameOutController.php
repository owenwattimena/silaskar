<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCameOut;
use App\Helpers\ResponseFormatter;

class ProductCameOutController extends Controller
{
    //
    public function index()
    {
        $data['products'] = Product::orderBy('name', 'asc')->get();
        // $data['productsCameOut'] = ProductCameOut::with('product')->orderBy('id', 'desc')->get();
        return view('product-came-out.index', $data);
    }
    
    public function all(){
        $productsCameOut = ProductCameOut::with(['product', 'user', 'division'])->orderBy('id', 'desc')->get();
        return ResponseFormatter::success($productsCameOut, "Data berhasil diambil.");
    }
    
    public function aproved(Request $request, $id)
    {
        $productsCameOut = ProductCameOut::findOrFail($id);
        
        $productsCameOut->status = "Disetujui";
        $productsCameOut->description = null;

        
        $product = Product::findOrFail($productsCameOut->product_id);
        
        $product->stock = $product->stock - $productsCameOut->stock_quantity;
        
        if($product->stock >= 0){
            if($productsCameOut->save()){
                $product->save();

                $alert = [
                    "type" => "alert-success",
                    "msg"  => "Data pengadaan berhasil disetujui!"
                ];
                return redirect()->route('product-came-out')->with($alert);
            }
            else{
                $alert = [
                    "type" => "alert-danger",
                    "msg"  => "Data pengadaan gagal disetujui!"
                ];
                return redirect()->route('product-came-out')->with($alert);
            }
        }
        $alert = [
            "type" => "alert-danger",
            "msg"  => "Data pengadaan gagal disetujui! Stok " . $product->name . " tidak mencukupi"
        ];
        return redirect()->route('product-came-out')->with($alert);
    }
    
    public function rejected(Request $request, $id)
    {
        $productsCameOut = ProductCameOut::findOrFail($id);
        
        $productsCameOut->status = "Ditolak";
        $productsCameOut->description = $request->description;
        
        $product = Product::findOrFail($productsCameOut->product_id);
        
        if($productsCameOut->created_at != $productsCameOut->updated_at){
            $product->stock = $product->stock + $productsCameOut->stock_quantity;
        }
        
        if($productsCameOut->save()){
            if($productsCameOut->created_at != $productsCameOut->updated_at){
                $product->save();
            }
            $alert = [
                "type" => "alert-success",
                "msg"  => "Data pengadaan berhasil ditolak!"
            ];
            return redirect()->route('product-came-out')->with($alert);
        }
        
        $alert = [
            "type" => "alert-danger",
            "msg"  => "Data pengadaan gagal ditolak!"
        ];
        return redirect()->route('product-came-out')->with($alert);
        
    }
}