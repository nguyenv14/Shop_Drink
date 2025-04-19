<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Rules\Captcha;
use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller
{
    public static function Authlogin(){ 
        if(Auth::check()){
            return redirect('/admin/auth/login-auth'); 
        }
    }
    
    public function index(){
        // Kiểm tra có cookie hay không để tự động login
        if(isset($_COOKIE['admin_email']) && isset($_COOKIE['admin_password'])){
            $admin = Admin::where('admin_email', $_COOKIE['admin_email'])->where('admin_password', $_COOKIE['admin_password'])->first();
            // dd($admin);
            if($admin){
                session()->put('admin_id',$admin->admin_id);
                session()->put('admin_name',$admin->admin_name);
                return Redirect::to('admin/dashboard');
            }else{
                return view('admin.AuthLogin.auth_login');
            }
        }

        return view('admin.AuthLogin.auth_login');
        /* Login Tự Động Bằng Cookie */
    }



    public function show_dashboard(){
        // $this->Authlogin();
        // $this->message('success','Đăng Nhập Tự Động Bằng Cookie Thành Công!');
        return view('admin.dashboard');
    }

    public function all_admin(){
        $admins = Admin::with('roles')->orderBy('admin_id', "DESC")->paginate(2);
        return view('admin.Admin.all_admin')->with(compact('admins'));
    }

    public function add_admin(){
        return view('admin.Admin.add_admin');
    }

    public function save_admin(Request $request){
        $rules = [
            'admin_name' => 'required|string|min:3|max:256|',
            'admin_phone' => 'required|min:3|max:256|',
            'admin_email' => 'required|email|min:3|max:256|',
            'admin_password_1' => 'required|string|min:3|max:256|',
            'admin_password_2' => 'required|string|min:3|max:256|',
        ];
        $customMessages = [
            'required' => 'Trường :attribute Này Không Được Trống!!!.'
        ];
        $this->validate($request, $rules, $customMessages);
        if($request->admin_password_1 !=  $request->admin_password_2){
            $this->message('warning','Vui lòng nhập mật khẩu trùng nhau!');
            return redirect()->back();
        }
        $data = $request->all();
        // dd($data);
        $admin = new Admin();
        $admin->admin_name =  $data['admin_name'];
        $admin->admin_phone =  $data['admin_phone'];
        $admin->admin_email =  $data['admin_email'];
        $admin->admin_password =  md5($data['admin_password_1']);
        $admin->save();

        $admin_new = Admin::orderBy('admin_id', 'DESC')->first();

        $admin_new->roles()->attach(Roles::where('roles_name', $data['roles'])->first());
        $this->message('success', 'Chào Mừng Thành Viên Mới Của BonoDrinks');
        return redirect('admin/auth/');
    }

    public function loading_admin(){
        $admins = Admin::paginate(2);
        $output = '';
        $checkadmin = '';
        foreach ($admins as $key => $admin){
            
                            $output .= '<tr>
                                <td>'. $admin->admin_name .'</td>
                                <td>'. $admin->admin_phone .'</td>
                                <td>'. $admin->admin_email .'</td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">';
                                        if($admin->hasRoles('admin')){
                                            $checkadmin = 'checked';    
                                        }else{
                                            $checkadmin = '';
                                        }
                                        $output .= ' <input style="opacity:1;" type="radio" class="form-check-input"
                                            name="roles'.$admin->admin_id .'"
                                            '.$checkadmin.' value="1"
                                            data-admin_id="'. $admin->admin_id .'">
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">';
                                        if($admin->hasRoles('manager')){
                                            $checkadmin = 'checked';    
                                        }else{
                                            $checkadmin = '';
                                        }
                                            $output .= '<input style="opacity:1;" type="radio" class="form-check-input"
                                                name="roles'. $admin->admin_id .'"
                                                '.$checkadmin.' value="2"
                                                data-admin_id="'. $admin->admin_id .'">
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">';
                                        if($admin->hasRoles('employee')){
                                            $checkadmin = 'checked';    
                                        }else{
                                            $checkadmin = '';
                                        }
                                            $output .= '<input style="opacity:1;" type="radio" class="form-check-input"
                                                name="roles'. $admin->admin_id .'"
                                                '.$checkadmin.' value="3"
                                                data-admin_id="'. $admin->admin_id .'">
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <div style="margin-top: 10px">
                                        <button type="button" class="btn-sm btn-gradient-dark btn-rounded btn-fw btn-delete-admin-roles"  data-toggle="modal" data-target="#deleted" data-admin_id="'. $admin->admin_id .'">Xóa Quản Trị 
                                        </button>
                                    </div>
                                    <div style="margin-top: 10px">
                                        <a href="'. url('admin/auth/impersonate?admin_id=' . $admin->admin_id) .'"><button
                                                type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw">Chuyển
                                                Quyền</button>
                                        </a>
                                    </div>

                                    <div style="margin-top: 10px">
                                        <a href="'. url('admin/auth/edit-admin?admin_id=' . $admin->admin_id) .'"><button
                                                type="button" class="btn-sm btn-gradient-danger btn-dangee btn-fw">Chỉnh sửa</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>';
        }
        return $output;
    }

    public function asssign_roles(Request $request){
        // dd(Auth::id());
        if(Auth::id() == $request->admin_id){
            echo 'error_permit';
        }else{
            $admin = Admin::where('admin_id', $request->admin_id)->first();
            $admin->roles()->detach(); //Hủy các quyền của admin_id

            if($request->index_roles == 1){
                $admin->roles()->attach(Roles::where('roles_name', 'admin')->first());
                echo 'admin';
            }else if($request->index_roles == 2){
                $admin->roles()->attach(Roles::where('roles_name', 'manager')->first());
                echo 'manager';
            }else if($request->index_roles == 3){
                $admin->roles()->attach(Roles::where('roles_name', 'employee')->first());
                echo 'employee';
            }
        }
    }

    public function delete_admin(Request $request){
        $admin_id = $request->admin_id;
        $output = '';
        // dd($admin_id);
        if(Auth::id() == $admin_id){
            echo 'error';
        }else{
            $admin = Admin::where('admin_id', $admin_id)->first();
            // $admin->roles()->detach();
            $admin->delete();
            $output = 'success';
        }
        
        return $output;
    }

    public function count_delete(){
        $admin_delete_soft = Admin::onlyTrashed()->get();

        $count = count($admin_delete_soft);
        $output = '';
        if($count > 0){
            $output .= ' ('.$count.')';
        }

        return $output;
    }

    public function trash_admin(){
        return view('admin.Admin.list_delete_admin');
    }

    public function loading_delete_admin(){
        $admins = Admin::onlyTrashed()->get();
        $output = '';
        $checkadmin = '';
        if(count($admins) > 0){

        
        foreach($admins as $admin){
            $output .= '<tr>
                                <td>'. $admin->admin_name .'</td>
                                <td>'. $admin->admin_phone .'</td>
                                <td>'. $admin->admin_email .'</td>
                                <td>';
                                        if($admin->hasRoles('admin')){
                                            $checkadmin = 'Quản Trị';    
                                        }else if($admin->hasRoles('manager')){
                                            $checkadmin = 'Quản Lý';
                                        }else if($admin->hasRoles('employee')){
                                            $checkadmin = 'Nhân Viên';
                                        }
                                        $output .= ' '.$checkadmin.'
                                </td>
                            
                                <td>
                                    <div style="margin-top: 10px">
                                        <button type="button" class="btn-sm btn-gradient-dark btn-rounded btn-fw btn-admin-roles" data-toggle="modal" data-target="#restore" data-admin_id="'. $admin->admin_id .'" data-status="1">Khôi Phục Quản Trị 
                                        </button>
                                    </div>
                                    <div style="margin-top: 10px">
                                       <button
                                                type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw btn-admin-roles" data-toggle="modal" data-target="#deleted" data-admin_id="'. $admin->admin_id .'" data-status="0">Xóa Quản Trị </button>
                                    </div>
                                </td>
                            </tr>';
            }
        }else{
            $output .= '<tr> 
                <td colspan="5" style="text-align:center;">Không có quản trị nào bị xóa. <a href="'.url('admin/auth').'">Trở lại trang quản trị</a></td>
            </tr>';
        }

        return $output;
    }

    public function restore_delete_admin(Request $request){
        $admin_id = $request->admin_id;
        $status = $request->status;
        $admin = Admin::onlyTrashed()->where('admin_id', $admin_id)->first();

        if($status == 1){
            // $admin->hasRoles()->detach();
            $admin->restore();
        }else{
            $admin->roles()->detach();
            $admin->forceDelete();
        }
    }

    public function impersonate(Request $request){
        $admin_id = $request->admin_id;
        if(Auth::id() == $admin_id){
            $this->message('error', "Bạn Không Thể Chuyển Quyền Của Chính Mình");
            return redirect()->back();
        }else{

            $admin = Admin::where('admin_id', $admin_id)->first();
            if($admin){
                session()->put('impersonate', $admin->admin_id);
            }
            $this->message('success', 'Chuyển Quyền Thành Công!!!');
            return redirect('/admin');
        }
    }

    public function destroy_impersonate(){
        session()->forget('impersonate');
        $this->message('success', 'Đã Quay Trở Lại Quyền Quản Trị Hệ Thống!!!');
        return redirect('/admin');
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
}
