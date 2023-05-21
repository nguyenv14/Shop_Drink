<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at' ,
    ]; 


    public $timestamps = false;


    protected $fillable = [
    'coupon_name' ,  'coupon_name_code' , 'coupon_desc' ,  'coupon_qty_code' ,   'coupon_condition' ,   'coupon_price_sale' , 'coupon_date_start', 'coupon_date_end' /* Trường Trong Bảng */
   ]; 

   protected $primaryKey =  'coupon_id'; /* Khóa Chính */
   protected $table =   'tbl_coupon'; /* Tên Bảng */
}