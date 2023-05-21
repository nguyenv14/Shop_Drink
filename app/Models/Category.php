<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    
    public $timestamps = false;

    protected $dates = [
        'deleted_at' ,
       ]; 

    protected $fillable = [
    'category_name' ,  'category_desc' ,  'category_status' , /* Trường Trong Bảng */
   ]; 

   protected $primaryKey =  'category_id'; /* Khóa Chính */
   protected $table =   'tbl_category'; /* Tên Bảng */
}