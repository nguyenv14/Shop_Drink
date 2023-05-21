@extends('pages.page_layout')
@section('web_content')
    <link rel="stylesheet" href="{{ asset('public/fontend/assets/css/cart.css') }}">
    <div id="content-cart">
      
    <div class="wrap cf">
  
  <div class="heading cf">
    <h1>My Cart</h1>
    <a href="#" class="continue">Continue Shopping</a>
  </div>
    <div class="cart" style="">
        <table class="cart-table">
            <thead>
                <tr>
                    <th colspan="2">Sản phẩm</th>
                    <th>Loại Sản Phẩm</th>
                    <!-- <th>Tên sản phẩm</th> -->
                    <th>Giá Sản Phẩm</th>
                    <th>Số Lượng</th>
                    
                    <th>Tổng Giá Mỗi Loại</th>
                    <th data-toggle="modal" data-target="#DeleteAll" class="delete-all"><i class="fa-solid fa-trash"></i> Delete all</th>
                </tr>
            </thead>
            <tbody class="tbody">
              
                
                
                
            </tbody>
        </table>
        
    </div>      
    <div class="title-hoa-don">

    </div>
    <div class="hoa-don">
        
        <div class="thanh-toan">
            <h2>Thông tin nhận hàng</h2>
            <div class="input-items">

                <input type="email"  name="shipping_email" id="input-item" placeholder="Email" value="<?php 
                if(session()->get('shipping') != null){
                    $shipping = session()->get('shipping'); 
                    echo $shipping['shipping_email'];
                } 
                else if(isset($customer)){
                    echo $customer->customer_email;
                }?>">      
            </div>
            <div class="input-items">
                <input type="text" name="shipping_name" id="input-item" placeholder="Name" value="<?php 
                if(session()->get('shipping') != null){
                    $shipping = session()->get('shipping');
                    echo $shipping['shipping_name'];
                } 
                else if(isset($customer)){
                    echo $customer->customer_name;
                }?>">      
            </div>
            <div class="input-items">
                <input type="text" name="shipping_phone" id="input-item" placeholder="phone" value="<?php 
                if(session()->get('shipping') != null){
                    $shipping = session()->get('shipping');
                    echo $shipping['shipping_phone'];
                }else if(isset($customer)){
                    echo $customer->customer_phone;
                }?>">      
            </div>
            
            <?php
            if (session()->get('fee') != null) {
                $fee = session()->get('fee');
            } else {
                $fee = null;
            }
            ?>
            <div class="input-items">
                {{-- <label for="">Chọn Tỉnh Thành Phố</label> --}}
                <select class="form-control choose  city" name="city" id="city">
                    <?php
                        if($fee != null){
                    ?>
                    <option value="{{ $fee['fee_id_city'] }}">{{ $fee['fee_name_city'] }}</option>
                    <?php
                        }else{
                            ?>
                    <option value="">---Chọn Tỉnh Thành Phố---</option>
                    <?php
                        }
                    ?>

                    @foreach ($cities as $key => $city)
                        <option value="{{ $city->matp }}">{{ $city->name_city }}</option>
                    @endforeach
                </select>

                </select>
            </div>
            <div class="input-items">
                {{-- <label for="">Chọn Quận Huyện</label> --}}
                <select class="form-control choose  province" name="province" id="province">
                    <?php
                        if($fee != null){
                    ?>
                    <option value="{{ $fee['fee_id_province'] }}">{{ $fee['fee_name_province'] }}</option>
                    <?php
                        }else{
                            ?>
                    <option value="">---Chọn Quận Huyện---</option>
                    <?php
                        }
                    ?>

                </select>
            </div>
            <div class="input-items">
                {{-- <label for="">Chọn Xã Phường Thị Trấn</label> --}}
                <select class="form-control wards caculate_fee" name="wards" id="wards">
                    <?php
                    if($fee != null){
                ?>
                    <option value="{{ $fee['fee_id_wards'] }}">{{ $fee['fee_name_wards'] }}</option>
                    <?php
                    }else{
                        ?>
                    <option value="">---Chọn Xã Phường---</option>
                    <?php
                    }
                ?>

                </select>
            </div>
            <div class="input-items">
                <input type="text" name="shipping_home_number" id="input-item" placeholder="Address">      
            </div>
        </div>
        
        <div class="sale-hoadon">
            @if(session()->get('customer_id'))
            <div class="code-sale">
                <h2>Nhập mã giảm giá</h2>
                {{-- <input type="text" class="code-flashsale"> <button class="btn-code">Áp dụng</button>
                <hr width="80%">
                 --}}
                <input type="text" class="code-flashsale" value="<?php if(session()->get('coupon-cart') != null){$coupon_cart = session()->get('coupon-cart');echo $coupon_cart->coupon_name_code;}?>"> 
                <button class="btn-code">Áp dụng</button>
               
                <div class="coupon-box">
                    
                </div>
               
            </div>
            @endif
            <div class="tong-tien">
                <table class="table-price">
                    <tr>
                        <th>Tổng tiền</th>
                        <td>90.000Đ</td>
                    </tr>
                    <tr>
                        <th>Phiếu giảm giá</th>
                        <td>90.000Đ</td>
                    </tr>
                    <tr>
                        <th>Phí vận chuyển</th>
                        <td>90.000Đ</td>
                    </tr>
                    <tr>
                        <th>Tổng cộng</th>
                        <td>90.000đ</td>
                    </tr>
                </table>
            
                <div class="btn-thanh-toan">
                    <button class="btn-deliver" id="btn-payment"><i class="fas fa-shopping-cart"></i>  Đặt hàng</button>
                </div>
            </div>
            
        </div>
        </div>
        </div>
    </div>
@include('pages.Modal.modal');
@include('pages.Modal.modal_detail_product');
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // load_detail_cart();
        load_payment();
        load_coupon();
        // /* Load Bảng Sản Phẩm */
        load_detail_cart();
        function load_detail_cart() {
            $.ajax({
                url: '{{ url('/gio-hang/load-cart') }}',
                method: 'get',
                data: {

                },
                success: function(data) {
                    $('.tbody').html(data);
                    // load_payment();
                },
                error: function() {
                    alert("Load-cart Bug Huhu :<<");
                }
            })
        }
        // /* Load Bảng Mã Giảm Giá */
        function load_coupon() {
            $.ajax({
                url: '{{ url('/gio-hang/load-coupon') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('.coupon-box').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        /* Load Bảng Giá */
        function load_payment() {
            $.ajax({
                url: '{{ url('/gio-hang/load-payment') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('.table-price').html(data);

                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }

        // /*  Áp Dụng Mã Giảm Giá*/
        $('.sale-hoadon .code-sale').on('click', '.btn-code', function() {
            var input = $('.code-flashsale').val();
            // var _token = $('input[name="_token"]').val();
            if(input == ''){
                message_toastr("warning", "Hãy nhập mã giảm giá!!!");
            }else{
                $.ajax({
                    url: '{{ url('/gio-hang/check-coupon') }}',
                    method: 'get',
                    data: {
                        input: input,
                        // _token: _token,
                    },
                    success: function(data) {
                        if(data == 'trùng'){
                            message_toastr('warning', "Mã Giảm Giá Này Bạn Đã Sử Dụng Rồi!!")
                        }
                        else if (data == 'error') {
                            message_toastr("warning", "Mã Giảm Giá Không Tồn Tại !");
                        } else if(data == 'success'){
                            // $('.coupon-box').html(data);
                            load_coupon();
                            load_payment();
                            message_toastr("success", "Đã Áp Dụng Mã Giảm Giá !");
                        }else if(data = 'không'){
                            message_toastr('warning', 'Mã Giảm Giá Đã Hết!');
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })

            }
        });

        // /* Gỡ Mã Giảm Giá */
        $('.coupon-box').on('click', '.fa-circle-xmark', function() {
            // var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/gio-hang/delete-coupon') }}',
                method: 'get',
                data: {
                    // _token: _token,
                },
                success: function(data) {
                    if (data == 'success') {
                        load_coupon();
                        message_toastr("success", "Đã Gỡ Mã Giảm Giá !");
                        load_payment();
                    }
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        })

        /* Xóa 1 Sản Phẩm */
        $('tbody').on('click', '.btn-deleted', function() {
            var rowId = $(this).data("rowid");
            var _token = $('input[name="_token"]').val();
            $('.btn_deleted').click(function() {
                $.ajax({
                    url: '{{ url('/gio-hang/delete-cart') }}',
                    method: 'get',
                    data: {
                        rowId: rowId,
                        _token: _token,
                    },
                    success: function(data) {
                        load_detail_cart();
                        load_quantity_cart();
                        load_payment();
                        message_toastr("success", 'Xóa Sản Phẩm Thành Công!');
                    },
                    // error: function() {
                    //     alert("Bug Huhu :<<");
                    // }
                })

            })
        })

        /* Xóa Toàn Bộ Sản Phẩm */
        $('table').on('click', '.delete-all', function() {
                // alert('hihi');
                var _token = $('input[name="_token"]').val();
                
            $('.btn_deleted_all').click(function() {
              
                $.ajax({
                    url: '{{ url('/gio-hang/delete-all-cart') }}',
                    method: 'POST',
                    data: {
                        _token: _token,
                    },
                    success: function(data) {
                        load_detail_cart();
                        load_quantity_cart();
                        load_payment();
                        message_toastr("success", 'Xóa Tất Cả Sản Phẩm Thành Công!');
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })

            })
            
        })

        /* Cập Nhật Số Lượng */
        $('.tbody').on('change', '.changequantity', function() {
            var cart_id = $(this).data("cart_id");
            var quantity = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ url('/gio-hang/update-all-cart') }}',
                method: 'POST',
                data: {
                    cart_id: cart_id,
                    quantity: quantity,
                    _token: _token,
                },
                success: function(data) {
                    message_toastr("success", "Số Lượng Sản Phẫm Đã Được Cập Nhật !");
                    load_detail_cart();
                    load_quantity_cart();
                    load_payment();
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        })

        // Thay đổi size
        $('.tbody').on('change', '#type-product', function(){
            var row_id = $(this).data('rowid');
            var value = $(this).val();
            var product_id = $(this).data('product_id');
            var quantity = $(this).data('quantity');
            // alert(row_id + " " + value + ' ' + product_id);
            $.ajax({
                url: '{{ url('/gio-hang/update-size-cart') }}',
                method: 'get',
                data: {
                    row_id: row_id,
                    value: value,
                    product_id: product_id,
                    quantity: quantity
                },
                success: function(data) {
                    message_toastr("success", "Sản Phẩm Đã Được Cập Nhật !");
                    load_detail_cart();
                    load_quantity_cart();
                    load_payment();
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        })
    </script>
    {{-- Lấy Quận Huyện - Xã Phường --}}
    <script>
        $('.choose').change(function() {
            var action = $(this).attr('id'); /* Lấy Thuộc Tính Của ID */
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if (action == 'city') {
                result = 'province';
            } else {
                result = 'wards';
            }
            $.ajax({
                url: '{{ url('/admin/delivery/select-delivery') }}',
                method: 'POST',
                data: {
                    action: action,
                    ma_id: ma_id,
                    _token: _token,

                },
                success: function(data) {
                    $('#' + result).html(data);
                },
                error: function() {
                    alert("Nhân Ơi Fix Bug Huhu :<");
                },
            });
        });
        $('.caculate_fee').change(function() {
            var id_city = $("#city").val();
            var id_province = $("#province").val();
            var id_wards = $("#wards").val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('gio-hang/caculate-fee') }}',
                method: 'POST',
                data: {
                    id_city: id_city,
                    id_province: id_province,
                    id_wards: id_wards,
                    _token: _token,

                },
                success: function(data) {
                    message_toastr("success", "Đã Tính Phí Vận Chuyển !");
                    load_payment();
                },
                error: function() {
                    alert("Nguuuu Ơi Fix Bug Huhu :<");
                },
            });
        });
    </script>
<?php 
    // $price_all_type = session()->get('price_all_type');
    // dd($price_all_type);
?>

    <script>
        $('#btn-payment').click(function() {
            var shipping_name = $("input[name='shipping_name']").val();
            var shipping_phone = $("input[name='shipping_phone']").val();
            var shipping_email = $("input[name='shipping_email']").val();
            var  shipping_home_number =  $("input[name='shipping_home_number']").val();
            var id_wards = $("#wards").val();
            
            var price_all_type =  '{{ (int) Cart::total() }}' ;
            
            var _token = $('input[name="_token"]').val();

            var check_error = 0;
            if(shipping_name == ''|| shipping_phone == '' || shipping_email == '' || shipping_home_number == ''){
                message_toastr("warning", "Vui Lòng Nhập Đầy Đủ Thông Tin Vận Chuyển!");
                check_error++;
            }    
            if(price_all_type == '0'){
                message_toastr("warning", "Vui Lòng Thêm Sản Phẩm Vào Giỏ Hàng!");
                check_error++;
            }
            if(id_wards == ''){
                 message_toastr("warning", "Vui Lòng Chọn Nơi Vận Chuyển!");
                 check_error++;
            }
            if(check_error == 0){
                $.ajax({
                url: '{{ url('gio-hang/confirm-cart') }}',
                method: 'post',
                data: {
                    shipping_name: shipping_name,
                    shipping_phone: shipping_phone,
                    shipping_email: shipping_email,
                    shipping_home_number: shipping_home_number,
                    _token: _token,

                },
                success: function(data) {
                    if(data == "true"){
                        window.location="{{ url('/thanh-toan') }}";
                    }     
                },
                error: function() {
                    alert("Nguyên Ơi Fix Bug Huhu :<");
                },
            });
            }
        });
    </script>
@endsection
