<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\City;
use App\Models\Flashsale;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Coupon;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Customers;
use App\Models\Order;
use App\Repositories\CartRepository\CartInterfaceRepository;
use App\Repositories\CouponRepository\CouponInterfaceRepository;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    protected $cartRepository;
    protected $couponRepository;
    public function __construct(CartInterfaceRepository $cartInterfaceRepository, CouponInterfaceRepository $couponInterfaceRepository) {
        $this->cartRepository = $cartInterfaceRepository;
        $this->couponRepository = $couponInterfaceRepository;
    }

    public function show_cart(){
        $sizes = ProductType::where('product_type_status', 1)->get();
        $cities = City::whereIn('matp', [48,49])->get();
        if(session()->get('customer_id')){
            $customer_id = session()->get('customer_id');
            $customer = Customers::where('customer_id', $customer_id)->first();
            return view('pages.giohang.giohang')->with('customer', $customer)->with('cities', $cities)->with('sizes', $sizes);
        }else{
        return view('pages.giohang.giohang')->with(compact('sizes', 'cities'));
        }
    }

    public function save_cart(Request $request){
        $product_id = $request->product_id;
        $product_qty = $request->product_qty;
        $product_type = $request->product_type;
        $this->cartRepository->saveCart($product_id, $product_qty, $product_type);
    }

    public function delete_cart(Request $request){
        $rowId = $request->rowId;
        $this->cartRepository->deleteCart($rowId);
    }
    
    public function delete_all_cart(){
        $this->cartRepository->deleteAllCart();

    }

    public function load_cart(){
        $sizes = ProductType::get();
        $product_by_carts = Cart::content();
        $output = '';
        if(Cart::count() > 0){
            foreach($product_by_carts as $product){
                $output .= '
                <tr>
                <td><img src="'. url('public/fontend/assets/img/product/'.$product->options->product_image.'') .'" alt="" width="100px"></td>
                <td style="text-align: left;">'.$product->name .'</td>
                <td>
                    <select name="" id="type-product" data-quantity="'.$product->qty.'" data-rowid="'.$product->rowId.'" data-product_id="'.$product->options->product_id.'">';
                        foreach ($sizes as $size){
                            if($size->product_type_id == $product->options->product_type){
                                $output .= '<option selected value="'. $size->product_type_id.'">'. $size->product_type_name .' + '. number_format($size->product_type_price, '0', ',','.') .'đ</option>';
                            }
                            else{
                                $output .= '<option value="'. $size->product_type_id.'">'. $size->product_type_name.' + '. number_format($size->product_type_price, '0', ',','.') .'đ</option>';
                            }
                        }
                    $output .='</select>
                </td>
                <td>'.number_format($product->price, '0', ',', '.') .'đ</td>
    
                <td><input type="number" value="'. $product->qty .'" min="1" name="quantity" id="quantity" class="changequantity" data-cart_id="'.$product->rowId.'" width="20px"></td>';
                
                    $product_subtotal = $product->qty * $product->price;
                
                $output .= '<td>'. number_format($product_subtotal, '0', ',', '.') .'đ</td>
                <td class="deleted-btn"><i class="fas fa-trash-alt btn-deleted" data-rowId="'. $product->rowId .'" data-toggle="modal"
                    data-target="#Delete" ></i></td>
            </tr>';
            }
        }else{
            $output .= '<tr>
                    <td colspan="7" style="">Không có sản phẩm nào trong giỏ hàng. <a href="'.url('/cua-hang').'">Đi tới danh sách sản phẩm</a></td>
                </tr>';
        }
        $output .= '
        <tr class="table-foot">
            <td colspan="5">Tổng tiền</td>
            <td colspan="2">'. Cart::total(0, ',', '.') .'đ</td>
        </tr>';
        echo $output;
    }

    public function update_all_cart(Request $request){
        $this->cartRepository->updateQuantityCart($request->cart_id, $request->quantity);
    }

    // Load số lượng có trong cart
    public function load_quantity_cart(){
        $count = Cart::count();
        echo $count;
    }

    // Update size cart
    public function update_size_cart(Request $request){
        $row_id = $request->row_id;
        $size_id = $request->value;
        $product_id = $request->product_id; 
        $quantity = $request->quantity;
        $this->cartRepository->updateSizeCart($row_id, $size_id, $product_id, $quantity);
        
    }

    public function check_coupon(Request $request){
        $code_sale = $request->input;
        return $this->couponRepository->checkCoupon($code_sale);
    }
    
    public function load_coupon(){
        $output = '';
        if (session()->get('coupon-cart')){
            $coupon = session()->get('coupon-cart');
            if ($coupon->coupon_condition == 1){ 
                    $output .= '<div class="coupon-apply">
                    '. $coupon->coupon_name.': giảm giá '. $coupon->coupon_price_sale .'% <i class="fa-solid fa-circle-xmark"></i>
                        </div>';
            }else{
                    $output .='<div class="coupon-apply">
                        '.$coupon->coupon_name .': giảm giá '.number_format($coupon->coupon_price_sale, 0, '.',',') .'đ <i class="fa-solid fa-circle-xmark"></i>
                        </div>';
            }
        }else{
            $output .='<div class="coupon-apply" style="display:flex;justify-content:center;">
                        Chưa áp dụng mã giảm giá nào!
                        </div>';
        }
        echo $output;
    }

    public function delete_coupon(){
        if(session()->get('coupon-cart')){
            session()->forget('coupon-cart');
        }
        echo 'success';
    }

    public function caculator_fee(Request $request)
    {
        $data = $request->all(); 
            $this->cartRepository->calculateFee($data);
    }

    public function load_payment(){
        $output = '';
        $price_all_product = filter_var(Cart::total(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $price_all_product_sale = $price_all_product;
        if(session()->has('coupon-cart')){
            $coupon = session()->get('coupon-cart');
            $price_all_product_sale = $this->couponRepository->getPriceCoupon($coupon, $price_all_product_sale);
        }
        $total_price_all_product = $price_all_product_sale;    
        if(session()->has('fee')){
            $feeship = session()->get('fee');
            $total_price_all_product = $price_all_product_sale + $feeship['fee_feeship'];    
        }
        session()->put('total_price_all', $total_price_all_product);
        session()->save();
        $output .='<tr>
            <th>Tổng tiền</th>
            <td>'.number_format($price_all_product, 0, '.', ',').'đ</td>
        </tr>
        <tr>
            <th>Phiếu giảm giá</th>';

        if(!session()->has('coupon-cart')){
            $output .= '<td>Chưa Áp Dụng</td>';
        }else {
            if($coupon->coupon_price_sale > 100){
                $output .= '<td> - '.number_format($coupon->coupon_price_sale, 0, ',', '.').'đ</td>';
            }else{
                $output .= '<td> - '.number_format($coupon->coupon_price_sale, 0, ',', '.').'%</td>';
            }
        }
        $output .= '</tr>
        <tr>
            <th>Phí vận chuyển</th>';
        if(session()->has('fee')){
            $output .= '<td class="fee_feeship"> + '.number_format($feeship['fee_feeship'] , 0, '.', ',').'đ</td>';
        }else{
            $output .= '<td class="fee_feeship">Xác nhận địa chỉ</td>';
        }
        $output .= '</tr>  
        <tr>
            <th>Tổng cộng</th>
            <td>'.number_format($total_price_all_product, 0, '.', ',').'đ</td>
        </tr>';
        echo $output;
    }


    public function confirm_cart(Request $request){
        $shipping_name = $request->shipping_name;
        $shipping_phone = $request->shipping_phone;
        $shipping_email = $request->shipping_email;
        $shipping_home_number = $request-> shipping_home_number;
        $this->cartRepository->confirmCart($shipping_name, $shipping_phone, $shipping_email, $shipping_home_number);
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
}
