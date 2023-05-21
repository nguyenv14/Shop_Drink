<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use App\Rules\Captcha;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register_auth(){
        return view('admin.AuthLogin.register_auth');
    }

    public function register(Request $request){
        $rules = [
            'admin_name' => 'required|string|min:3|max:256|',
            'admin_phone' => 'required|min:3|max:256|',
            'admin_email' => 'required|email|min:3|max:256|',
            'admin_password' => 'required|string|min:3|max:256|',
            'admin_password_retype' => 'required|string|min:3|max:256|',
            'g-recaptcha-response' => new Captcha(), //dòng kiểm tra Captcha
        ];
        $customMessages = [
            'required' => 'Trường :attribute Này Không Được Trống!.'
        ];
        $this->validate($request, $rules, $customMessages);
        if($request->admin_password !=  $request->admin_password_retype){
            $this->message('warning','Vui lòng nhập mật khẩu trùng nhau!');
            return redirect()->back();
        }
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name =  $data['admin_name'];
        $admin->admin_phone =  $data['admin_phone'];
        $admin->admin_email =  $data['admin_email'];
        $admin->admin_password =  md5($data['admin_password']);
        $admin->save();

        $this->message('success','Đăng Ký Thành Công!');
        return redirect('/admin/auth/login-auth');
    }

    public function login_auth(){
        if(isset($_COOKIE['Admin_Email']) && isset($_COOKIE['Admin_Password'])){
            if(Auth::attempt(['admin_email' =>$_COOKIE['Admin_Email'], 'admin_password' => $_COOKIE['Admin_Password']])){
                $this->message('success','Đăng Nhập Tự Động Bằng Cookie Thành Công!');
                return redirect('/admin/dashboard');
            }
            
            else{
                return view('admin.AuthLogin.auth_login');
            }
        }
        else{
            return view('admin.AuthLogin.auth_login');
        }
    }

    

    public function login(Request $request){
        $rules = [
            'admin_email' => 'required|email|min:3|max:256|',
            'admin_password' => 'required|string|min:3|max:256|',
            'g-recaptcha-response' => new Captcha(), //dòng kiểm tra Captcha
        ];
        $customMessages = [
            'required' => 'Trường :attribute Này Không Được Trống!.'
        ];
        $this->validate($request, $rules, $customMessages);
        $data = $request->all();

        if(Auth::attempt(['admin_email' => $request->admin_email, 'admin_password' => $request->admin_password])){
            // echo Auth::attempt(['admin_email' => $request->admin_email, 'admin_password' => $request->admin_password]);
            if($request->SaveLoginCooke == "ON"){
                setcookie("Admin_Email", $request->admin_email, time() + 999999);
                setcookie("Admin_Password", $request->admin_password, time() + 999999);
            }
            // dd(Auth::user());
            // $Authinfo = array(
            //     'admin_id' => Auth::user()->admin_id,
            //     'admin_name' => Auth::user()->admin_name,
            // );
            // session()->put('Auth_info', $Authinfo);
            $this->message('success','Đăng Nhập Bằng Authen Thành Công!');
            // return redirect('/admin/dashboard');
            return redirect("/admin/dashboard");
        }else{
            $this->message('error', 'Đăng nhập vào Admin thất bại');
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        setcookie("Admin_Email", "", -1);
        setcookie("Admin_Password", "", -1);
        session()->forget('Auth_info');
        // session()->flush();
        $this->message('success','Đăng Xuất Thành Công!');
        return redirect('admin/auth/login-auth');
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
}
