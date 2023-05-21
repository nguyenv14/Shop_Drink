<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected $fillable = [
    'name_city' ,  'type' ,  /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'matp'; /* Khóa Chính */
   protected $table =   'tbl_tinhthanhpho'; /* Tên Bảng */
}
