<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{

    use SoftDeletes;

    
    public $timestamps = false;

    protected $dates = [
        'deleted_at' ,
       ]; 

    protected $fillable = [
    'product_type_name' ,  'product_type_price' ,   /* Trường Trong Bảng */
   ]; 

   protected $primaryKey =  'product_type_id'; /* Khóa Chính */
   protected $table =   'tbl_product_type'; /* Tên Bảng */
   
}