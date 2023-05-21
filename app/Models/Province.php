<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    public $timestamps = false;
    protected $fillable = [
    'name_province' ,  'type' ,  'matp' , /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'maqh'; /* Khóa Chính */
   protected $table =   'tbl_quanhuyen'; /* Tên Bảng */

}
