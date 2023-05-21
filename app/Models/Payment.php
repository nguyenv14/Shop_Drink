<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{

   use SoftDeletes;

   public $timestamps = false;
   protected $fillable = [
    'payment_method' ,  'payment_status' ,
   ]; 
   protected $primaryKey =  'payment_id'; /* Khóa Chính */
   protected $table =   'tbl_payment'; /* Tên Bảng */
}