<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Repositories\SliderRepository\SliderInterfaceRepository;
// use App\Repositories\SliderRepository\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use App\Repositories\SliderRepository\SliderRepositoryInterface;


session_start();

class SliderController extends Controller
{
    /**
     * @var PostRepositoryInterface|\App\Repositories\Repository
     */
    protected $sliderRepository;
    public function __construct(SliderInterfaceRepository $sliderRepositoryInterface)
    {
        $this->sliderRepository = $sliderRepositoryInterface;
    }

    public function all_slider()
    {
        $sliders = $this->sliderRepository->getAllByPaginate(3);

        $sliders_trash = $this->sliderRepository->getListDelete();
        $countDelete = $sliders_trash->count();
        return view('admin.Slider.all_slider')->with('sliders', $sliders)->with('countDelete', $countDelete);
    }

    public function edit_slider(Request $request){
        $slider_old = $this->sliderRepository->find($request->slider_id);
        return view('admin.Slider.edit_slider')->with(compact('slider_old'));
    }

    public function add_slider(){
        return view('admin.Slider.add_slider');
    }

    public function save_slider(Request $request){
        $result = $this->sliderRepository->insert_slider($request->all(), $request->file('slider_image'));
        $this->message('success', 'Thêm Slider Thành Công');
        return Redirect('admin/slider/all-slider');
    }

    public function update_slider(Request $request){
        $this->sliderRepository->update_slider($request->all(), $request->file('slider_image'));
        $this->message('success', 'Cập nhật slider thành công!');
        return Redirect('admin/slider/all-slider');
    }

    // load ajax trong trang
    public function load_slider()
    {
        $all_slider = $this->sliderRepository->getAllByPaginate(3);

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
        $this->sliderRepository->un_active($request->slider_id, $request->status);
    }




    /*       Xóa mềm            */

    public function trash_slider()
    {
        return view('admin.Slider.delete_soft_slider');
    }

    public function load_slider_delete_soft()
    {
        $all_slider_delete_soft = $this->sliderRepository->getListDelete();
        $output = '';
        
        if($all_slider_delete_soft->count() > 0){
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
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/slider').'">Quay lại danh sách slider</a></th>
            </tr>';
        }
        echo $output;
    }

    // xóa mềm
    public function delete_soft_slider(Request $request)
    {
        $this->sliderRepository->delete_slider($request->slider_id);    
    }

    public function un_or_force_delete_slider(Request $request)
    {
        $slider_id = $request->slider_id;
        $type = $request->type;
        $this->sliderRepository->findSliderDelete($slider_id, $type); 
    }

    public function count_delete(){
        $sliders_trash = $this->sliderRepository->getListDelete();
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
