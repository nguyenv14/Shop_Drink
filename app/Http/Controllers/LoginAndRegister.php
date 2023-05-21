<?php
namespace App\Http\Controllers;

use App\Rules\Captcha;
use Validator;
// use Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Models\Customers;

session_start();

class LoginAndRegister extends Controller
{
    /* Đăng Nhập */
    public function login_customer(Request $request)
    {
        // dd('sss');

        $data = $request->validate([
            'customer_name' => 'required', /* Nghiên cứu thêm validate của lava có thể truyền vào |string|min5|max15 để very */
            'customer_password' => 'required',
            'g-recaptcha-response' => new Captcha(), //dòng kiểm tra Captcha
        ]);
        $EmailorName = $data['customer_name'];
        $Password = md5($data['customer_password']);
        $result = Customers::where('customer_email', $EmailorName)->where('customer_password', $Password)->first();
        // dd($result);
        // dd($result);
        if ($result) {
            if($result->customer_status == 1){
                $this->message('success', 'Chào Mừng '.$result->customer_name.' đã quay trở lại!!!');
                session()->put('customer_id', $result->customer_id);
                session()->put('customer_name', $result->customer_name);
                session()->save();
                if (isset($request->checkbox) && $request->checkbox == 'On') {
                    setcookie("customer_name", $result->customer_name, time() + (86400 * 30));
                    setcookie("customer_password", $result->customer_password, time() + (86400 * 30));
                }
                return redirect('/');
            }else{
                $this->message('error','Tài khoản của bạn đã bị vô hiệu hóa');
                return redirect('/');
            }
            // dd($result);
            // $output .= 'success';
        } else {
            // dd($result);
            $this->message('error', 'Tài khoản hoặc mật khẩu bị sai!');
            return redirect()->back();
            // $output .= 'error';
        }
        // echo $output;
    }

    // public function load_login_customer(){
    //     $output = '';
    //     if(session()->get('customer_name')){
    //         $output .= '
    //         <label class="navbar-item">
    //                             <label class="navbar-item-link">
    //                                 <i class="fa-solid fa-user"></i>
    //                             </label>
    //                             <label class="navbar-item-link">
    //                                 '. session()->get('customer_name') .'
    //                             </label>
    //                         </label>
    //                         <a href="'. url('user/logout') .'">
    //                         <label class="navbar-item">
    //                             <label class="navbar-item-link">
    //                                 <i class="fa-solid fa-right-from-bracket"></i>
    //                             </label>
    //                             <label class="navbar-item-link">
    //                                 Đăng Xuất
    //                             </label>
    //                         </label>
    //                     </a>
    //         ';
    //     }else{
    //         $output .= '
    //         <label for="nav-login-logout" class="navbar-item">
    //         <label for="nav-login-logout" class="navbar-item-link">
    //             <i class="fa-solid fa-user"></i>
    //         </label>
    //         <label for="nav-login-logout" class="navbar-item-link">
    //             <i class="fa-solid fa-caret-down"></i>
    //         </label>
    //         </label>
    //         ';
    //     }
    //     echo $output;
    // }

    /* Đăng Ký */
    public function create_customer(Request $request)
    {

        $this->validate( $request,[
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'customer_password' => 'required',
            'g-recaptcha-response' => new Captcha(), // kiểm tra Captcha
        ]);
        $data = array(
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_password' => md5($request->customer_password),
            'customer_status' => 1,
        ); 

        $customer_check = Customers::where('customer_name', $data['customer_name'])->orwhere('customer_email', $data['customer_email'])->first();

        if($customer_check){
            echo "trung";
        }else{
            session()->put('rg_customer_name', $data['customer_name']);
            session()->put('rg_customer_email', $data['customer_email']);
            session()->put('customer_register', $data);

            if(session()->get('register_code')){
                session()->forget('register_code');
            }
            $this->RandomCode();
            return Redirect('/user/MailToCustomer');
        }

        
    }

    public function verification_code_rg(Request $request)

    {
        $register = session()->get('rg_customer_email');
        if(isset($register)){
            $register_code = session()->get('register_code');
        }

        if(isset($request->verycoderg) && $request->verycoderg == $register_code){
            echo "success_very_code";
            return Redirect('/user/successful-create-account');
        }else{
            echo "error_very_code";
        }
  
    }

    public function successful_create_account()
    {
        $data = session()->get('customer_register');
        // $data = session()->get('customer_register');
        DB::table('tbl_customers')->insert($data);
        session()->flush(); // Hủy toàn bộ session
    }

    /* Khôi Phục Mật Khẩu */
    public function find_account_recovery_pw(Request $request)
    {
        $result = Customers::where('customer_name', $request->customer_name_mail)->orWhere('customer_email', $request->customer_name_mail)->first();
        if ($result) {
            session()->put('rc_customer_id', $result->customer_id);
            session()->put('rc_customer_name', $result->customer_name);
            session()->put('rc_customer_email', $result->customer_email);
            $this->RandomCode();
            return redirect('user/MailToCustomer');
        } else {
            echo "account_not_found";
        }

    }

    /* Kiểm tra code đúng hay không */
    public function verification_code_rc(Request $request)
    {
        $rc = session()->get('rc_customer_email');
        if (isset($rc)) {
            $recovery_code = session()->get('recovery_code');
        }
        if (isset($request->verycoderc) && $request->verycoderc == $recovery_code) {
            echo "success_very_code";
        } else {
            echo "error_very_code";
        }
    }


    public function confirm_password(Request $request)
    {
        $rc_customer_id = session()->get('rc_customer_id');
        if (isset($request->password1) && isset($request->password2)) {
            if ($request->password1 == $request->password2) {
                $data = array();
                $data['customer_password'] = md5($request->password1);
                $result = DB::table('tbl_customers')->where('customer_id', $rc_customer_id)->update($data);
                Session()->flush(); // Hủy toàn bộ session
                echo 'success';
                return;
            } else {
                echo 'error';
                return; 
            }
        }
        echo 'error1';
        return ;
    }



    /* Đăng Xuất */
    public function logout()
    {
        Session()->flush(); // Hủy toàn bộ session
        // Session::put('customer_id',Null);
        // Session::put('customer_name',Null);
        setcookie("customer_name", null, 0);
        setcookie("customer_password", null, 0);
        return redirect('/');
    }

    public function bug()
    {
        // Session()->flush(); // Hủy toàn bộ session
        $data = Session()->all(); // Hủy toàn bộ session
        dd($data);
    }

    /* Các Hàm Dùng Chung Cho Đăng Ký , Khôi Phục */
    public function RandomCode()
    {
        $randomrg = rand(10000000, 99999999);
        $randomrc = rand(10000000, 99999999);
        $rg = session()->get('rg_customer_name');
        $rc = session()->get('rc_customer_name');

        if (isset($rg)) {
            session()->put('register_code', $randomrg);
        };

        if (isset($rc)) {
            session()->put('recovery_code', $randomrc);
        };
    }

    public function MailToCustomer()
    {
        $rc = session()->get('rc_customer_name');
        if (isset($rc)) {
            $name = session()->get('rc_customer_name');
            $mail_customer = session()->get('rc_customer_email');
            $code = session()->get('recovery_code');
            $type = "Bạn đã yêu cầu khôi phục tài khoản của mình!";
            $to_name = "Vĩnh Nguyên - Mail Laravel";
            $to_email = "$mail_customer";
        };
        $rg = session()->get('rg_customer_name');
        if (isset($rg)) {
            $name = session()->get('rg_customer_name');
            $mail_customer = session()->get('rg_customer_email');
            $code = session()->get('register_code');
            $type = "Bạn đã yêu cầu đăng ký tài khoản!";
            $to_name = "Vĩnh Nguyên - Mail Laravel";
            $to_email = "$mail_customer";
        };
        $data = array(
            "name" => $name,
            "code" => $code,
            "type" => $type,
        ); // send_mail of mail.blade.php

        Mail::send('pages.Login_Register.mailtocustomer', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject("Xin Chào ! Shop BoNoDrink gửi bạn mail."); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });

    }

    public function login_google(){
        
    }
    public function message($type,$content){
        $message = array(
            'type' => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }
}
