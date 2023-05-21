<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Statistical extends Model
{

    // use SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
    'order_date', 'sales', 'order_boom', 'total_price_boom', 'quantity', 'total_order' /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'statistical_id'; /* Khóa Chính */
   protected $table =   'tbl_statistical'; /* Tên Bảng */    
}