<?php
namespace App\Repositories\CouponRepository;

use App\Models\Coupon;
use App\Models\Order;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class CouponRepository extends BaseRepository implements CouponInterfaceRepository{
    function getModel()
    {
        return \App\Models\Coupon::class;
    }

    function getAllByPaginate()
    {
        $coupons = $this->model->paginate(5);
        return $coupons;
    }

    function saveCoupon($data)
    {
        $this->create($data);
    }

    function getCouponId($id)
    {
        $coupon = $this->find($id);
        return $coupon;
    }

    function searchCoupon($search)
    {
        $coupon = $this->model->where("coupon_name_code", $search)->first();
        return $coupon;
    }

    function getPriceCoupon($coupon, $total_price){
        if($coupon->coupon_price_sale > 100){
            if($coupon->coupon_price_sale > $total_price){
                $total_price = 0;
            }else{
                $total_price = $total_price - $coupon->coupon_price_sale;
            }
        }else{
            $total_price = $total_price - (($total_price * $coupon->coupon_price_sale) / 100);
        }
        return $total_price;
    }

    function updateCoupon($id, $data)
    {
        $this->update($id, $data);
    }

    function deleteSoft($id)
    {
        $this->delete($id);    
    }

    function getCouponTrash()
    {
        $coupon_delete = Coupon::onlyTrashed()->get();
        return $coupon_delete;
    }

    function deleteOrRestore($id, $type)
    {
        $coupon = coupon::withTrashed()->where('coupon_id', $id)->first();
        if($type == -1){
            $coupon->restore();
        }else{
            $coupon->forceDelete();
        }
    }

    function checkCoupon($code_sale)
    {
        $output = '';
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = Coupon::where('coupon_name_code', $code_sale)->where('coupon_date_start', '<=',  $now)->where('coupon_date_end', '>=', $now)->first();
        $orders = Order::where('customer_id', session()->get('customer_id'))->get();
        if( $coupon && $coupon->coupon_qty_code == 0 ){
            $output .= 'không';
        }else{
            if(count($orders) > 0 && $coupon){
                $i = 0;
                
                    foreach($orders as $order){
                        if($order->product_coupon == $coupon->coupon_name_code){
                            $i++;
                        }
                    } 
                if($i != 0){
                    $output .= 'trùng';
                }else{
                    if(!$coupon){
                        $output .= 'error';
                    }else{
                        session()->put('coupon-cart', $coupon);
                        $output .= 'success';
                    }
                }
            }else{
                if(!$coupon){
                    $output .= 'error';
                }else{
                    session()->put('coupon-cart', $coupon);
                    $output .= 'success';
                }
            }
        }
        echo $output;
    }
}