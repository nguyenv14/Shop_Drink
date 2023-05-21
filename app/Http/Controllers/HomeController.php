<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Flashsale;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slider;
use Illuminate\Http\Request;

session_start();
class HomeController extends Controller
{
    public function index(Request $request)
    {

        $dataSlider = Slider::where('slider_status', 1)->get();
        $dataCoupon = Coupon::inRandomOrder()->take(2)->get();
        $dataProduct = Product::where('product_status', 1)->where('flashsale_status', 0)->orderBy('product_id', 'DESC')->take(4)->get();
        $dataProduct_flashsale = Flashsale::where('flashsale_status', 1)->get();

        $new_big = News::where('display', 1)->orderby('id_news', "DESC")->first();

        $new_smalls = News::where('display', 1)->whereNotIn('id_news', [$new_big->id_news])->orderby('id_news', "DESC")->take(4)->get();
        $new_banner = News::inRandomorder()->first();
        // dd($new_smalls);
        return view('pages.home.trangchu')->with(compact('dataSlider', 'dataCoupon', 'dataProduct', 'dataProduct_flashsale', 'new_big', 'new_smalls', 'new_banner'));
        // ->with(compact('dataCategory', 'all_product','flashsale','coupons'));
    }
 

    public function sort_max_price_product()
    {
        $dataproduct = Product::orderby('product_price', 'desc')
            ->where('flashsale_status', '0')
            ->take(6)
            ->get();
        $output = $this->output_table_product($dataproduct);
        echo $output;
    }
    public function sort_min_price_product()
    {
        $dataproduct = Product::orderby('product_price', 'asc')
            ->where('flashsale_status', '0')
            ->take(6)
            ->get();
        $output = $this->output_table_product($dataproduct);
        echo $output;
    }

    public function sort_newproduct()
    {
        $dataproduct = Product::orderby('created_at', 'desc')
            ->where('flashsale_status', '0')
            ->take(6)
            ->get();
        $output = $this->output_table_product($dataproduct);
        echo $output;
    }

    public function search_by_voice(Request $request)
    {

        $dataproduct = Product::where('product_name', 'like', '%' . $request->keysearch . '%')
            ->where('flashsale_status', '0')
            ->take(6)
            ->get();

        $output = $this->output_table_product($dataproduct);
        echo $output;
    }


    /* Search */
    public function search_product(Request $request)
    {
        $text = $request->text;

        $products = Product::where('product_name', 'like', '%' . $text . '%')->get();
        $output = '';
        foreach ($products as $key => $product) {
            $output .= '
            <div class="infosearchhotel">
                <div class="infosearchhotel-img">
                <a href="'. url('/san-pham/san-pham-chi-tiet?product_id='.$product->product_id.'') .'" class="flashsalehotel_boxcontent_hover">
                    <img width="100px" height="70px" style="border-radius: 8px;object-fit: cover;" src="public/fontend/assets/img/product/'.$product->product_image.'" alt="">
                    </a>
                </div>
                <div class="infosearchhotel-text">
                    <div class="infosearchhotel-name">

                        '.$product->product_name.'

                    </div>
                    <div class="infosearchhotel-place">
                        <i class="fa-solid fa-location-dot"></i>
                        '.$product->category->category_name.'
                    </div>
                </div>
            </div>
            ';
        }
        echo $output;
    }

    




    //  Show detail product at home page 

    public function show_detail_product(Request $request)
    {
        $product_id = $request->product_id;

        $product = Product::where('product_id', $product_id)->first();
        $flashsale = Flashsale::where('product_id', $product_id)->where('flashsale_status', 1)->first();

        $sizes = ProductType::get();

        $output = '';

        $output = '<div class="row">
      <div class="col-lg-5 col-sm-12 img">
          <img class="flashsalehotel_img" width="284px" height="160px" style="object-fit: cover;"
          src="public/fontend/assets/img/product/' . $product->product_image . '" alt="">
      </div>
      <div class="col-lg-7 col-sm-12">
      <input type="text" id="product_id" name="product_id" hidden value="' . $product_id . '">
            <div class="product_name">
            <h2>' . $product->product_name . '</h2>
               </div>
          <div class="flashsalehotel_place">
              <div  class="category_name">
                  <i class="fa-solid fa-certificate"></i>
                  ' . $product->category->category_name . '
              </div>
              <br>';
        if ($flashsale != null) {
            $output .= '<div class="price">
               ' . number_format($flashsale->flashsale_price_sale, 0, ',', '.') . 'đ / <span style="text-decoration: line-through;">' . number_format($product->product_price, 0, ',', '.') . 'đ</span> 
           </div>';
        } else {
            $output .= '<div class="price">
               ' . number_format($product->product_price, 0, ',', '.') . 'đ
           </div>';
        }

        $output .= ' </div><hr width="100%">
          <!-- <hr width="30%"> -->
          <div class="product-size-box">
              <div class="product-size">';
        foreach ($sizes as $key => $size) {
            $output .= ' <div class="size-main">
                     <label class="size-detail" for="' . $size->product_type_id . '"><i class="fas fa-coffee"></i> ' . $size->product_type_name . ' + ' . number_format($size->product_type_price, 0, ',', '.') . 'đ</label>
                     <input id="' . $size->product_type_id . '" value="'.$size->product_type_id.'" type="radio" name="size" hidden>
                    </div>';
        }


        $output .= '</div>
          </div>
          <hr>
          <div class="row quantity_row">
              <div class="quantity-class">
                  <span>Quantity: </span> <input id="quantity" type="number" min="1" max="100" value="1">
              </div>
          </div>
      </div>
    </div>';
        echo $output;
    }


    public function edit_price(Request $request){
        $product_type_id = $request->product_type_id;
        $product_id = $request->product_id;

        $product = Product::where('product_id', $product_id)->first();
        $size = ProductType::where('product_type_id', $product_type_id)->first();
        $output = '';
        if($product->flashsale != null){
            $output .= ''.number_format($product->flashsale->flashsale_price_sale + $size->product_type_price, 0, ',', '.') . 'đ / 
            <span style="text-decoration: line-through;">' . number_format($product->product_price + $size->product_type_price, 0, ',', '.') . 'đ</span>';
        }else{
            $output .= ''.number_format($product->product_price + $size->product_type_price, 0, ',', '.') . 'đ';
        }
        echo $output;
    }







    // trang danh sách sản phẩm

    public function danh_sach_san_pham(){
        $all_product = Product::paginate(6);
        $product_price_min = Product::orderBy('product_price', 'ASC')->first();
        $product_price_max = Product::orderBy('product_price', "DESC")->first();
        // dd($product_price_max);
        $price_max = $product_price_max->product_price;
        $price_min = $product_price_min->product_price; 
        
        $dataCategory = Category::get();
        return view('pages.home.danhsachsanpham')->with(compact('all_product', 'dataCategory', 'price_max', 'price_min'));
    }

    public function load_danh_sach_san_pham(){
        $all_product = Product::where('product_status', 1)->orderBy('product_id', 'ASC')->get();
        $output = $this->print_danh_sach_san_pham($all_product);
        echo $output;  
    }

    public function print_danh_sach_san_pham($datas){

        $output = '';
        foreach($datas as $key => $data){
            $output .= '
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="flashsalehotel_boxcontent item">
                    <div class="flashsalehotel_boxcontent_img_text">
                        <div class="flashsalehotel_img-box">
                            <a href="san-pham/san-pham-chi-tiet?product_id='.$data->product_id.'" class="flashsalehotel_boxcontent_hover">
                                <img class="flashsalehotel_img" width="284px" height="160px" style="object-fit: cover;"
                                src="public/fontend/assets/img/product/'.$data->product_image.'" alt="">
                            </a>
                   
                        </div>
                        <div class="flashsalehotel_text">
                            <div class="flashsalehotel_text-title">
                                '.$data->product_name.'
                            </div>
                            <div class="flashsalehotel_place">
                                <div>
                                    <i class="fa-solid fa-certificate"></i>
                                    '.$data->category->category_name.'
                                </div>
                            </div>
                            ';
                            if(isset($data->flashsale)){
                                $output .= '<div class="flashsalehotel_text-time">
                                Giảm giá
                            </div>';
                            }else{
                                $output .= '
                                <div class="flashsalehotel_text-time">
                                    Sản phẩm
                                </div>';
                            }
                            $output .= '
                            <div class="flashsalehotel_text-box-price">
                           
                                ';
                                if(!isset($data->flashsale)){
                                    $output .= '
                                    <div class="flashsalehotel_text-box-price-two">
                                    <span>'. number_format($data->product_price, 0,',','.').'đ</span>
                                    </div>';
                                }else{
                                    $output .= '
                                    <div style="display: flex; justify-content:right">
                                    <div class="flashsalehotel_text-box-price-two">
                                    <span>'. number_format($data->flashsale->flashsale_price_sale, 0,',','.').'đ</span>
                                    </div>
                                    <div class="flashsalehotel_text-box-price-one">
                                        <span>/</span>
                                    </div>
                                    <div class="flashsalehotel_text-box-price-one">
                                        <span style="text-decoration: line-through">'.number_format($data->product_price, 0,',','.') .'đ</span>
                                    </div>
                                    </div>
                                    ';
                                }
                                $output .= '
                                
                                <div class="flashsalehotel_text-box-price-three bordernhay">
                                    <div style="margin-left: 8px;"
                                        class="flashsalehotel_text-box-price-three-l chunhay">
                                        <div class="cart-hover">
                                            <i class="fa-solid fa-heart"></i>
                                            <span style="font-size: 14px;">Yêu Thích</span>
                                        </div>
                                    </div>
                                    <div class="flashsalehotel_text-box-price-three-r chunhay">
                                        <div class="cart-hover" data-toggle="modal" data-target="#shopping" data-product_id="'.$data->product_id.'">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span style="font-size: 14px;">Đặt Hàng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
            </div>
            ';
        }
        echo $output;
    }

    // filter
    public function search_san_pham(Request $request){
        // dd($request->list_id);
        $list_category = $request->list_id;
        $text = $request->text;
        $value_option = $request->value_option;
        $type_option = $request->type_option;
        $price_min = $request->price_min;
        $price_max = $request->price_max;
        if($request->list_id){
            $products = Product::where('product_price', '>=', $price_min)->whereIn('category_id', $list_category)->where('product_price', '<=', $price_max)->where('product_name', 'like', '%' . $text . '%')->orderBy($type_option, $value_option)->get();
        }else{
            $products = Product::where('product_price', '>=', $price_min)->where('product_price', '<=', $price_max)->where('product_name', 'like', '%' . $text . '%')->orderBy($type_option, $value_option)->get();
        }
        
        // dd($price_min + $price_max);
        $output = $this->print_danh_sach_san_pham($products);
        echo $output;
    }





    public function message($type, $content)
    {
        $message = array(
            "type" => $type,
            "content" => $content,
        );
        session()->put('message', $message);
    }
}
