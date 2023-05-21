<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use App\Repositories\SliderRepository\SliderRepositoryInterface;


session_start();

class SliderController extends Controller
{
   
    public function all_slider()
    {
        $sliders = Slider::paginate(3); // lấy slider từ bảng
        
        $sliders_trash = Slider::onlyTrashed()->get();
        $countDelete = $sliders_trash->count();
        return view('admin.Slider.all_slider')->with('sliders', $sliders)->with('countDelete', $countDelete);
    }

    public function edit_slider(Request $request){
        $slider_old = Slider::where('slider_id', $request->slider_id)->first();
        return view('admin.Slider.edit_slider')->with(compact('slider_old'));
    }

    public function add_slider(){
        return view('admin.Slider.add_slider');
    }

    public function save_slider(Request $request){
        $data = $request->all();
        $slider = new Slider();
        $slider['slider_name'] = $data['slider_name'];
        $slider['slider_status'] = $data['slider_status'];
        $slider['slider_desc'] = $data['slider_desc'];
        $get_image = $request->file('slider_image');
        if($get_image){
            $get_image_name = $get_image->getClientOriginalName(); // Lấy tên file
            $image_name = current(explode('.',$get_image_name)); // sẽ lấy ra hai thành phần 1: tên file, 2: đuôi file
            $new_image = $image_name.rand(0,1000).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public\fontend\assets\img\slider', $new_image);
            $data['slider_image'] = $new_image;
            $slider['slider_image'] = $data['slider_image'];
        }

        $slider->save();
        $this->message('success', 'Thêm Slider Thành Công');
        return Redirect('admin/slider/all-slider');
    }

    public function update_slider(Request $request){
       
        $data = $request->all();
        $slider = Slider::where('slider_id', $data['slider_id'])->first();
        $slider['slider_name'] = $data['slider_name'];
        $slider['slider_status'] = $data['slider_status'];
        $slider['slider_desc'] = $data['slider_desc'];
        $get_image = $request->file('slider_image');
        if($get_image){
            $get_image_name = $get_image->getClientOriginalName(); // Lấy tên file
            $image_name = current(explode('.',$get_image_name)); // sẽ lấy ra hai thành phần 1: tên file, 2: đuôi file
            $new_image = $image_name.rand(0,1000).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public\fontend\assets\img\slider', $new_image);
            $data['slider_image'] = $new_image;
            $slider['slider_image'] = $data['slider_image'];
        }

        $slider->save();
       
        return Redirect('admin/slider/all-slider');
    }

    // load ajax trong trang
    public function load_slider()
    {
        $all_slider = Slider::paginate(3);
        $output = '';

        foreach ($all_slider as $key => $slider) {
            $output .= '<tr>
            <td>' . $slider->slider_id . '</label>
            </td>
            <td>' . $slider->slider_name . '</td>
           
            <td><img style="object-fit: cover" width="40px" height="20px"
                    src="' . url('public/fontend/assets/img/slider/' . $slider->slider_image) . '"
                    alt=""></td>
            <td>' . $slider->slider_desc . '</td>
            <td>';
            if ($slider->slider_status == 1) {
                $output .= '<i style="color: rgb(52, 211, 52); font-size: 30px"
                    class="mdi mdi-toggle-switch btn-un-active" data-slider_id="'.$slider->slider_id.'" data-slider_status="0"></i>';
            } else {
                $output .= '<i style="color: rgb(196, 203, 196);font-size: 30px"
                    class="mdi mdi-toggle-switch-off btn-un-active"  data-slider_id="'.$slider->slider_id.'" data-slider_status="1"></i>';
            }
            $output .= '</td>

            <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-slider" data-delete_id="' . $slider->slider_id . '"><i class="mdi mdi-delete" ></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon"><a href="'.url('admin/slider/edit-slider?slider_id=' . $slider->slider_id) . '"><i class="mdi mdi-lead-pencil"></i></a></button>
            </td>
        </tr>';
        }
        echo $output;
    }


    public function un_active_slider(Request $request){
        $slider_id = $request->slider_id;
        $slider_status = $request->status;

        $slider = Slider::where('slider_id', $slider_id)->first();
        $slider->slider_status = $slider_status;
        $slider->save();
    }




    /*       Xóa mềm            */

    public function trash_slider()
    {
        return view('admin.Slider.delete_soft_slider');
    }

    public function load_slider_delete_soft()
    {
        // $all_product = Product::take(7)->onlyTrashed()->orderby('created_at', 'desc')->get();
        // $all_product_details = ProductDetails::get();
        // return view('admin.Product.soft_deleted_product')->with(compact('all_product', 'all_product_details'));
        $all_slider_delete_soft = Slider::onlyTrashed()->get();
        // dd($all_slider_delete_soft);
        $slider_delete_soft = Slider::onlyTrashed()->first();
        $output = '';
        // dd($slider_delete_soft);
        // dd($all_slider_delete_soft);
        if($slider_delete_soft){
            // dd($all_slider_delete_soft);
            foreach ($all_slider_delete_soft as $key => $slider) {
                $output .= '<tr>
                <td>' . $slider->slider_id . '</label>
                </td>
                <td>' . $slider->slider_name . '</td>
            
                <td><img style="object-fit: cover" width="40px" height="20px"
                        src="' . url('public/fontend/assets/img/slider/' . $slider->slider_image) . '"
                        alt=""></td>
                <td>' . $slider->slider_desc . '</td>
                <td>';
                
                $output .= ' '.$slider->deleted_at.' </td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $slider->slider_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $slider->slider_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>';
            }
        }else{
            // dd('hii');
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/slider').'">Quay lại danh sách slider</a></th>
            </tr>';
        }
        echo $output;
    }

    // xóa mềm
    public function delete_soft_slider(Request $request)
    {
        $slider_id = $request->slider_id;
        $slider = new Slider();

        $slider_delete_soft = $slider->find_slider_byId($slider_id);

        $slider_delete_soft->delete();
    }

    public function un_or_force_delete_slider(Request $request)
    {
        $slider_id = $request->slider_id;
        $type = $request->type;
        if ($type == -1) {
            $slider = Slider::withTrashed()->where('slider_id', $slider_id)->first(); // Có thể thay thế bằng find_slider_byId
            $slider->restore();
        } else {
            $slider = Slider::withTrashed()->where('slider_id', $slider_id)->first();
            $slider->forceDelete();
        }
    }

    public function count_delete(){
        $sliders_trash = Slider::onlyTrashed()->get();
        $countDelete = $sliders_trash->count();
        $output = '';
        if($countDelete > 0){
            $output .= '('.$countDelete.')';
        }
        echo $output;
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
    
}
