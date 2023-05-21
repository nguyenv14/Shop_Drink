<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
   public $timestamps = false;
   protected $fillable = [
    'fee_matp' ,  'fee_maqh' ,   'fee_maxp' ,   'fee_feeship' ,     /* Trường Trong Bảng */
   ]; 
   protected $primaryKey =  'fee_id'; /* Khóa Chính */
   protected $table =   'tbl_feeship'; /* Tên Bảng */

   
   public function city(){
      return $this->belongsTo('App\Models\City','fee_matp'); /* Lấy id của model city so sánh với fee_matp */
  }

  public function province(){
      return $this->belongsTo('App\Models\Province','fee_maqh');
  }

  public function wards(){
      return $this->belongsTo('App\Models\Wards','fee_maxp');
      
  }
}
