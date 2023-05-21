<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
   
    public $timestamps = false;

    protected $dates = [
        'deleted_at' ,
       ]; 

    protected $fillable = [
    'product_name' , 'category_id', 'product_image', 'product_price' ,'product_desc' ,  'product_status' , 'flashsale_status' /* Trường Trong Bảng */
   ]; 

   protected $primaryKey =  'product_id'; /* Khóa Chính */
   protected $table = 'tbl_product'; /* Tên Bảng */


    public function category(){
        return $this->belongsTo('App\Models\Category','category_id'); /* Lấy id của model Category so sánh với category_id */
    }

    public function flashsale(){
        return $this->belongsTo('App\Models\Flashsale', 'product_id', 'product_id'); // tham số thứ 2 lấy từ tbl_product và tham số thứ 3 lấy từ tbl_flashsale
    }
}