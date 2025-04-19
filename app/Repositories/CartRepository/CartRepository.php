<?php
namespace App\Repositories\CartRepository;

use App\Models\City;
use App\Models\Customers;
use App\Models\Feeship;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Province;
use App\Models\Wards;
use App\Repositories\BaseRepository;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartRepository extends BaseRepository implements CartInterfaceRepository
{
    function getModel()
    {
        return Cart::class;
    }

    function showCart()
    {
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

    function saveCart($product_id, $product_qty, $product_type)
    {
        $id = substr(md5(microtime()), rand(0,26),5);
        $product_type_detail = ProductType::where('product_type_id', $product_type)->first();
        $product_type_price = $product_type_detail->product_type_price;
        $product_cart = Product::where('product_id', $product_id)->first();
        $product_image = $product_cart->product_image;
        $product_name = $product_cart->product_name;
        $product_price = $product_cart->product_price;
        if($product_cart->flashsale){
            $product_price = $product_cart->flashsale->flashsale_price_sale;
        }
        $product_price = $product_price + $product_type_price;
        Cart::setGlobalTax(0);        
            foreach(Cart::content() as $key => $cart){
                if( $cart->options->product_type == $product_type && $cart->options->product_id == $product_id){
                    $quantity = $cart->qty + $product_qty;
                    $rowId = $cart->rowId;
                    Cart::update($rowId, ['qty' => $quantity]);
                    // dd(Cart::content());
                    return 0;
                }
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
    }

    function deleteCart($id)
    {
        Cart::remove($id);
    }

    function deleteAllCart()
    {
        Cart::destroy();
    }

    function updateQuantityCart($id, $quantity)
    {
        // $rowId = $request->cart_id;
        // $quantity = $request->quantity;
        // dd(Cart::content());
        Cart::update($id, ['qty' => $quantity]);
    }

    function updateSizeCart($row_id, $size_id, $product_id, $quantity)
    {
        $size = ProductType::where('product_type_id', $size_id)->first();

        $size_price = $size->product_type_price;
        
        foreach(Cart::content() as $product_cart){
            if($product_id == $product_cart->options->product_id && $size_id == $product_cart->options->product_type && $row_id != $product_cart->rowId){
                $quantity_product = $quantity + $product_cart->qty;
                Cart::update($product_cart->rowId, ['qty' => $quantity_product]);
                Cart::remove($row_id);
                return 0;
            }
        }
        $product_cart = Cart::get($row_id);
        $product_price = $product_cart->price - $product_cart->options->product_type_price + $size_price;
        Cart::update($row_id, ['price'=> $product_price, 'options' => ['product_type' => $size_id, 'product_id' => $product_id ,'product_type_price' => $size_price , 'product_image' => $product_cart->options->product_image]]);
    }

    function getListCart()
    {
        
    }

    function calculateFee($data)
    {
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

    function confirmCart($shipping_name, $shipping_phone, $shipping_email, $shipping_home_number)
    {  
        $fee = session()->get('fee');
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
}