<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{

   use SoftDeletes;

  
   public $timestamps = false;

   protected $dates = [
      'deleted_at' ,
     ]; 
   protected $fillable = [
    'slider_name' ,  'slider_image' ,   'slider_status' ,   'slider_desc' /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'slider_id'; /* Khóa Chính */
   protected $table =   'tbl_slider'; /* Tên Bảng */

   
   // Tìm slider có id = $slider_id
   public function find_slider_byId($slider_id){
      $slider = Slider::where( 'slider_id', $slider_id)->first();
      return $slider;
  }
}