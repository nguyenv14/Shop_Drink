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
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    public function show_cart(){
        // session()->flush();
        // dd(Cart::total());
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
        // dd($request);
        $id = substr(md5(microtime()), rand(0,26),5);
        $product_id = $request->product_id;
        $product_qty = $request->product_qty;
        $product_type = $request->product_type;

        $product_type_detail = ProductType::where('product_type_id', $product_type)->first();
        $product_type_price = $product_type_detail->product_type_price;
        // Sản phẩm bấm thêm vào giỏ
        $product_cart = Product::where('product_id', $product_id)->first();
        $product_image = $product_cart->product_image;
        $product_name = $product_cart->product_name;
        $product_price = $product_cart->product_price;
        if($product_cart->flashsale){
            $product_price = $product_cart->flashsale->flashsale_price_sale;
        }

        $product_price = $product_price + $product_type_price;
        Cart::setGlobalTax(0);        
        // dd(Cart::count());
       
            foreach(Cart::content() as $key => $cart){
                if( $cart->options->product_type == $product_type && $cart->options->product_id == $product_id){
                    $quantity = $cart->qty + $product_qty;
                    $rowId = $cart->rowId;
                    Cart::update($rowId, ['qty' => $quantity]);
                    // dd(Cart::content());
                    return 0;
                }
            //     else{
            //         // dd(Cart::content());
            //         Cart::add([
            //             'id' => $id,
            //             'name' => $product_name,
            //             'price' => $product_price,
            //             'weight' => 0,
            //             'qty' => $product_qty,
            //             'options' => [
            //                 'product_image' => $product_image,
            //                 'product_id' => $product_id,
            //                 'product_type' => $product_type,
            //                 'product_type_price' => $product_type_price
            //                 ]
            //             ]);
            //         // Cart::destroy();
            //         return 0;
            // }
        }
        Cart::add([
            'id' => $id,
            'name' => $product_name,
            'price' => $product_price,
            'weight' => 0,
            'qty' => $product_qty,
            'options' => [
                'product_image' => $product_image,
                'product_id' => $product_id,
                'product_type' => $product_type,
                'product_type_price' => $product_type_price
            ]
        ]);
        // Cart::content();
        // Cart::destroy();
    }

    public function delete_cart(Request $request){
        $rowId = $request->rowId;
        Cart::remove($rowId);
    }
    
    public function delete_all_cart(Request $request){
        Cart::destroy();
    }

    public function load_cart(){
        $sizes = ProductType::get();
        $product_by_carts = Cart::content();
        $output = '';
        
        if(Cart::count() != 0){
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
        // $total_price = (float) Cart::total();
        $output .= '
        <tr class="table-foot">
            <td colspan="5">Tổng tiền</td>
            <td colspan="2">'. Cart::total(0, ',', '.') .'đ</td>
        </tr>';
        

        echo $output;
    }

    public function update_all_cart(Request $request){
        $rowId = $request->cart_id;
        $quantity = $request->quantity;
        // dd(Cart::content());
        Cart::update($rowId, ['qty' => $quantity]);
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
        $quatity = $request->quantity;

        $size = ProductType::where('product_type_id', $size_id)->first();

        $size_price = $size->product_type_price;
        
        foreach(Cart::content() as $product_cart){
            if($product_id == $product_cart->options->product_id && $size_id == $product_cart->options->product_type && $row_id != $product_cart->rowId){
                // dd($product_id . " " . $product_cart->options->product_id);
                // dd($size_id . " " . $product_cart->options->product_type);
                // dd($row_id . " " . $product_cart->rowId);

                $quantity_product = $quatity + $product_cart->qty;
                // $product_price = $product_cart->price - $product_cart->options->product_type_price + $size_price;
                Cart::update($product_cart->rowId, ['qty' => $quantity_product]);
                Cart::remove($row_id);
                return 0;
            }
        }

        $product_cart = Cart::get($row_id);

        $product_price = $product_cart->price - $product_cart->options->product_type_price + $size_price;

        Cart::update($row_id, ['price'=> $product_price, 'options' => ['product_type' => $size_id, 'product_id' => $product_id ,'product_type_price' => $size_price , 'product_image' => $product_cart->options->product_image]]);
    }


    public function check_coupon(Request $request){
        $code_sale = $request->input;
        $output = '';
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = Coupon::where('coupon_name_code', $code_sale)->where('coupon_date_start', '<=',  $now)->where('coupon_date_end', '>=', $now)->first();
        // dd($coupon);
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
        
            $feeship = Feeship::where('fee_matp', $data['id_city'])->where('fee_maqh', $data['id_province'])->where('fee_maxp', $data['id_wards'])->first();
            if ($feeship != null) {
                $fee = array(
                    'fee_id_city' => $feeship->fee_matp,
                    'fee_name_city' => $feeship->city->name_city,
                    'fee_id_province' =>$feeship->fee_maqh,
                    'fee_name_province' => $feeship->province->name_province,
                    'fee_id_wards' =>$feeship->fee_maxp,
                    'fee_name_wards' => $feeship->wards->name_ward,
                    'fee_feeship' =>  $feeship->fee_feeship,
                );

                session()->put('fee', $fee);
                session()->save();
            } else {
                $city = City::where('matp', $data['id_city'])->first();
                $province = Province::where('maqh', $data['id_province'])->first();
                $wards = Wards::where('xaid', $data['id_wards'])->first();    
                $fee = array(
                    'fee_id_city' =>  $city->matp,
                    'fee_name_city' => $city->name_city,
                    'fee_id_province' =>$province->maqh ,
                    'fee_name_province' => $province->name_province,
                    'fee_id_wards' =>$wards->xaid,
                    'fee_name_wards' => $wards->name_ward,
                    'fee_feeship' => 30000,
                );

                session()->put('fee', $fee);
                session()->save();
            }
    }


    public function load_payment(){
        $output = '';
        $price_all_product = filter_var(Cart::total(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        // dd($price_all_product);
        $price_all_product_sale = $price_all_product;
        if(session()->has('coupon-cart')){
            $coupon = session()->get('coupon-cart');
            
            if($coupon->coupon_condition == 1){
                $price_sale = ($price_all_product * $coupon->coupon_price_sale) / 100;
                $price_all_product_sale = $price_all_product - $price_sale; 
            }else{
                $price_sale = $coupon->coupon_price_sale;
                if($price_sale > $price_all_product){
                    $price_all_product_sale = 0;
                }else{
                    $price_all_product_sale = $price_all_product - $price_sale; 
                }
            }
        }

        $total_price_all_product = $price_all_product_sale;    
        if(session()->has('fee')){
            $feeship = session()->get('fee');
            $total_price_all_product = $price_all_product_sale + $feeship['fee_feeship'];    
        }
        // $data = array(
        //     'total_price_all' => $total_price_all_product
        // );

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
        }else{
            $output .= '<td> - '.number_format($price_sale, 0, ',', '.').'đ</td>';
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
        $fee = session()->get('fee');
        $shipping_name = $request->shipping_name;
        $shipping_phone = $request->shipping_phone;
        $shipping_email = $request->shipping_email;
        $shipping_home_number = $request-> shipping_home_number;
        // dd($shipping_home_number);
        $shipping_address =  $shipping_home_number.', '. $fee['fee_name_wards'].', '.$fee['fee_name_province'].', '.$fee['fee_name_city'];

        $shipping = array(
            'shipping_name' =>  $shipping_name,
            'shipping_phone' => $shipping_phone,
            'shipping_email' => $shipping_email ,
            'shipping_address' => $shipping_address,
            'shipping_notes' => 'Không Có',
            'shipping_special_requirements' => 0,
        );
        session()->put('shipping',  $shipping);
        session()->save();

        $order_code_rd = 'TGHSOD' . rand(0001, 9999);
        session()->put('order_code_rd', $order_code_rd);
        echo "true";
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
}
