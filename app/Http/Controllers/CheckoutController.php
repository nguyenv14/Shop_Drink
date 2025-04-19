<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\ProductType;
use App\Models\Shipping;
use Carbon\Carbon;
// use OrderDetails;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

// use App\Repositories\CategoryRepository\CategoryRepositoryInterface;

// use Session;

session_start();
class CheckoutController extends Controller
{

    public function show_payment(){
        $sizes = ProductType::get();
        return view('pages.thanhtoan.thanh_toan')->with(compact('sizes'));
    }

    public function check_requirement_special(Request $request){
        $choose = $request->choosetwo;
        $output = '';
        $shipping = session()->get('shipping');
        if($choose == 1){
            $shipping['shipping_special_requirements'] = $choose;
            session()->put('shipping', $shipping);
            $output .= 'true';
        }else{
            $shipping['shipping_special_requirements'] = 0;
            session()->put('shipping', $shipping);
            $output .= 'false';
        }
        echo $output;
    }

    public function check_require_private(Request $request){
        $content_notes = $request->content_notes;
        $output = '';
        $shipping = session()->get('shipping');
        
        $shipping['shipping_notes'] = $content_notes;
        session()->put('shipping', $shipping);
        $output .= 'true';
        echo $output;
    }

    public function direct_payment()
    {
        $payment = array(
            'payment_method' => 4,
            'payment_status' => 0,
        );
        session()->put('payment', $payment);
        $this->order_insert();
        
        $this->message("success", "Đặt Hàng Thành Công!");
        return redirect('/thanh-toan/hoa-don');
    }


    public function order_insert(){

        $data_payment = session()->get('payment');
        $payment = new Payment();

        $payment['payment_method'] = $data_payment['payment_method'];
        $payment['payment_status'] = $data_payment['payment_status'];
        $payment->save();
        
        $payment = Payment::orderBy('payment_id', "DESC")->first();

        $shipping = new Shipping();
        $data_shipping = session()->get('shipping');
        $shipping->shipping_name = $data_shipping['shipping_name'];
        $shipping->shipping_email = $data_shipping['shipping_email'];
        $shipping->shipping_phone = $data_shipping['shipping_phone'];
        $shipping->shipping_address = $data_shipping['shipping_address'];
        $shipping->shipping_notes = $data_shipping['shipping_notes'];
        $shipping->shipping_special_requirements = $data_shipping['shipping_special_requirements'];
        $shipping->save();

        $shipping = Shipping::orderBy('shipping_id', 'DESC')->first();

        $fee = session()->get('fee');   
        $coupon = session()->get('coupon-cart');
        $coupon_name_code = '';
        if ($coupon != null) {
            $coupon_name_code = $coupon->coupon_name_code;
        } else {
            $coupon_name_code = 'Không có';
        }
        $coupon_get = Coupon::where('coupon_name_code', $coupon_name_code)->first();
        if($coupon_get){
            if($coupon_get->coupon_qty_code > 0){
                $coupon_get->coupon_qty_code -=1;
                $coupon_get->save();
            }
        }
        /*
        0: đơn hàng đang chờ được duyệt
        1: đơn hàng đã được duyệt 
        2: đơn hành đã hoàn thành
        3: đơn hàng đã bị hoàn trả
        -1: đơn hàng đã bị từ chối        
        */

        //Thêm Dữ Liệu Vào Bảng Order
        $order_code_rd = session()->get('order_code_rd');
        $order = new Order();
        $order->customer_id = 0;
        if (session()->get('customer_id')) {
            $order->customer_id = session()->get('customer_id');
        } else {
            $order->customer_id = -1;
        }
        $order->shipping_id = $shipping->shipping_id;
        $order->payment_id = $payment->payment_id;
        $order->order_status = 0;
        $order->order_code = $order_code_rd;
        $order->product_coupon = $coupon_name_code;
        if($coupon_name_code == 'Không có')
        $order->coupon_sale = 0;
        else{
            $order->coupon_sale = $coupon_get->coupon_price_sale;
        }
        // $order->coupon_sale = $coupon_get->
        $order->product_fee = $fee['fee_feeship'];
        $order->total_price = session()->get('total_price_all');
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->total_quantity = Cart::count();
        $order->order_date = $now;
        $order->save();
        
        // Thêm dữ liệu order_detail
        foreach(Cart::content() as $cart){
            $order_Detail = new OrderDetails();
            $order_Detail->order_code = $order_code_rd;
            $order_Detail->product_id = $cart->options->product_id;
            $order_Detail->product_name = $cart->name;
            $order_Detail->product_price = $cart->price;
            $order_Detail->product_sales_quantity = $cart->qty;
            $order_Detail->save();
        }
        $this->email_order_customer(); 
    }

    public function email_order_customer(){
        $order_code_rd = session()->get('order_code_rd');
        $shipping = session()->get('shipping');
        $fee = session()->get('fee');
        $coupon = session()->get('coupon-cart');

        $mail_customer = $shipping['shipping_email'];

        $to_name = "Nguyên Vĩnh - Mail BonoDrinks Shop";
        $to_email = $mail_customer;

        $data = array(
            "order_code_rd" => $order_code_rd,
            "shipping" => $shipping,
            "fee" => $fee,
            "coupon" => $coupon,
            "cart" => Cart::content(),
        );

        Mail::send('pages.hoadon.email_khachhang', $data, function($message) use ($to_name, $to_email){
            $message->to($to_email)->subject('BonoDrinks - Đơn hàng đang được duyệt');
            $message->from($to_email, $to_name); //send from this mail
        }); 
    }

    public function show_receipt()
    {
        if (session()->get('fee') != null && Cart::content() != null && session()->get('shipping') != null) {
            return view('pages.hoadon.hoa_don');
        } else {
            return redirect('/');
        }

    }
    public function un_set_order()
    {
        session()->forget('payment');
        session()->forget('cart');
        session()->forget('shipping');
        session()->forget('fee');
        session()->forget('coupon-cart');
        session()->forget('total_price_all');
        session()->forget('order_code_rd');
    }


       /* TK TEST MOMO */
    /*
    Số Thẻ : 9704 0000 0000 0018
    Tên Chủ Thẻ : NGUYEN VAN A
    Ngày Phát Hành : 03/07
    OTP : OTP
    SDT : 0987654321
     */

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momo_payment()
    {
        $order_code_rd = session()->get('order_code_rd');
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderId = $order_code_rd . rand(0000, 9999); // Mã đơn hàng
        $orderInfo = "Thanh toán qua MoMo";
        $amount = session()->get('total_price_all');
        $redirectUrl = url('thanh-toan/momo-payment-callback?order_code='.$order_code_rd.'');
        $ipnUrl = url('thanh-toan/momo-payment-callback?order_code='.$order_code_rd.'');
        $extraData = "";
        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true); // decode json

        return redirect($jsonResult['payUrl']);
    }

    public function momo_payment_callback(Request $request)
    {

        if($request->message =='Successful.'){
        $payment = array(
            'payment_method' => 1,
            'payment_status' => 1,
        );
        session()->put('payment', $payment);
        $this->order_insert();
        $this->message("success", "Thanh Toán Bằng Momo Thành Công, Đơn Hàng Của Bạn Đã Được Ghi Lại!");
        return redirect('/thanh-toan/hoa-don');
        // MansssipulationActivity::noteManipulationCustomer( "Đặt Hàng Và Thanh Toán Thành Công Đơn Hàng Bằng Momo Thành Công!");
        }else{
            $this->message("warning", "Đã Xãy Ra Lỗi Khi Thanh Toán , Vui Lòng Thanh Toán Lại!");
            return redirect('/thanh-toan');
        }
    }


    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }

}
