<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\ProductType;




// use App\Repositories\product_typeRepository\CategoryRepositoryInterface;

// use Session;

session_start();
class ProductTypeController extends Controller
{

    public function all_product_type(){
        $all_product_type = ProductType::get();
        // dd($all_category);
        return view('admin.Product_Type.all_product_type')->with('all_product_type', $all_product_type);
    }

    public function add_product_type(){
        return view('admin.Product_Type.add_product_type'); 
    }

    public function save_product_type(Request $request){
        $data = $request->all();
        $product_type = new ProductType();
        $product_type['product_type_name'] = $data['product_type_name'];
        $product_type['product_type_status'] = $data['product_type_status'];
        $product_type['product_type_price'] = $data['product_type_price'];
        

        $product_type->save();
        return Redirect('admin/product/product-type/all-product-type');
    }

    public function edit_product_type(Request $request){
        $product_type_id = $request->product_type_id;
        $product_type_old = ProductType::where('product_type_id', $product_type_id)->first();
        return view('admin.Product_Type.edit_product_type')->with('product_type_old', $product_type_old);
    }

    public function update_product_type(Request $request){
        $data = $request->all();
        $product_type = ProductType::where('product_type_id', $data['product_type_id'])->first();
        $product_type['product_type_name'] = $data['product_type_name'];
        $product_type['product_type_status'] = $data['product_type_status'];
        $product_type['product_type_price'] = $data['product_type_price'];
        
        $product_type->save();
        return Redirect('admin/product/product-type/all-product-type');
    }

    public function load_product_type(){
        $all_product_type = ProductType::get();
        $output = '';
        foreach($all_product_type as $key => $product_type){
            $output .= '<tr>
                <td>'. $product_type->product_type_id .'</td>
                <td>'. $product_type->product_type_name .'</td>
                <td>'. $product_type->product_type_price .'</td>
                <td>';
                if ($product_type->product_type_status == 1){       
                     $output .='  <i style="color: rgb(52, 211, 52); font-size: 30px" class="mdi mdi-toggle-switch btn-un-active" data-product_type_id="'.$product_type->product_type_id.'" data-status="0"></i>';
                }else{
                      $output .=' <i style="color: rgb(196, 203, 196);font-size: 30px" class="mdi mdi-toggle-switch-off btn-un-active" data-product_type_id="'.$product_type->product_type_id.'" data-status="1"></i>';
                }
                   $output .=' </td>
                <td>'.$product_type->created_at.'</td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-product_type" data-delete_id="' . $product_type->product_type_id . '"><i class="mdi mdi-delete" ></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon"><a href="'.url('admin/product/product-type/edit-product-type?product_type_id=' . $product_type->product_type_id) . '"><i class="mdi mdi-lead-pencil"></i></a></button>  
            </td> </tr>';
        }
        echo $output;
    }

    public function un_active_product_type(Request $request){
        $product_type_id = $request->product_type_id;
        $status = $request->status;

        $product_type = ProductType::where('product_type_id', $product_type_id)->first();

        $product_type->product_type_status = $status;
        $product_type->save();
    }








    /* Xóa mềm */

    public function trash_product_type(){
        return view('admin.Product_Type.list_delete_soft_product_type');
    }


    public function delete_soft_product_type(Request $request){
        $product_type_id = $request->product_type_id;

        $product_type_delete = ProductType::where('product_type_id', $product_type_id)->first();
        $product_type_delete->delete();
    }

    public function load_delete_soft_product_type(){
        $all_product_types_delete = ProductType::onlyTrashed()->get();
        $product_type_delete = ProductType::onlyTrashed()->first();
        $output = '';
        if($product_type_delete){
            // dd($all_product_type_delete_soft);
            foreach ($all_product_types_delete as $key => $product_type) {
                $output .= '<tr>
                <td>' . $product_type->product_type_id . '</label>
                </td>
                <td>' . $product_type->product_type_name . '</td>
            
               
                <td>' . $product_type->product_type_price . '</td>
                <td>';
                
                $output .= ' '.$product_type->deleted_at.' </td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $product_type->product_type_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $product_type->product_type_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>';
            }
        }else{
            // dd('hii');
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/product/product-type').'">Quay lại danh sách product_type</a></th>
            </tr>';
        }
        echo $output;
    }

    public function delete_restore_product_type(Request $request){
        $product_type_id = $request->product_type_id;
        $type = $request->type;

        if($type == -1){
            $product_type = ProductType::withTrashed()->where('product_type_id', $product_type_id)->first();
            $product_type->restore();
        }else{
            $product_type = ProductType::withTrashed()->where('product_type_id', $product_type_id)->first();
            $product_type->forceDelete();
        }
    }

    public function count_delete(){
        $product_types_trash = ProductType::onlyTrashed()->get();
        $countDelete = $product_types_trash->count();
        $output = '';
        if($countDelete > 0){
            $output .= '('.$countDelete.')';
        }
        echo $output;
    }

}
