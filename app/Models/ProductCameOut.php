<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCameOut extends Model
{
    protected $table = "product_came_out";
    use HasFactory;

    public function product(){
        return $this->belongsTo("App\Models\Product", 'product_id', 'id');
    }
    
    public function user(){
        return $this->belongsTo("App\Models\User", 'user_id', 'id');
    }
   

    public function division(){
        return $this->belongsTo("App\Models\Division", 'division_id', 'id');
    }
}