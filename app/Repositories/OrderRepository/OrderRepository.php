<?php
namespace App\Repositories\OrderRepository;

use App\Models\Coupon;
use App\Models\Customers;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductType;
use App\Models\Shipping;
use App\Repositories\BaseRepository;    
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class OrderRepository extends BaseRepository implements OrderInterfaceRepository{
    function getModel()
    {
        return \App\Models\Order::class;
    }

    function getListOrderDesc()
    {
        $order = $this->model->orderBy('order_id', "DESC")->get();
        return $order;
    }

    function filterOrder($order_status)
    {
        $orders = null;
        if($order_status == ''){
            $orders = Order::orderBy('order_id', "DESC")->get();
        }else{
            $orders = Order::where('order_status', $order_status)->orderBy('order_id', "DESC")->get();
        }
        return $orders;
    }

    function getOrderByCode($order_code)
    {
        $order = Order::where('order_code', $order_code)->first();
        return $order;
    }

    function getOrderByStatus($order_status)
    {
        
    }

    function getOrderById($order_id)
    {
        $order = $this->find($order_id);
        return $order;
    }

    function getOrderListByUser($customer_id)
    {
        
    }

    function getPaymentId($payment_id)
    {
        
    }

    function getCustomerId($customer_id)
    {
        $customer = Customers::where('customer_id', $customer_id)->first();
        return $customer;
    }

    function getOrderDetail($order_code)
    {
        $orderdetails = OrderDetails::where('order_code', $order_code)->get();
        return $orderdetails;
    }

    function getShippingId($shipping_id)
    {
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        return $shipping;
    }
}
