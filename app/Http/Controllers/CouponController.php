<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Repositories\CouponRepository\CouponInterfaceRepository;


session_start();
class CouponController extends Controller
{
    protected $couponRepository;
    public function __construct(CouponInterfaceRepository $couponInterfaceRepository)
    {
        $this->couponRepository = $couponInterfaceRepository;
    }

    public function all_coupon(){
        $all_coupon = $this->couponRepository->getAllByPaginate();
        // dd($all_coupon);
        return view('admin.Coupon.all_coupon')->with('all_coupon', $all_coupon);
    }

    public function add_coupon(){
        return view('admin.Coupon.add_coupon'); 
    }

    public function save_coupon(Request $request){
        $data = $request->all();
        $this->couponRepository->saveCoupon($data);
        // $coupon->save();
        return Redirect('admin/coupon/all-coupon');
    }

    public function edit_coupon(Request $request){
        $coupon_id = $request->coupon_id;
        $coupon_old = $this->couponRepository->getCouponId($coupon_id);
        return view('admin.coupon.edit_coupon')->with('coupon_old', $coupon_old);
    }

    public function update_coupon(Request $request){
        $data = $request->all();
        $coupon_id = $request->coupon_id;
        $this->couponRepository->updateCoupon($coupon_id, $data);
        return Redirect('admin/coupon/all-coupon');
    }

    public function load_coupon(){
        $all_coupon = $this->couponRepository->getAllByPaginate();
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

    






    public function delete_soft_coupon(Request $request){
        $coupon_id = $request->coupon_id;
        $this->couponRepository->deleteSoft($coupon_id);
    }


    /* Xóa mềm */
    public function trash_coupon(){
        return view('admin.Coupon.list_delete_soft_coupon');
    }



    public function load_delete_soft_coupon(){
        $all_coupons_delete = $this->couponRepository->getCouponTrash();
        $output = '';
        if($all_coupons_delete->count() > 0){
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
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/coupon').'">Quay lại danh sách coupon</a></th>
            </tr>';
        }
        echo $output;
    }

    public function delete_restore_coupon(Request $request){
        $coupon_id = $request->coupon_id;
        $type = $request->type;

        $this->couponRepository->deleteOrRestore($coupon_id, $type);
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
