@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-clipboard-outline"></i>
            </span> Quản Lý Đơn Hàng
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="mdi mdi-clipboard-outline"></i>
                    <span><?php
                    $today = date('d/m/Y');
                    echo $today;
                    ?></span>
                </li>
            </ul>
        </nav>
    </div>


    <?php
    $mesage = Session::get('mesage');
    if ($mesage) {
        echo $mesage;
        Session::put('mesage', null);
    }
    ?>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Thông Tin Khách Hàng Đăng Nhập</div>
                    <div class="col-sm-3">
                    </div>
                </div>
                @if($customer != null)
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#ID Khách Hàng</th>
                            <th>Tên Khách Hàng</th>
                            <th>Số Điện Thoại</th>
                            <th>Email Khách Hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>{{ $customer->customer_id }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->customer_phone }}</td>
                        <td>{{ $customer->customer_email }}</td>
                    </tbody>

                </table>
                @else
                <h6>Không Có Thông Tin - Khách Hàng Đặt Hàng Trực Tiếp Trên Hệ Thống Không Thông Qua Đăng Nhập !</h6>
                @endif
               
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Thông Tin Người Đặt Hàng</div>
                    <div class="col-sm-3">
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                   
                        <tr>
                            <th>Tên Người Đặt Hàng</th>
                            <td>{{ $shipping->shipping_name }}</td>
                        </tr>
                        
                        <tr>
                            <th>Số Điện Thoại</th>
                            <td>{{ $shipping->shipping_phone }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $shipping->shipping_email }}</td>
                        </tr>

                        <tr>
                            <th>Địa Chỉ</th>
                            <td>{{ $shipping->shipping_address }}</td>
                        </tr>
                            
                        <tr>
                            <th>Ghi Chú</th>
                            <td>{{ $shipping->shipping_notes }}</td>
                        </tr>
                        
                        <tr>
                            <th>Yêu Cầu Đặc Biệt</th>
                            <td>
                                @if ($shipping->shipping_special_requirements == 0)
                                    {{ 'Không' }}
                                @elseif($shipping->shipping_special_requirements == 1)
                                    {{ 'Bỏ đá riêng' }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Phương thức thanh toán</th>
                            <td>
                                @if($order->payment->payment_method == 4)
                                    Khi nhận hàng
                                @elseif($order->payment->payment_method == 1)
                                   Thanh toán MoMo
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tình trạng</th>
                            <td>
                                @if($order->order_status == 0)
                                  <span class="text-info" ><b>Đang chờ duyệt <i class="mdi mdi-camera-party-mode"></i></b></span>
                                @elseif($order->order_status == -1)
                                  <span class="text-danger" ><b>Đã từ chối đơn hàng <i class="mdi mdi-calendar-remove"></i></b></span>
                                @elseif($order->order_status == 1)
                                  <span class="text-warning" ><b>Đã duyệt, đang vận chuyển <i class="mdi mdi-car"></i></b></span>
                                @elseif($order->order_status == 2)
                                  <span class="text-success" ><b>Hoàn thành <i class="mdi mdi-calendar-check"></i></b></span>
                                @elseif($order->order_status == 3)
                                  <span class="text-danger" ><b>Đơn hàng Từ Chối <i class="mdi mdi-calendar-remove"></i></b></span>
                                @endif
                            </td>
                        </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Chi Tiết Đơn Hàng</div>
                    <div class="col-sm-3">
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            @php
                                $i = 1;
                            @endphp
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Tổng Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalall = 0;
                        @endphp
                        @foreach ($orderdetails as $key => $orderdetails)
                            <tr>

                                <td>{{ $i++ }}</td>
                                <td>{{ $orderdetails->product_name }} </td>
                                <td>{{ $orderdetails->product_sales_quantity }}</td>
                                <td>{{ number_format($orderdetails->product_price, 0, ',', '.') . ' đ' }}</td>
                                <td>{{ number_format($orderdetails->product_sales_quantity * $orderdetails->product_price, 0, ',', '.') . ' đ' }}
                                </td>
                            </tr>

                            @php
                                
                                $totalall = $totalall + $orderdetails->product_sales_quantity * $orderdetails->product_price;
                            @endphp
                        @endforeach

                    </tbody>
                </table>
                <div style="margin-top:40px ">
                    <?php
                            $fee_ship = $order->product_fee;
                            $coupon_sale = 0;
                        ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Phí Ship</th>
                            <td>{{ number_format($fee_ship, 0, ',', '.') . ' đ' }}</td>
                        </tr>
                        <tr>
                            <th>Mã Giảm Giá</th>
                            <td>
                                {{ $order->product_coupon }}
                            </td>
                        </tr>
                        <?php
                            $coupon_sale = 0;
                        ?>
                        @if($coupon != null)
                            <tr>
                                <th>Số Tiền Giảm </th>
                                <td>
                                    @if ($order->coupon_sale <= 100)
                                    <?php
                                    $coupon_sale = ($totalall / 100) * $order->coupon_sale;
                                    ?>
                                    <span>{{ number_format($coupon_sale, 0, ',', '.') . ' đ' }}</span>
                                @endif

                                @if ($order->coupon_sale > 100)
                                    <?php
                                    if($totalall > $order->coupon_sale){
                                        $coupon_sale =  $order->coupon_sale;
                                    }else{
                                        $coupon_sale = $totalall;
                                    }
                                    ?>
                                    <span> {{ number_format($coupon_sale, 0, ',', '.') . ' đ' }}</span>
                                @endif
                                </td>
                            </tr>
                        @endif
                       
                        @if ($coupon != null)
                            <tr>
                                <th>Tổng tiền chưa giảm</th>
                                <td>{{ number_format($totalall + $fee_ship, 0, ',', '.') . ' đ' }}</td>
                            </tr>
                            <tr>
                                <th>Tổng tiền Đã Giảm</th>
                                <td>{{ number_format($totalall - $coupon_sale + $fee_ship, 0, ',', '.') . ' đ' }}</td>
                            </tr>
                        @else
                            <tr>
                                <th>Tổng tiền</th>
                                <td>{{ number_format($totalall - $coupon_sale + $fee_ship, 0, ',', '.') . ' đ' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div>
        <div class="template-demo">
            <a target="_blank" style="text-decoration: none"
                href="{{ url('admin/order-manager/print-order?checkout_code=' . $orderdetails->order_code) }}">
                <button type="button" class="btn-lg btn-gradient-info btn-icon-text"> Xuất Hóa Đơn PDF <i
                        class="mdi mdi-printer btn-icon-append"></i>
                </button>
            </a>
           
            {{-- <a style="text-decoration: none" href="">
                <button type="button" class="btn btn-gradient-danger btn-icon-text">
                    <i class="mdi mdi-upload btn-icon-prepend"></i> Upload </button>
            </a> --}}
            {{-- <a style="text-decoration: none" href="">
                <button type="button" class="btn btn-gradient-warning btn-icon-text">
                    <i class="mdi mdi-reload btn-icon-prepend"></i> Reset </button>
            </a> --}}


        </div>
        {{-- @if($order->order_status == 0)
            <button style="margin-top:10px" class="btn btn-gradient-success btn-fw btn-order-status" data-order_code="'.$order->order_code.'" data-order_status="1">Duyệt Đơn <i class="mdi mdi-calendar-check"></i></button>
            <button style="margin-top:10px" class="btn btn-gradient-danger btn-fw btn-order-status"  data-order_code="'.$order->order_code.'" data-order_status="-1" >Từ Chối <i class="mdi mdi-calendar-remove"></i></button>   
        @elseif($order->order_status == -1 || $order->order_status == 2 || $order->order_status == 3 )
            <button style="margin-top:10px" class="btn-sm btn-gradient-dark btn-rounded btn-fw btn-delete-order" data-toggle="modal" data-target="#order" data-order_id="'.$order->order_id.'">Xóa Đơn <i class="mdi mdi-delete-sweep"></i></button> <br>
        @elseif($order->order_status == 1)
            <button style="margin-top:10px" class="btn-sm btn-gradient-success btn-order-status"  data-order_code="'.$order->order_code.'" data-order_status="2">Hoàn Thành <i class="mdi mdi-calendar-check"></i></button> 
            <button style="margin-top:10px" class="btn-sm btn-gradient-danger btn-fw btn-order-status" data-order_code="'.$order->order_code.'" data-order_status="3">Hoàn Trả <i class="mdi mdi-calendar-remove"></i></button> <br>
        @endif --}}
    </div>
@endsection
