<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Flashsale;
use App\Models\Product;
use App\Repositories\FlashsaleRepository\FlashsaleInterfaceRepository;
use App\Repositories\FlashsaleRepository\FlashsaleRepository;
use App\Repositories\ProductRepository\ProductInterfaceRepository;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class FlashsaleController extends Controller
{   
    protected $productRepository;
    protected $flashsaleRepository;

    public function __construct(ProductInterfaceRepository $productInterfaceRepository, FlashsaleInterfaceRepository $flashsaleInterfaceRepository)
    {
        $this->productRepository = $productInterfaceRepository;
        $this->flashsaleRepository = $flashsaleInterfaceRepository;
    }

    public function all_product_flashsale(){
        $flashsales = $this->flashsaleRepository->getAllByPaginate();
        return view('admin.Flashsale.all_product_flashsale')->with(compact('flashsales'));
    }
    
    public function load_product_flashsale(){
        $flashsale = $this->flashsaleRepository->getAllByPaginate();
        $flashsale_check = Flashsale::first();
        $output =$this->print_flashsale($flashsale, $flashsale_check);
        echo $output;
    }

    public function print_flashsale($datas, $data){
        $output = '';
        if($datas->count() > 0){

        
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
        $this->flashsaleRepository->saveProductToFlashsale($request->all());
        $this->message('success', 'Thêm Sản Phẩm Vào Mục Giảm Giá Thành Công');
        return Redirect('admin/flashsale/');
    }

    public function edit_product_flashsale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $flashsale_old = $this->flashsaleRepository->getFlashsaleId($flashsale_id);
        return view('admin.Flashsale.edit_product_flashsale')->with(compact('flashsale_old'));
    }

    public function update_product_flashsale(Request $request)
    {
        $data = $request->all();
        $this->flashsaleRepository->updateFlashsale($data);
        $this->message("success","Cập Nhật Sản Phẩm Flashsale Thành Công!");
        return redirect('/admin/flashsale/all-product-flashsale');
    }

    public function un_active_flashsale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $status = $request->status;
        $this->flashsaleRepository->unActiveFlashsale($flashsale_id, $status);

    }

    public function delete_product_flashsale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $this->flashsaleRepository->deleteFlashsale($flashsale_id);
    }



    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}
