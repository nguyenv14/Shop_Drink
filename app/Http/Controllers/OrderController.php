<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Rules\Captcha;
use App\Http\Requests;
use App\Models\CommentProduct;
use App\Models\Coupon;
use App\Models\Customers;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Statistical;
use App\Repositories\OrderRepository\OrderInterfaceRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use PDF;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class OrderController extends Controller
{   
    protected $orderRepository;
    public function __construct(OrderInterfaceRepository $orderInterfaceRepository) {
        $this->orderRepository = $orderInterfaceRepository;
    }

    public function show_order_manager(){
        return view('admin.Order.order_manager');
    }
    /*
    -1: đơn hàng đã bị từ chối
    0: đơn hàng đang chờ duyệt
    1: đơn hàng đang được cbi, vận chuyển
    2: đơn hàng hoàn thành
    3: đơn hàng hoàn trả
    */

    public function loading_order_manager(){
        $orders = $this->orderRepository->getListOrderDesc();
        // Order::orderBy('order_id', "DESC")->get();
        $output = $this->print_order_manager($orders);
        return $output;
    }

    public function filer_order(Request $request){
        $order_status = $request->value;

        // $orders = null;
        // if($order_status == ''){
        //     $orders = Order::orderBy('order_id', "DESC")->get();
        // }else{
        //     $orders = Order::where('order_status', $order_status)->orderBy('order_id', "DESC")->get();
        // }
        $orders = $this->orderRepository->filterOrder($order_status);
        $output = $this->print_order_manager($orders);
        return $output;
    }

    public function  print_order_manager($orders){
        $output = '';
        if(count($orders) > 0){
        foreach($orders as $order){
            $output .= '
            <tr>
                <td>'.$order->order_code.'</td>
                <td>';
                if($order->order_status == 0){
                    $output .= '<span class="text-info" ><b>Đang chờ duyệt <i class="mdi mdi-camera-party-mode"></i></b></span>';
                }else if($order->order_status == -1){
                    $output .= '<span class="text-danger" ><b>Đã từ chối đơn hàng <i class="mdi mdi-calendar-remove"></i></b></span>';
                }else if($order->order_status == 1){
                    $output .= '<span class="text-warning" ><b>Đang vận chuyển <i class="mdi mdi-car"></i></b></span>';
                }else if($order->order_status == 2){
                    $output .= '<span class="text-success" ><b>Hoàn thành <i class="mdi mdi-calendar-check"></i></b></span>';
                }else if($order->order_status == 3){
                    $output .= '<span class="text-danger" ><b>Đơn hàng Từ Chối <i class="mdi mdi-calendar-remove"></i></b></span>';
                }
            $output .= '</td>
                <td>';
                if($order->payment->payment_method == 4){
                    $output .= 'Khi nhận hàng';
                }else if($order->payment->payment_method == 1){
                    $output .= 'Thanh toán MoMo';
                }
            $output .= '</td>
            <td>';
                if($order->payment->payment_status  == 0){
                    $output .= '<span class="text-danger">Chưa thanh toán</span>';
                }else{
                    $output .=  '<span class="text-success">Đã thanh toán</span>';
                }
            $output .= '</td>
                <td>'.$order->created_at.'</td>
                <td>';
                if($order->order_status == 0){
                    $output .= '
                    <button style="margin-top:10px" class="btn-sm btn-gradient-success btn-rounded btn-fw btn-order-status" data-order_code="'.$order->order_code.'" data-order_status="1">Duyệt Đơn <i class="mdi mdi-calendar-check"></i></button><br>
                    <button style="margin-top:10px" class="btn-sm btn-gradient-danger btn-fw btn-order-status"  data-order_code="'.$order->order_code.'" data-order_status="-1" >Từ Chối <i class="mdi mdi-calendar-remove"></i></button> <br>
                    ';
                }else if($order->order_status == -1 || $order->order_status == 2 || $order->order_status == 3 ){
                    $output .= '<button style="margin-top:10px" class="btn-sm btn-gradient-dark btn-rounded btn-fw btn-delete-order" data-toggle="modal" data-target="#order" data-order_id="'.$order->order_id.'">Xóa Đơn <i class="mdi mdi-delete-sweep"></i></button> <br>';
                }else if($order->order_status == 1){
                    $output .= '<button style="margin-top:10px" class="btn-sm btn-gradient-success btn-order-status"  data-order_code="'.$order->order_code.'" data-order_status="2">Hoàn Thành <i class="mdi mdi-calendar-check"></i></button> <br>
                    <button style="margin-top:10px" class="btn-sm btn-gradient-danger btn-fw btn-order-status" data-order_code="'.$order->order_code.'" data-order_status="3">Hoàn Trả <i class="mdi mdi-calendar-remove"></i></button> <br>';
                }
            $output .= '
            <a href="'.URL('admin/order-manager/view-order?order_code=' . $order->order_code).'"><button style="margin-top:10px" class="btn-sm btn-gradient-info btn-rounded btn-fw">Xem Đơn <i class="mdi mdi-eye"></i></button></a> <br>
            </td>
            </tr>';
            }


        }else{
            $output .= '<tr>
                <th colspan="6">Không có đơn hàng nào T.T</th>
            </tr>';
        }
        echo $output;
    }

    public function view_order(Request $request){
        $order_code = $request->order_code;
        $order = $this->orderRepository->getOrderByCode($order_code);
        // Order::where('order_code', $order_code)->first();
        $customer_id = $order['customer_id'];
        $shipping_id = $order['shipping_id'];
        $coupon_name_code = $order['product_coupon'];
        $shipping = $this->orderRepository->getShippingId($shipping_id);
        $customer = $this->orderRepository->getCustomerId($customer_id);
        $orderdetails = $this->orderRepository->getOrderDetail($order_code);
        $coupon = Coupon::where('coupon_name_code', $coupon_name_code)->first();

        return view('admin.Order.view_order')->with(compact('order'))->with(compact('order', 'orderdetails', 'coupon', 'customer', 'shipping'));
    }

    public function edit_order_status(Request $request){
        $order_code = $request->order_code;
        $order_status = $request->order_status;

        $order_edit = $this->orderRepository->getOrderByCode($order_code);

        $order_edit->order_status = $order_status;
        $order_edit->save();
        $order = $this->orderRepository->getOrderByCode($order_code);
        $customer = $this->orderRepository->getCustomerId($order->shipping->customer_id);
        if($customer){
            $customer->total_order +=1;
            $customer->save();
        }
        if($order_status == 1){
            $this->email_to_order_customer($order_code, $order_status);
            echo 'browser';
        }else if($order_status == -1){
            $this->email_to_order_customer($order_code, $order_status);
            echo 'refuse';
        }else if($order_status == 2){
            $payment = $this->orderRepository->getPaymentId($order->payment_id);
            $payment->payment_status = 1;
            $payment->save();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            // $statical = Statistical::where('order_date', $now)->first();
            // if($statical){
            //     $statical['sales'] = $statical['sales'] + $order->total_price;
            //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
            //     $statical['total_order'] += 1;
    
            //     $statical->save();
            // }else{
            //     $statis = new Statistical();
            //     $statis->order_date = $order->order_date;
            //     $statis->sales = $order->total_price;
            //     $statis->order_boom = 0;
            //     $statis->total_price_boom = 0;    
            //     $statis->quantity = $order->total_quantity;
            //     $statis->total_order = 1;
            //     $statis->save();
            // }
            echo 'finished';
        }else if($order_status == 3){
            $customer_boom = $this->orderRepository->getCustomerId($order->shipping->customer_id);

            if($customer_boom){
                $customer_boom->total_order +=1;
                $customer_boom->save();
            }
            $customer->order_boom +=1;
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                // $statical = Statistical::where('order_date', $now)->first();
                // if($statical){
                //     $statical['total_price_boom'] = $statical['total_price_boom'] + $order->total_price;
                //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
                //     $statical['total_order'] += 1;
                //     $statical['order_boom'] += 1;
                //     $statical->save();
                // }else{
                //     // dd('huhu');
                //     $statis = new Statistical();
                //     $statis->order_date = $order->order_date;
                //     $statis->sales = 0;
                //     $statis->order_boom = 1;
                //     $statis->total_price_boom = $order->total_price;    
                //     $statis->quantity = $order->total_quantity;
                //     $statis->total_order = 1;
                //     $statis->save();
                // }
            echo 'return';
        }
    }


    public function email_to_order_customer($order_code, $order_status){
        $order = $this->orderRepository->getOrderByCode($order_code);
        $order_detail = $this->orderRepository->getOrderDetail($order_code);
        $coupon = Coupon::where('coupon_name_code', $order->product_coupon)->first();
        if($order_status == 1){
            $type = ' Đơn Hàng '.$order->order_code.' Đã Được Duyệt ';
            $subject =  "BonoDrinks - Thông báo về đơn hàng của bạn!";
        }else if($order_status == -1){
            $type = 'Đơn Hàng '.$order->order_code.' Đã Bị Từ Chối Vì Một Số Lý Do, Chúng Tôi Xin Lỗi Về Sự Bất Tiện Này!!';
            $subject =  "BonoDrinks - Thông báo về đơn hàng của bạn!";
        }

        $to_name = "Nguyên Vĩnh - Mail BonoDrinks Shop";
        $to_email = $order->shipping->shipping_email;

        $data = array(
            "type" => $type,
            "order" => $order,
            "coupon" => $coupon,
            "orderdetails" => $order_detail,
        ); 
        Mail::send('admin.Order.email_order_to_customer', $data, function ($message) use ($to_name, $to_email , $subject) {
            $message->to($to_email)->subject($subject); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });
    }

    // public function delete_soft_order(Request $request){
    //     $order_id = $request->order_id;
    //     $order = Order::where('order_id', $order_id)->first();
    //     $shipping = Shipping::where('shipping_id', $order->shipping_id)->first();
    //     $orderDetail = OrderDetails::where('order_code', $order->order_code)->get();
    //     $payment = Payment::where('payment_id', $order->payment_id)->first();
    //     $order->delete();
    //     $shipping->delete();
    //     $payment->delete();
    //     foreach($orderDetail as $key => $value){
    //         $value->delete();
    //     }
    // }

    // public function show_delete_soft_order(){
    //     return view('admin.Order.list_delete_order_manager');
    // }

    // public function loading_delete_order(){
    //     $orders = Order::onlyTrashed()->orderBy('order_id', "DESC")->get();

    //     $output = '';
    //     if(count($orders) > 0){
    //     foreach($orders as $order){
    //         $output .= '
    //         <tr>
    //             <td>'.$order->order_code.'</td>
    //             <td>';
    //             if($order->order_status == 0){
    //                 $output .= '<span class="text-info" ><b>Đang chờ duyệt</b></span>';
    //             }else if($order->order_status == -1){
    //                 $output .= '<span class="text-danger" ><b>Đã từ chối đơn hàng</b></span>';
    //             }else if($order->order_status == 1){
    //                 $output .= '<span class="text-warning" ><b>Đã duyệt, đang vận chuyển</b></span>';
    //             }else if($order->order_status == 2 || $order->order_status == 4){
    //                 $output .= '<span class="text-success"><b>Hoàn thành</b></span>';
    //             }else if($order->order_status == 3){
    //                 $output .= '<span class="text-danger" ><b>Đơn hàng Từ Chối</b></span>';
    //             }
    //         $output .= '</td>';
    //         $output .= '
    //             <td>'.$order->deleted_at.'</td>
    //             <td>';
                
    //                 $output .= '
    //                 <button style="margin-top:10px" class="btn-sm btn-gradient-success btn-rounded btn-fw btn-order-status" data-toggle="modal" data-target="#restone" data-order_id="'.$order->order_id.'" data-order_status="1">Khôi Phục Đơn <i class="mdi mdi-calendar-check"></i></button><br>
    //                 <button style="margin-top:10px" class="btn-sm btn-gradient-danger btn-fw btn-order-status" data-toggle="modal" data-target="#delete"  data-order_id="'.$order->order_id.'" data-order_status="0" >Xóa Vĩnh Viễn <i class="mdi mdi-delete-sweep"></i></button> <br>
    //                 ';
                
    //         $output .= '
    //         </td>
    //         </tr>';
    //         }
    //     }else{
    //         $output .= '<tr>
    //             <th colspan="6">Không có đơn hàng nào bị xóa.</th>
    //         </tr>';
    //     }
    //     return $output;
    // }

    // public function count_delete_soft(){
    //     $order_delete_soft = Order::onlyTrashed()->get();

    //     $count = count($order_delete_soft);
    //     $output = '';
    //     if($count > 0){
    //         $output .= ' ('.$count.')';
    //     }

    //     return $output;
    // }


    // public function restone_or_delete(Request $request){
    //     $order_id = $request->order_id;
    //     $order_status = $request->order_status;
        
    //     $order = Order::withTrashed()->where('order_id', $order_id)->first();
        
    //     $shipping = Shipping::withTrashed()->where('shipping_id', $order->shipping_id)->first();

    //     $orderDetail = OrderDetails::withTrashed()->where('order_code', $order->order_code)->get();
        
    //     $payment = Payment::withTrashed()->where('payment_id', $order->payment_id)->first();

    //     if($order_status == 1){
    //         $shipping->restore();
    //         $payment->restore();
    //         foreach($orderDetail as $value){
    //             $value->restore();
    //         }
    //         $order->restore();
    //     }else{
    //         $order->forceDelete();
    //         $shipping->forceDelete();
    //         $payment->forceDelete();
    //         foreach($orderDetail as $value){
    //             $value->forceDelete();
    //         }
    //         $order->restore();
    //     }
    // }

    public function print_order(Request $request){
        $order_code = $request->checkout_code;
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->pdf_view($order_code));
        return $pdf->stream();
    }

    public function pdf_view($order_code){
        $order = $this->orderRepository->getOrderByCode($order_code);
        $order_details =$this->orderRepository->getOrderDetail($order_code);
        $coupon = Coupon::where('coupon_name_code', $order->product_coupon)->first();
        $shipping = $this->orderRepository->getShippingId($order->shipping_id);
        $total_price = 0;
        $i = 0;
        $output ='
        <style>
            body{
                font-family: DejaVu Sans;
            }
        </style>
        <div class="" style="display: flex; justify-content: center;"> 
        <table style="margin-left: 60px">
            <tr>
                <td>
                    <img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQMCQIK7bhOuwgc8W_e5aXDroD-hvJDumC_9kzWxIXU4LcjRb-D" alt="" width="150px" >

                </td>
                <td></td>
                <td></td>
                <td>
                    <h2>
                        BonoDrinks - Chilling Coffee
                    </h2>
                    <h3>Address: 470 - Tran Dai Nghia - Ngu Hanh Son</h3>
                    <h3>Phone: 0839519415</h3>
                </td>
            </tr>
        </table>
    </div>
    <div style="text-align: center;">
        <h2>Customer Name: '.$shipping->shipping_name.'</h2>
        <h3>Phone: '.$shipping->shipping_phone.'</h3>
    </div>
    <div style="text-align: center;">
        <h3>BILL - '.$order_code.'</h3>
        
        <div style="display: flex; justify-content: center;">
            <table border="0" style="width: 550px; border-collapse: collapse;margin: 20px auto">
                <thead style="height: 60px;">
                    <tr style="border-bottom: 3px solid black;">
                        <th>STT</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($order_details as $order_detail){
                    $i++;
                    $output .= '
                    <tr style="height: 40px;">
                        <th>'.$i.'</th>
                        <th>'.$order_detail->product_name.'</th>
                        <th>'.$order_detail->product_sales_quantity.'</th>
                        <th>'.number_format($order_detail->product_price, 0, ',', '.').' đ</th>
                        <th>'.number_format($order_detail->product_price * $order_detail->product_sales_quantity, 0, ',', '.').' đ</th>
                    </tr>';

                    $total_price = $total_price + $order_detail->product_price * $order_detail->product_sales_quantity;
                }
                $fee_ship = $order->product_fee;
                $coupon_sale = 0;
                if($order->product_coupon != 'Không có'){
                    if($order->coupon_sale <= 100){
                        $coupon_sale = ($total_price / 100) * $order->coupon_sale;
                    }else{
                        if($order->coupon_sale > $total_price){
                            $coupon_sale = $total_price;
                        }else{
                            $coupon_sale = $order->coupon_sale;
                        }
                    }
                }else{
                    $coupon_sale = 0;
                }
                $output .= '   
                </tbody>
                <tfoot>
                    <tr style="border-top:3px solid black; height: 40px;">
                        <th colspan="3">
                            Total Price
                        </th>
                        <th colspan="2">'.number_format($total_price, 0, ',', '.').' đ</th>
                    </tr>
                </tfoot>
            </table>
        
            
        </div>
        <div style="display: flex;justify-content: center;margin: 20px auto">
            <table border="2" style="width: 450px; border-collapse: collapse;margin: 20px auto">
                <tr>
                    <th>Coupon</th>';
                    if($coupon_sale == 0){
                        $output .= '<th>Không Có</th>';
                    }else{
                        $output .= '<th> '.$order->product_coupon.' - '.number_format($coupon_sale, 0, ',', '.').' đ</th>';
                    }
                $output .= '</tr>
                    <tr>
                    <th>Fee Ship</th>
                    <th>'.number_format($fee_ship, 0, ',', '.').'đ</th>
                </tr>
                <tr>
                    <th>Payment</th>
                    <th>'.number_format($total_price + $fee_ship - $coupon_sale, 0, ',', '.').'đ</th>
                </tr>
            </table>
        </div>
        <span style="display: block;margin-top: 20px; font-family: monospace; font-weight: 900;">Wishing '.$shipping->shipping_name.' Happy Customers, See you again!</span>
    </div>';
        return $output; 
    }
    
    public function show_order(Request $request){
        $customer_id = $request->customer_id;
        if($customer_id != -1){
            if(!session()->get('customer_id') || session()->get('customer_id') != $customer_id){
                $this->message('error', 'Bạn không được phép truy cập vào đường link này');
                return redirect()->back();
            }
            $customer = $this->orderRepository->getCustomerId($customer_id);
            $orders = Order::where('customer_id', $customer_id)->orderby('order_id', "DESC")->paginate(5);
            return view('pages.home.my_order')->with( compact('customer', 'orders'));
        }else{
            return view('pages.home.my_order_1');
        }
    }

    public function loading_order(Request $request){
        $customer_id = $request->customer_id;
        $orders = Order::where('customer_id', $customer_id)->orderby('order_id', "DESC")->paginate(5);
        $output = $this->print_my_order($orders);
        return $output;
    }

    public function check_order(Request $request){
        $order_code = $request->order_code;

        $order = Order::where('order_code', $order_code)->get();
        $output = '';
        if(count($order) > 0){
            $output .= $this->print_my_order($order);
        }else{
            $output .= 'fail';
        }
        return $output;
    }

    public function print_my_order($orders){
        $output = '';
        if(count($orders) > 0){
            foreach($orders as $order){
                $coupon = Coupon::where('coupon_name_code', $order->product_coupon)->first();
                $order_details = $this->orderRepository->getOrderDetail($order->order_code);
                $shipping = $this->orderRepository->getShippingId($order->shipping_id);
                $payment = $this->orderRepository->getPaymentId($order->payment_id);
                $total_price = 0;
                $output .= ' <div class="container order_box mt-3">
                <h4>Mã Đơn: '.$order->order_code.' - '.$order->created_at.'</h4>
                <hr width="100%">
                <div class="row mt-2 mb-2">';
                    foreach($order_details as $order_detail){
                        $output .= '
                        <div class="col-md-4 mt-2 product_item">
                            <img width="100px" style="object-fit: cover;border-radius: 10px; margin-right: 20px;" src="'.url('public/fontend/assets/img/product/'.$order_detail->product->product_image.'').'" alt="">
                            <div class="ms-4 mt-2">
                                <span style="font-weight: 500;">'.$order_detail->product_name.'</span> <br>
                                Số lượng: '.$order_detail->product_sales_quantity.' <br>
                                Giá: '.number_format($order_detail->product_price, 0, ',', '.').'đ
                            </div>
                            <input type="text" class="order_code_box" value="'.$order->order_code.'" hidden>
                        </div>';
                        $total_price = $total_price + $order_detail->product_sales_quantity * $order_detail->product_price;
                    }
                    $fee_ship = $order->product_fee;
                    $coupon_sale = 0;
                    if($coupon){
                        if($coupon->coupon_condition == 1){
                            $coupon_sale = ($total_price / 100) * $coupon->coupon_price_sale;
                        }else{
                            if($coupon->coupon_price_sale > $total_price){
                                $coupon_sale = $total_price;
                            }else{
                                $coupon_sale = $coupon->coupon_price_sale;
                            }
                        }
                    }else{
                        $coupon_sale = 0;
                    }
                $output .= '
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-7 shopper_detail mt-4">
                        <h5>Người Đặt: '.$shipping->shipping_name.'</h5>
                        <h5>SĐT: '.$shipping->shipping_phone.'</h5>
                        <h5>Địa Chỉ: '.$shipping->shipping_address.'</h5>
                    </div>
                    <div class="col-md-5">
                        <table class="m-3" style="width: 90%;">
                            <tr style="border-bottom: 1px solid #0c0c0c;">
                                <th>Phí Ship</th>
                                <th style="text-align: right;">'.number_format($fee_ship, 0, ',', '.').'đ</th>
                            </tr>
                            
                            <tr style="border-bottom: 1px solid #0c0c0c;">
                                <th>Mã Giảm Giá</th>';
                                if($coupon){
                                    $output .= '<th style="text-align: right;"> '.$order->product_coupon.' - '.number_format($coupon_sale, 0, ',', '.').'đ</th>';
                                    
                                }else{
                                    $output .= '<th style="text-align: right;">Không có</th>';
                                }
                            $output .= '
                            </tr>
                            <tr style="border-bottom: 1px solid #0c0c0c;">
                                <th>Tổng tiền</th>
                                <th style="color: red;text-align: right;">'.number_format($total_price + $fee_ship - $coupon_sale , 0, ',', '.').'đ</th>
                            </tr>
                            <tr>
                                <th>Tình Trạng</th>';
                                /*
        -1: đơn hàng đã bị từ chối
        0: đơn hàng đang chờ duyệt
        1: đơn hàng đang được cbi, vận chuyển
        2: đơn hàng hoàn thành
        3: đơn hàng hoàn trả
        */
                                if($order->order_status == 0){
                                    $output .= '<th style="text-align: right;color: red;">Đang Duyệt</th>';
                                }else if($order->order_status == -1){
                                    $output .= '<th style="text-align: right;color: red;">Từ Chối Bởi Shop</th>';
                                }else if($order->order_status == 1){
                                    $output .= '<th style="text-align: right;color: red;">Đang Vận Chuyển</th>';
                                }else if($order->order_status == 2 || $order->order_status == 4){
                                    $output .= '<th style="text-align: right;color: green;">Đã Hoàn Thành</th>';
                                }else if($order->order_status == 3){
                                    $output .= '<th style="text-align: right;color: red;">Đã Từ Chối Nhận</th>';
                                }
                            $output .='</tr>
                            </table>
        
                        <div class="row m-3 d-flex justify-content-center">';
                        if($order->order_status == 0){
                            $output .= '<button class="btn-primary btn-danger btn_cancel_order" style="width: 200px" data-toggle="modal" data-target="#deleted" data-order_id="'.$order->order_id.'" data-order_status="hủy">Hủy Đơn Hàng</button>';
                        }else if($order->order_status == -1){
                            $output .= '';
                        }else if($order->order_status == 1){
                            $output .= '
                        <div class="col-md-12">
                            <button class="btn-primary btn-success btn_cancel_order" style="width: 200px" data-toggle="modal" data-target="#submit" style="width:90%;background:orange;" data-order_id="'.$order->order_id.'" data-order_status="nhận">Đã Nhận Được Hàng</button>
                        </div>';
                        }else if($order->order_status == 2 && session()->get('customer_id')){
                            $output .= '
                            <div class="col-md-12 d-flex justify-content-center">
                                <button class="btn-secondary btn-danger btn_cancel_order btn_cm" data-toggle="modal" data-target="#danhgia" style="width:200px;" data-order_code="'.$order->order_code.'">Đánh Giá Sản Phẩm</button> 
                            </div> 
                            ';
                        }else if($order->order_status == 3 || $order->order_status == 4){
                            $output .= '';
                        }    
                        $output .=  '</div>
                    </div>
                </div>
            </div>';
            }
        }else{
            $output .= '<h2 style="text-align:center;">Quý Khách Chưa Đặt Đơn Hàng Nào Cả.</h2>';
        }
        echo $output;
    }

    public function submit_order(Request $request){
        $order_id = $request->order_id;
        $status = $request->order_status;

        $order = $this->orderRepository->getOrderById($order_id);
        $payment = $this->orderRepository->getPaymentId($order->payment_id);

        if($status == 'nhận'){
            $order->order_status = 2;
            $payment->payment_status = 1;

            $order->save();
            $payment->save();

            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            // $statical = Statistical::where('order_date', $now)->first();
            // if($statical){
            //     $statical['sales'] = $statical['sales'] + $order->total_price;
            //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
            //     $statical['total_order'] += 1;

            //     $statical->save();
            // }else{
            //     // dd('huhu');
            //     $statis = new Statistical();
            //     $statis->order_date = $order->order_date;
            //     $statis->sales = $order->total_price;
            //     $statis->order_boom = 0;
            //     $statis->total_price_boom = 0;    
            //     $statis->quantity = $order->total_quantity;
            //     $statis->total_order = 1;
            //     $statis->save();
            // }
        }else{ 
            $order->order_status = 3;
            $order->save();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            // $statical = Statistical::where('order_date', $now)->first();
            // if($statical){
            //     $statical['total_price_boom'] = $statical['total_price_boom'] + $order->total_price;
            //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
            //     $statical['total_order'] += 1;
            //     $statical['order_boom'] += 1;
            //     $statical->save();
            // }else{
            //     // dd('huhu');
            //     $statis = new Statistical();
            //     $statis->order_date = $order->order_date;
            //     $statis->sales = 0;
            //     $statis->order_boom = 1;
            //     $statis->total_price_boom = $order->total_price;    
            //     $statis->quantity = $order->total_quantity;
            //     $statis->total_order = 1;
            //     $statis->save();
            // }
        }
    }

    public function load_count_order(){
        $orders = Order::where('order_status', 0)->get();

        $count_order = count($orders);
        $output = '';
        if($count_order > 0){
            $output .= '
            <a href="'.url('admin/order-manager').'" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                            <img src="'.url('public/fontend/assets/iconlogo/logo1.png').'" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Có <span style="color:red; font-weight:600;">'.$count_order.'</span> đơn hàng đang chờ bạn xét duyệt</h6>
                            </div>
            </a>
            ';
        }else{
            $output = '
                <h5 class="m-2"> Không có tin nhắn nào cả.</h5>
            ';
        }
        echo $output;
    }

    public function search_order(Request $request){
        $order_code = $request->order_code;
        $order_customer = $request->customer_id;
        $order = Order::where('order_code', $order_code)->where('customer_id',$order_customer)->get();
        $output = '';
        if($order){
            $output = $this->print_my_order($order);
        }else{
            $output = 'fail';    
        }
        return $output;
    }

    public function submit_order_check(Request $request){
        $order_id = $request->order_id;
        $status = $request->order_status;

        $order = Order::where("order_id", $order_id)->first();
        $payment = Payment::where('payment_id', $order->payment_id)->first();

        if($status == 'nhận'){
            $customer_boom = Customers::where('customer_id', $order->shipping->customer_id)->first();

            if($customer_boom){
                $customer_boom->total_order +=1;
                $customer_boom->save();
            }
            $order->order_status = 2;
            $payment->payment_status = 1;

            $order->save();
            $payment->save();

            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            // $statical = Statistical::where('order_date', $now)->first();
            // if($statical){
            //     $statical['sales'] = $statical['sales'] + $order->total_price;
            //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
            //     $statical['total_order'] += 1;

            //     $statical->save();
            // }else{
            //     // dd('huhu');
            //     $statis = new Statistical();
            //     $statis->order_date = $order->order_date;
            //     $statis->sales = $order->total_price;
            //     $statis->profit = 0;    
            //     $statis->quantity = $order->total_quantity;
            //     $statis->total_order = 1;
            //     $statis->save();
            // }
        }else{
            $order->order_status = 3;
            $order->save();

            $customer_boom = Customers::where('customer_id', $order->shipping->customer_id)->first();

            if($customer_boom){
                $customer_boom->total_order +=1;
                $customer_boom->order_boom +=1;
                $customer_boom->save();
            }
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            // $statical = Statistical::where('order_date', $now)->first();
            // if($statical){
            //     $statical['total_price_boom'] = $statical['total_price_boom'] + $order->total_price;
            //     $statical['quantity'] = $statical['quantity'] + $order->total_quantity;
            //     $statical['total_order'] += 1;
            //     $statical['order_boom'] += 1;
            //     $statical->save();
            // }else{
            //     // dd('huhu');
            //     $statis = new Statistical();
            //     $statis->order_date = $order->order_date;
            //     $statis->sales = 0;
            //     $statis->order_boom = 1;
            //     $statis->total_price_boom = $order->total_price;    
            //     $statis->quantity = $order->total_quantity;
            //     $statis->total_order = 1;
            //     $statis->save();
            // }
        }
        $order_print = Order::where("order_id", $order_id)->get();
        $output = $this->print_my_order($order_print);

        return $output;
    }

    public function comment_order(Request $request){
        $order_code = $request->order_code;
        $title_cm = $request->title_cm;
        $content_cm = $request->content_cm;

        $order_details = OrderDetails::whereIn('order_code',[$order_code])->get();
        if(session()->get('customer_id')){
            foreach($order_details as $order_detail){
                $comment_product = new CommentProduct();
                $comment_product['product_id'] = $order_detail->product_id;
                $comment_product['customer_id'] = session()->get('customer_id');
                $comment_product['title_comment'] = $title_cm;
                $comment_product['content_comment'] = $content_cm;
                $comment_product->save();
            }
            $order = $this->orderRepository->getOrderByCode($order_code);
            $order['order_status'] = 4;
            $order->save();
        }
        $output = 'success';
        return $output;
    }

    public function message($type, $content){
        $data = array(
            'type' => $type,
            'content' => $content
        );
        session()->put('message', $data);
    }
}
