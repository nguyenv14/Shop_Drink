<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{

    use SoftDeletes;

    protected $dates = [
        'deleted_at' ,
       ]; 

    public $timestamps = false;
    protected $fillable = [
        'customer_id', 'shipping_id', 'payment_id', 'order_status', 'order_code', 'product_coupon', 'coupon_sale', 'product_fee', 'total_price', 'total_quantity', 'order_date'/* Trường Trong Bảng */
    ];
    protected $primaryKey = 'order_id'; /* Khóa Chính */
    protected $table = 'tbl_order'; /* Tên Bảng */
    public function payment()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id');
    }
    public function shipping()
    {
        return $this->belongsTo('App\Models\Shipping', 'shipping_id');
    }
}
