<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Flashsale;
use App\Models\Product;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class FlashsaleController extends Controller
{
    public function all_product_flashsale(){
        $flashsales = Flashsale::paginate(3);
        return view('admin.Flashsale.all_product_flashsale')->with(compact('flashsales'));
    }
    
    public function load_product_flashsale(){
        $flashsale = Flashsale::paginate(3);
        $flashsale_check = Flashsale::first();
        $output =$this->print_flashsale($flashsale, $flashsale_check);
        echo $output;
    }

    public function print_flashsale($datas, $data){
        $output = '';
        if($data != null){

        
        foreach($datas as $key => $flashsale){
            $output .= '<tr>
           
            <td> '.$flashsale->product->product_name .'</td>
            
            <td>';
              
                $type_sale = 'Giảm giá theo ';
                if ($flashsale->flashsale_condition == 0) {
                    $type = '%';
                    $type_sale .= $type;
                } else {
                    $type = 'đ';
                    $type_sale .= $type;
                }
                // echo $type_sale;
               $output .= ' '.$type_sale.'</td>
            <td>'.number_format($flashsale->flashsale_percent, 0, ',', '.') . $type .'</td>
           
            <td>
                '.number_format($flashsale->product->product_price, 0, ',', '.') . 'đ' .'
            </td>

            <td>
                '. number_format($flashsale->flashsale_price_sale, 0, ',', '.') . 'đ' .'
            </td>
            <td>';
                if ($flashsale->flashsale_status == 1){ 
                    $output.= '<i style="color: rgb(52, 211, 52); font-size: 30px"
                        class="mdi mdi-toggle-switch btn-un-active"
                        data-flashsale_id="'. $flashsale->flashsale_id .'" data-status="0"></i>';
                }else{
                    $output.= '<i style="color: rgb(196, 203, 196); font-size: 30px"
                        class="mdi mdi-toggle-switch-off btn-un-active"
                        data-flashsale_id="'. $flashsale->flashsale_id .'" data-status="1"></i>';
                }
            $output .= '</td>

            <td>
                <button class="btn btn-inverse-danger btn-icon">
                    <a
                        href="'. url('admin/flashsale/edit-product-flashsale?flashsale_id=' . $flashsale->flashsale_id) .'">
                        <i style="font-size: 20px" class="mdi mdi-lead-pencil"></i>
                    </a>
                </button>
                <button class="btn btn-inverse-danger btn-icon">
                    <i style="font-size: 22px" class="mdi mdi-delete-sweep text-danger btn-delete"
                        data-flashsale_id="'. $flashsale->flashsale_id .'" data-toggle="modal"
                        data-target="#Delete"></i>
                </button>
            </td>
        </tr>';
            }
        }else{
            $output .= '
            <th colspan="7">
                Không có sản phẩm nào đang giảm giá
            </th>';
        }
        echo $output;
    }
    // flashsale_percent	Loại giảm 0:  giảm theo %, 1: giảm theo tiền

    public function add_product_flashsale(){
        $products = Product::where('flashsale_status', 0)->get();
        return view('admin.Flashsale.add_product_flashsale')->with(compact('products'));
    }  

    public function save_product_flashsale(Request $request){
        $data = $request->all();
        
        $product = Product::where('product_id', $data['product_id'])->first();
        $product_price = $product['product_price']; // Số tiền gốc
        
        $product_flashsale = new Flashsale();
        $product_flashsale['product_id'] = $data['product_id'];
        $product_flashsale['flashsale_condition'] = $data['flashsale_condition']; // loại giảm giá
        $product_flashsale['flashsale_percent'] = $data['flashsale_percent']; // mức giảm
        $product_flashsale['flashsale_status'] = $data['flashsale_status'];
        if($data['flashsale_condition'] == 0){
            $product_flashsale['flashsale_price_sale'] =  $product_price - ( $product_price / 100 ) *  $data['flashsale_percent'];
        }else{
            $product_flashsale['flashsale_price_sale'] = $product_price - $data['flashsale_percent'];
        }

        $product['flashsale_status'] = 1;

        $product->save();
        $product_flashsale->save();
        $this->message('success', 'Thêm Sản Phẩm Vào Mục Giảm Giá Thành Công');
        return Redirect('admin/flashsale/');
    }

    public function edit_product_flashsale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $flashsale_old = Flashsale::where('flashsale_id', $flashsale_id)->first();
        return view('admin.Flashsale.edit_product_flashsale')->with(compact('flashsale_old'));
    }

    public function update_product_flashsale(Request $request)
    {
        $data = $request->all();
        $product = Product::where('product_id', $data['product_id'])->first();
        $product_price = $product['product_price']; // Số tiền gốc
       
        $flashsale =  Flashsale::where('flashsale_id', $data['flashsale_id'])->first();
     
        $flashsale['flashsale_condition'] =  $data['flashsale_condition'];
        $flashsale['flashsale_percent'] =  $data['flashsale_percent'];
        
        if($data['flashsale_condition'] == 0){
            $flashsale['flashsale_price_sale'] =  $product_price - ( $product_price / 100 ) *  $data['flashsale_percent'];
        }else{
            $flashsale['flashsale_price_sale'] = $product_price - $data['flashsale_percent'];
        }
         $flashsale->save();
       
         $this->message("success","Cập Nhật Sản Phẩm Flashsale Thành Công!");
         return redirect('/admin/flashsale/all-product-flashsale');
    }

    public function un_active_flashsale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $status = $request->status;

        $flashsale = Flashsale::where('flashsale_id', $flashsale_id)->first();
        // dd($flashsale);
        $product = Product::where('product_id', $flashsale['product_id'])->first();

        $product->flashsale_status = $status;
        $flashsale->flashsale_status = $status;
        $product->save();
        $flashsale->save();
    }

    public function delete_product_flashsale(Request $request){
        $flash_id = $request->flashsale_id;

        $product_flashsale = Flashsale::where('flashsale_id', $flash_id)->first();
        $product = Product::where('product_id', $product_flashsale['product_id'])->first();
        
        $product_flashsale->delete();
        $product['flashsale_status'] = 0;
        $product->save();
    }



    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}
