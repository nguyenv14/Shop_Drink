<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GalleryProduct extends Model
{

   
    public $timestamps = false;



    protected $fillable = [
    'product_id' , 'gallery_image_product', 'gallery_image_name', 'gallery_image_content'  /* Trường Trong Bảng */
   ]; 

   protected $primaryKey =  'gallery_id'; /* Khóa Chính */
   protected $table =   'tbl_gallery_product'; /* Tên Bảng */

 
}