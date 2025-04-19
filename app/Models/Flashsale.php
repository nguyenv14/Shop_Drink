<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Flashsale extends Model
{
   

    public $timestamps = false;

    protected $fillable = [
        'product_id',  'flashsale_condition',   'flashsale_percent',   'flashsale_price_sale', 'flashsale_status', 'deleted_at' /* Trường Trong Bảng */
    ];
    protected $primaryKey =  'flashsale_id'; /* Khóa Chính */
    protected $table =   'tbl_flashsale'; /* Tên Bảng */

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
