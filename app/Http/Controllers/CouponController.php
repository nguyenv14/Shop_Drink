<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\SoftDeletes;   
use Illuminate\Pagination\Paginator;

// use App\Repositories\CategoryRepository\CategoryRepositoryInterface;

// use Session;

session_start();
class CouponController extends Controller
{

    public function all_coupon(){
        $all_coupon = Coupon::paginate(5);
        // dd($all_coupon);
        return view('admin.Coupon.all_coupon')->with('all_coupon', $all_coupon);
    }

    public function add_coupon(){
        return view('admin.Coupon.add_coupon'); 
    }

    public function save_coupon(Request $request){
        $data = $request->all();
        $coupon = new coupon();
        $coupon['coupon_name'] = $data['coupon_name'];
        $coupon['coupon_name_code'] = $data['coupon_name_code'];
        $coupon['coupon_qty_code'] = $data['coupon_qty_code'];
        $coupon['coupon_condition'] = $data['coupon_condition'];
        $coupon['coupon_price_sale'] = $data['coupon_price_sale'];
        $coupon['coupon_desc'] = $data['coupon_desc'];
        $coupon['coupon_date_start'] = $data['coupon_date_start'];
        $coupon['coupon_date_end'] = $data['coupon_date_end'];

        $coupon->save();
        return Redirect('admin/coupon/all-coupon');
    }

    public function edit_coupon(Request $request){
        $coupon_id = $request->coupon_id;
        $coupon_old = coupon::where('coupon_id', $coupon_id)->first();
        return view('admin.coupon.edit_coupon')->with('coupon_old', $coupon_old);
    }

    public function update_coupon(Request $request){
        $data = $request->all();
        $coupon = coupon::where('coupon_id', $data['coupon_id'])->first();
        $coupon['coupon_name'] = $data['coupon_name'];
        $coupon['coupon_name_code'] = $data['coupon_name_code'];
        $coupon['coupon_qty_code'] = $data['coupon_qty_code'];
        $coupon['coupon_condition'] = $data['coupon_condition'];
        $coupon['coupon_price_sale'] = $data['coupon_price_sale'];
        $coupon['coupon_desc'] = $data['coupon_desc'];
        $coupon['coupon_date_start'] = $data['coupon_date_start'];
        $coupon['coupon_date_end'] = $data['coupon_date_end'];
       
        $coupon->save();
        return Redirect('admin/coupon/all-coupon');
    }

    public function load_coupon(){
        $all_coupon = Coupon::paginate(5);
        $output = '';
        foreach($all_coupon as $key => $coupon){
            $output .= '<tr>
                <td>'. $coupon->coupon_name_code .'</td>
                
                <td>';
                if ($coupon->coupon_condition == 1){       
                     $output .='Giảm Giá Theo %';
                }else{
                      $output .='Giảm Giá Theo Tiền';
                }
                   $output .=' </td>
                <td>';
                
                if($coupon->coupon_condition == 1){
                    $output .= ''.number_format($coupon->coupon_price_sale, 0, ',','.').'%';
                }else{
                    $output .= ''.number_format($coupon->coupon_price_sale, 0, ',','.').'đ';
                }
                
                $output .='</td>
                <td>
                    '.$coupon->coupon_qty_code.'
                </td>
                <td>'. $coupon->coupon_date_start .'</td>
                <td>'. $coupon->coupon_date_end .'</td>
                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-coupon" data-delete_id="' . $coupon->coupon_id . '"><i class="mdi mdi-delete" ></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon"><a href="'.url('admin/coupon/edit-coupon?coupon_id=' . $coupon->coupon_id) . '"><i class="mdi mdi-lead-pencil"></i></a></button>  
            </td> </tr>';
        }
        echo $output;
    }

    








    /* Xóa mềm */

    public function trash_coupon(){
        return view('admin.Coupon.list_delete_soft_coupon');
    }


    public function delete_soft_coupon(Request $request){
        $coupon_id = $request->coupon_id;

        $coupon_delete = coupon::where('coupon_id', $coupon_id)->first();
        $coupon_delete->delete();
    }

    public function load_delete_soft_coupon(){
        $all_coupons_delete = coupon::onlyTrashed()->get();
        $coupon_delete = coupon::onlyTrashed()->first();
        $output = '';
        if($coupon_delete){
            // dd($all_coupon_delete_soft);
            foreach ($all_coupons_delete as $key => $coupon) {
                $output .= '<tr>
                <td>' . $coupon->coupon_name . '</label>
                </td>
                
                <td>' . $coupon->coupon_desc . '</td>

                
                <td>' . $coupon->coupon_name_code . '</td>';
            
               
                
                $output .= '<td> '.$coupon->deleted_at.' </td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $coupon->coupon_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $coupon->coupon_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>';
            }
        }else{
            // dd('hii');
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/coupon').'">Quay lại danh sách coupon</a></th>
            </tr>';
        }
        echo $output;
    }

    public function delete_restore_coupon(Request $request){
        $coupon_id = $request->coupon_id;
        $type = $request->type;

        if($type == -1){
            $coupon = coupon::withTrashed()->where('coupon_id', $coupon_id)->first();
            $coupon->restore();
        }else{
            $coupon = coupon::withTrashed()->where('coupon_id', $coupon_id)->first();
            $coupon->forceDelete();
        }
    }

    public function count_delete(){
        $coupons_trash = coupon::onlyTrashed()->get();
        $countDelete = $coupons_trash->count();
        // dd($countDelete);
        $output = '';
        if($countDelete > 0){
            $output .= '('.$countDelete.')';
        }
        echo $output;
    }

    public function message($type , $content){
        $data = array(
            'type' => $type,
            'content' => $content
        );
        session()->put('message', $data);
    }
}
