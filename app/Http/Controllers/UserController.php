<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\ManipulationActivity;
use App\Models\ConfigWeb;
use App\Models\CompanyConfig;
use App\Models\Customers;
use App\Models\Order;

session_start();

class UserController extends Controller
{
    public function all_user(){
        $customers = Customers::paginate(3);
        // foreach($custom)
        return view('admin.User.all_user')->with(compact('customers'));
    }

    public function loading_user(){
        $customers = Customers::paginate(3);
        $output = $this->print_user($customers);
        return $output;
    }

    public function print_user($customers){
       
        $output = '';

        foreach($customers as $customer){
            $orders = Order::where('customer_id', $customer->customer_id)->get();
            $orders_boom = Order::where('customer_id', $customer->customer_id)->where('order_status', 0)->get();
            $order_count = count($orders);
            $order_count_boom = count($orders_boom);
            
            $output .= '
            <tr>
                <td>'.$customer->customer_name.'</td>
            
                <td>'.$customer->customer_phone.'</td>
            
                <td>'.$customer->customer_email.'</td>
                <td style="color:green; font-weight:900;">'.$order_count.'</td>
                <td style="color:red;font-weight:900;">'.$order_count_boom.'</td>
                <td>';
                if($customer->customer_status == 1){
                    $output .= '
                        <button style="width:140px;" class="btn btn-inverse-danger btn_report" data-toggle="modal" data-target="#unactive" data-customer_id="'.$customer->customer_id.'" data-status="0">Vô hiệu</button>
                    ';
                }else{
                    $output .= '
                    <button style="width:140px;" class="btn btn-inverse-success btn_report" data-toggle="modal" data-target="#active" data-customer_id="'.$customer->customer_id.'" data-status="1">Kích Hoạt</button>';
                }
                $output .= '</td>
                </tr>
            ';
        }
        return $output;
    }

    public function search_user(Request $request){
        $text ='%' . $request->text . '%';

        $result = Customers::where('customer_name', 'like', $text)->orwhere('customer_phone', 'like', $text)->orwhere('customer_email','like',$text)->get();
        $output = $this->print_user($result);
        return $output;
    }
    

    public function active_unactive_user(Request $request){
        $customer_id = $request->customer_id;
        $status = $request->status;

        $customer = Customers::where('customer_id', $customer_id)->first();
        $customer['customer_status'] = $status;
        $customer->save();
    }
    

    public function message($type,$content){
        $message = array(
            "type" => "$type",
            "content" => "$content",
        ); 
        session()->put('message', $message);
    }
}

