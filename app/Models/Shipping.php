<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{

   use SoftDeletes;

   protected $dates = [
      'deleted_at' ,
     ]; 

   public $timestamps = false;
   protected $fillable = [
    'shipping_name' ,  'shipping_email' ,   'shipping_phone' ,   'shipping_address' ,   'shipping_notes' , 'shipping_special_requirements' , 'shipping_receipt' /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'shipping_id'; /* Khóa Chính */
   protected $table =   'tbl_shipping'; /* Tên Bảng */
}