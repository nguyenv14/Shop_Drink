<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    public $timestamps = false;
    protected $fillable = [
    'name_ward' ,  'type' ,  'maqh' , /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'xaid'; /* Khóa Chính */
   protected $table =   'tbl_xaphuongthitran'; /* Tên Bảng */
}
