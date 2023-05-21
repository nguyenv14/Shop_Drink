<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\ManipulationActivity;
use App\Models\ConfigWeb;

session_start();

class ConfigWebController extends Controller
{
    public function show_config(){
        $image_logo = ConfigWeb::where('config_id', 1)->first();
        return view('admin.ConfigWeb.configweb')->with('image_logo', $image_logo);
    }




    public function load_logo(){
        $config_web = ConfigWeb::where('config_type', 0)->get();
    }



    public function loading_config_slogan()
    {

        $config_webs = ConfigWeb::where('config_type', 2)->whereNotIn('config_id', [1])->get();
        $output = '';
        $i = 0;

        foreach ($config_webs as $config_web) {
            $output .= '
            <tr>
                <td>  ' . ++$i . ' </td>
                <td>
                <form>
                ' . csrf_field() . '
                <input hidden id="up_load_file' . $config_web->config_id . '" class="up_load_file"  type="file" name="file_image" accept="image/*" data-config_id = "' . $config_web->config_id . '">
                <label class="up_load_file" for="up_load_file' . $config_web->config_id . '" > <img style="object-fit: cover" width="40px" height="20px"
                src="' . URL('public/fontend/assets/img/config/' . $config_web->config_image) . '" alt=""></label>
                </form>
               </td>
                <td contentEditable class="edit_config_title"  data-config_id = "' . $config_web->config_id . '"> <div style="width: 100px;overflow: hidden;">  '. $config_web->config_title.' </div>  </td>
                <td  contentEditable  class="edit_config_content"  data-config_id = "' . $config_web->config_id . '"><div style="width: 200px;overflow: hidden">  '. $config_web->config_content .' </div>  </td>
                <td>
                <button  style="border: none" class="delete_config_image" data-config_id = "' . $config_web->config_id . '"><i style="font-size: 22px" class="mdi mdi-delete-sweep text-danger "></i></button>
                </td>
            </tr>
            ';
        }
        echo $output;
    }

    public function load_logo_config(){
        $config_logo = ConfigWeb::where('config_type', 1)->orderby('config_id', "DESC")->first();
        $output = '<form>
            '.csrf_field().'
        <input hidden id="up_load_file1" class="up_load_file"  type="file" name="file_image" accept="image/*" data-config_id = "1">
        <label class="up_load_file" for="up_load_file1" > <img style="border-radius: 50%;object-fit: cover;width: 100px;height:auto;" 
        src="'. URL('public/fontend/assets/img/config/'. $config_logo->config_image) . '" alt=""></label>
    </form>';
        echo $output;
    }

    public function load_config_brand(){
        $config_brands = ConfigWeb::where('config_type', 3)->get();

        $output = '';
        $i = 0;
        foreach($config_brands as $config_brand){
            $output .= '
            <tr>
                <td>  ' . ++$i . ' </td>
                <td>
                <form>
                ' . csrf_field() . '
                <input hidden id="up_load_file' . $config_brand->config_id . '" class="up_load_file"  type="file" name="file_image" accept="image/*" data-config_id = "' . $config_brand->config_id . '">
                <label class="up_load_file" for="up_load_file' . $config_brand->config_id . '" > <img style="object-fit: cover" width="40px" height="20px"
                src="' . URL('public/fontend/assets/img/config/' . $config_brand->config_image) . '" alt=""></label>
                </form>
               </td>
                <td contentEditable class="edit_config_title"  data-config_id = "' . $config_brand->config_id . '"> <div style="width: 100px;overflow: hidden;">  '. $config_brand->config_title.' </div>  </td>
                <td contentEditable class="edit_config_content" data-config_id = "' . $config_brand->config_id . '"> <div style="width: 250px;overflow: hidden;">  '. $config_brand->config_content.' </div> </td>
                <td>
                <button  style="border: none" class="delete_config_image" data-config_id = "' . $config_brand->config_id . '"><i style="font-size: 22px" class="mdi mdi-delete-sweep text-danger "></i></button>
                </td>
            </tr>
            ';
        }
        echo $output;
    }

    public function insert_config_image(Request $request)
    {
        $config_type = $request->config_type;
        /* Bên kia input name="file[]" nên gửi qua là 1 mảng chứa toàn bộ ảnh , sử dụng dd() để rõ hơn*/
        // $product_id = $request->product_id;
        $get_images = $request->file('file');
        
        if ($get_images) {
            foreach ($get_images as $get_image) {
                $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $get_image->move('public\fontend\assets\img\config', $new_image);

                $config_web = new ConfigWeb();

                $config_web['config_title'] = "Ảnh này chưa có tiêu đề";
                $config_web['config_image'] = $new_image;
                $config_web['config_content'] = "Ảnh này chưa có nội dung !";
                $config_web['config_type'] = $config_type;
                $config_web->save();
            }
        }
        // ManipulationActivity::noteManipulationAdmin( "Thêm Vào ".count($get_images)." Hình Ảnh Vào Cấu hình website");
        $this->message("success","Thêm Vào ".count($get_images)." Hình Ảnh Vào Thư Viện Thành Công !");
        return redirect()->back();
    }

    public function edit_config_title(Request $request){
        $config_id = $request->config_id;
        $title = $request->config_title;

        $config_old = ConfigWeb::where('config_id', $config_id)->first();
        $config_old['config_title'] = $title;
        // ManipulationActivity::noteManipulationAdmin( "Cập Nhật Tiêu Đề Ảnh Cấu Hình( ID Ảnh : ".$request->$config_id.")");
        $config_old->save();
    }

    public function edit_config_content(Request $request)
    {
        $config_id = $request->config_id;
        $config_content = $request->config_content;
        $config_update = ConfigWeb::where('config_id', $config_id)->first();
        $config_update['config_content'] = $config_content;
        // ManipulationActivity::noteManipulationAdmin( "Cập Nhật Tên Ảnh ( ID Ảnh : ".$request->config_id.")");
        $config_update->save();
    }

    public function delete_config_slogan(Request $request){
        $config_id = $request->config_id;
        $config_web = ConfigWeb::where('config_id', $config_id)->first();
        $config_web->delete();
    }

    public function update_image_config(Request $request)
    {
        $config_id = $request->config_id;
        $get_image = $request->file('file');
        // dd($get_image);
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/fontend/assets/img/config', $new_image);
            $config = ConfigWeb::where('config_id', $config_id)->first();
            // echo $config->config_content;
            //unlink('public/fontend/assets/img/product/', $gallery->gallery_product_image); /* Xóa ảnh ở trong thư mục */
            $config['config_image'] = $new_image;
            $config->save();
        }
        // ManipulationActivity::noteManipulationAdmin( "Cập Nhật Ảnh ( ID Ảnh : ".$request->config_id.")");
    }




    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}

