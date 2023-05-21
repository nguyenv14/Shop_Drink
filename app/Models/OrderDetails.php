<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{

   use SoftDeletes;

   protected $dates = [
      'deleted_at' ,
     ]; 

   public $timestamps = false;
   protected $fillable = [
    'order_code' ,  'product_id' ,   'product_name' ,   'product_price' ,   'product_sales_quantity' , /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'order_details_id'; /* Khóa Chính */
   protected $table =   'tbl_order_details'; /* Tên Bảng */

   public function product(){
      return $this->belongsTo('App\Models\Product','product_id');
   }
}