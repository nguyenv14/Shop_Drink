@extends('pages.page_layout')
@section('web_content')
    <link rel="stylesheet" href="{{ asset('public/fontend/assets/css/thanhtoan.css') }}">

    <div class="content">
        <div class="contentBox">
            <div class="contentBox-Left">
                <div class="contentBox-Left-time">
                    <i class="fa-solid fa-clock"></i>
                    <span style="margin-left: 4px;">Thời gian hoàn tất thủ tục thanh toán 15:00</span>
                </div>
                <div class="contentBox-Left-Bigcontent">
                    <div class="contentBox-Left-Bigcontent-img">
                        <img width="auto" height="112px" style="border-radius: 8px;object-fit: cover;"
                            src="assets/iconlogo/logo.png" alt="">
                    </div>
                    <div class="contentBox-Left-Bigcontent-Text">
                        <div class="contentBox-Left-Bigcontent-Text-Title">
                            <span>The BonoDrinks - Coffee House</span>
                        </div>
                        <div class="contentBox-Left-Bigcontent-Text-Star-Type-Box">
                            <div class="contentBox-Left-Bigcontent-Text-Star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                        <div class="contentBox-Left-Bigcontent-Text-place">
                            <i class="fa-solid fa-location-pin"></i>
                            <span>KTX Phòng 210 Khu 2 Trường Việt Hàn</span>
                        </div>
                        <div class="contentBox-Left-Bigcontent-Text-DateTime">
                            <div class="contentBox-Left-Bigcontent-Text-DateTime-Item">
                                <div class="contentBox-Left-Bigcontent-Text-DateTime-Item-Top">
                                    <span>Chilling Coffee And Tea</span>
                                </div>
                                <div class="contentBox-Left-Bigcontent-Text-DateTime-Item-Bottom">
                                    <span>Uy Tín - An Toàn - Chất Lượng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="request">
                    <?php $shipping = session()->get('shipping') ?>
                    <div class="request-title">
                        <span>Yêu cầu đặc biệt</span>
                    </div>

                    <div class="request-bd">
                        <div class="request-bd-title">
                            Yêu cầu đặc biệt
                        </div>
                        <div class="request-bd-box">
                            {{-- <div class="request-bd-box-item">
                                <div>
                                    <input class="Special-requirements" type="checkbox" name="" id="requirements-one"
                                        data-choose="1">
                                </div>
                                <div>
                                    <label for="requirements-one">Giao nhanh trong 1 giờ</label>
                                </div>
                            </div> --}}
                            <div class="request-bd-box-item">
                                @if($shipping['shipping_special_requirements'] == 1)
                                <div>
                                    <input class="Special-requirements" checked type="checkbox" name="" id="requirements-two"
                                        data-choose="">
                                </div>
                                    @else
                                <div>

                                    <input class="Special-requirements" type="checkbox" name="" id="requirements-two"
                                        data-choose="1">
                                </div>

                                    @endif
                                <div>
                                    <label for="requirements-two">Bỏ đá riêng</label>
                                </div>
                            </div>


                        </div>
                        <div class="request-rieng-box">
                            <div class="request-rieng-title">
                                Yêu cầu riêng của bạn
                            </div>
                            <div class="textareabox">
                                <textarea name="" id="insert-notes" cols="80" rows="5" placeholder="Nhập yêu cầu khác...">{{ $shipping['shipping_notes'] }}</textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="receipt-box">
                        <div class="receipt-title">
                            <span>Người Đặt Hàng</span>
                        </div>
                        <div class="receipt-text">
                            <h5>Tên: <span style="font-weight: 900"> {{ $shipping['shipping_name'] }}</span> </h5>
                        </div>
                        <div class="receipt-text">
                            <h5>Email: <span style="font-weight: 900"> {{ $shipping['shipping_email'] }}</span></h5>
                        </div>
                        <div class="receipt-text">
                            <h5>Điện Thoại: <span style="font-weight: 900"> {{ $shipping['shipping_phone'] }}</span></h5>
                        </div>
                        <div class="receipt-text">
                            <h5>Địa Chỉ: <span style="font-weight: 900"> {{ $shipping['shipping_address'] }}</span></h5>
                        </div>
                        
                        {{-- <div class="receipt-text">
                            <span class="receipt-text">Khi cần xuất hoá đơn GTGT, Quý khách vui lòng gửi yêu cầu đến
                                BonoDrinks kể
                                <div style="margin-left: 10px;">
                                    từ thời điểm nhận mail đến trước 15h00 ngày hôm sau
                                </div>
                            </span>
                        </div> --}}
                        {{-- <div class="receipt-box-btn-text">
                            <div class="receipt-box-btn">
                                <div>
                                    <input type="checkbox" name="" id="checkbox-receipt" data-receipt_choose="1"
                                        checked>
                                </div>
                                <div>
                                    <span>Yêu cầu xuất hóa đơn</span>
                                </div>
                            </div>

                            <div class="receipt-box-text">
                                <span style="color: #5dc7eb;">Điều khoản xuất hóa đơn</span>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="Payment">
                    <div class="Payment-box">
                        <div class="Payment-box-Title">
                            <span>Phương thức thanh toán</span>
                        </div>
                        <div class="Payment-box-Text">
                            <span>Sau khi hoàn tất thanh toán, mã xác nhận phòng sẽ được gửi ngay qua SMS và Email của
                                bạn.</span>
                        </div>

                        <div class="Payment-content-box">
                            <div class="Payment-content-box-left">
                                <div class="Payment-content-box-left-iconimg">
                                    <img width="38px" height="32px" style="object-fit: cover;"
                                        src="{{ asset('public/fontend/assets/img/thanhtoan/icon/icon2.png') }}"
                                        alt="">
                                </div>
                                <div class="Payment-content-box-left-text">
                                    <span>Thanh toán Momo</span>
                                </div>
                            </div>
                            <div class="Payment-content-box-right">
                                <input type="radio" name="type-payment" id="" value="1">
                            </div>
                        </div>

                        <div class="Payment-content-box">
                            <div class="Payment-content-box-left">
                                <div class="Payment-content-box-left-iconimg">
                                    <img width="38px" height="32px" style="object-fit: cover;"
                                        src="{{ asset('public/fontend/assets/img/thanhtoan/icon/icon2.png') }}"
                                        alt="">
                                </div>
                                <div class="Payment-content-box-left-text">
                                    <span>Thanh toán QR-Pay</span>
                                </div>
                            </div>
                            <div class="Payment-content-box-right">
                                <input type="radio" name="type-payment" id="" value="">
                            </div>
                        </div>
                        <input hidden class="TheATM-Bank-CheckBox" type="checkbox" name=""
                            id="Input-TheATM-Bank-CheckBox">
                        <div class="Payment-content-box">
                            <div class="Payment-content-box-left">
                                <div class="Payment-content-box-left-iconimg">
                                    <img width="38px" height="32px" style="object-fit: cover;"
                                        src="{{ asset('public/fontend/assets/img/thanhtoan/icon/icon3.png') }}"
                                        alt="">
                                </div>
                                <div class="Payment-content-box-left-text">
                                    <span>Thẻ ATM / Tài khoản Ngân Hàng</span>
                                </div>
                            </div>
                            <div class="Payment-content-box-right">
                                <label for="Input-TheATM-Bank-CheckBox">
                                    <input type="radio" name="type-payment" id="">
                                </label>
                            </div>
                        </div>

                        <div class="TheATM-Bank">
                            <div class="TheATM-Bank-Box">
                                <div class="TheATM-Bank-Title">
                                    <span>Chọn ngân hàng</span>
                                </div>
                                <div class="TheATM-Bank-Layout">
                                    <div class="TheATM-Bank-Item">
                                        <img width="94px" height="24px" style="object-fit: cover;"
                                            src="assets/img/datphong/bank/vietcombank_logo.png" alt="">
                                    </div>
                                    <div class="TheATM-Bank-Item">
                                        <img width="94px" height="24px" style="object-fit: cover;"
                                            src="assets/img/datphong/bank/namabank_logo.png" alt="">
                                    </div>

                                </div>
                                <div class="TheATM-Bank-Content">
                                    <div style="margin-top: 15px;" class="TheATM-Bank-Content-Box">
                                        <div class="TheATM-Bank-Content-Icon">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="TheATM-Bank-Content-Text">
                                            <span>Tất cả thông tin thanh toán của bạn được bảo mật</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="TheATM-Bank-Content">
                                    <div class="TheATM-Bank-Content-Box">
                                        <div class="TheATM-Bank-Content-Icon">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="TheATM-Bank-Content-Text">
                                            <span>Thanh toán an toàn qua cổng VNPay, miễn phí giao dịch.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="TheATM-Bank-Content">
                                    <div class="TheATM-Bank-Content-Box">
                                        <div class="TheATM-Bank-Content-Icon">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="TheATM-Bank-Content-Text">
                                            <span>Nhận xác nhận ngay qua Email và SMS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="Payment-content-box">
                            <div class="Payment-content-box-left">
                                <div class="Payment-content-box-left-iconimg">
                                    <img width="38px" height="32px" style="object-fit: cover;"
                                        src="{{ asset('public/fontend/assets/img/thanhtoan/icon/icon4.png') }}"
                                        alt="">
                                </div>
                                <div class="Payment-content-box-left-text">
                                    <span>Thẻ Visa, Master Card</span>
                                </div>
                            </div>
                            <div class="Payment-content-box-right">
                                <input type="radio" name="type-payment" id="">
                            </div>
                        </div>

                        <div class="Payment-content-box">
                            <div class="Payment-content-box-left">
                                <div class="Payment-content-box-left-iconimg">
                                    <img width="38px" height="36px" style="object-fit: cover;"
                                        src="{{ asset('public/fontend/assets/img/thanhtoan/icon/icon5.png') }}"
                                        alt="">
                                </div>
                                <div style="margin-left: 3px;" class="Payment-content-box-left-text">
                                    <div class="Payment-content-box-left-text">
                                        <span>Thanh Toán Khi Nhận Hàng (COD)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="Payment-content-box-right">
                                <input type="radio" name="type-payment" id="" checked value="4">
                            </div>
                        </div>
                        <div class="Btn_payment_box">
                            {{-- <form action="{{ url('/thanh-toan/vnpay-payment') }}" method="post">
                                @csrf
                                <div class="">
                                    <button type="submit" name="redirect" value="0">Thanh Toán VN Pay Test</button>
                                </div>    
                            </form> --}}

                            <div class="Btn_payment_box-Btn">
                                <span>Thanh Toán</span>
                            </div>

                            <div class="Btn_payment_box-Dieukhoan">
                                <span>Bằng cách nhấn nút Thanh toán, bạn đồng ý với
                                    <span>Điều kiện và điều khoản</span> của chúng tôi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contentBox-Right">
                <div class="contentBox-Right-One" style="overflow-y: scroll;-webkit-scrollbar:none">
                    <div class="contentBox-Right-One-Box">

                        <div class="contentBox-Text-Bottom-Box">
                            <div class="contentBox-Text-Bottom-Box-One" style="">
                                 @if (session()->get('cart') != null)
                                    @foreach (Cart::content() as $cart)
                                        <div class="Box-Cart-Mini">
                                            <div class="Cart-img" style="height: 60px; width: 300px;display: flex;">
                                                <img style="width: 50px;height: 50px; border-radius: 50%; vertical-align: middle;"
                                                    src="{{ asset('public/fontend/assets/img/product/'.$cart->options->product_image.'') }}"
                                                    alt="">

                                                <div style="width: auto; margin-left: 10px;margin-top: -5px ;">
                                                    <p style="font-size: 15px;overflow: hidden; height: 18px;">
                                                        {{ $cart->name }}
                                                    </p>
                                                    <p style="font-size: 15px;"> SL: {{ $cart->qty }} +  @foreach ($sizes as $key => $size) 
                                                        @if($size->product_type_id == $cart->options->product_type)
                                                            {{ $size->product_type_name }}
                                                        @endif
                                                    @endforeach
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="contentBox-Text-Bottom-Box-One-Item">
                                                <div class="contentBox-Text-Bottom-Box-One-Item-Top">
                                                    <?php $price_product = $cart->qty * $cart->price ?>
                                                    <span
                                                        style="margin-left: 17px;">{{ number_format($price_product, 0, ',','.') }}đ</span>
                                                </div>
                                            </div>  
                                        </div>
                                        
                                     @endforeach
                                @endif 

                            </div>
                        </div>
                    </div>
                </div>
                <div class="contentBox-Text-Bottom">
                    <div class="contentBox-Text-Bottom-Box">
                        <div class="contentBox-Text-Bottom-Box-One">

                            <div class="contentBox-Text-Bottom-Box-One-Box">
                                <div class="contentBox-Text-Bottom-Box-One-Item">
                                    <span>Tổng giá tiền</span>
                                </div>
                                <div class="contentBox-Text-Bottom-Box-One-Item">
                                    <div class="contentBox-Text-Bottom-Box-One-Item-Top">
                                         
                                            <?php  $price_all_product = filter_var(Cart::total(), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?> 
                                            <span
                                                style="margin-left: 17px;">
                                                {{-- 90.000đ --}}
                                                {{ number_format($price_all_product, 0, ',', '.') . 'đ' }} 
                                            </span>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="contentBox-Text-Bottom-Box-One-Box">
                                <div class="contentBox-Text-Bottom-Box-One-Item">
                                    <span>Phí vận chuyển</span>
                                </div>
                                <div class="contentBox-Text-Bottom-Box-One-Item">
                                    <div class="contentBox-Text-Bottom-Box-One-Item-Top">
                                        @if (session()->get('fee') != null) 
                                            <?php $fee = session()->get('fee'); 
                                            $fee_feeship = $fee['fee_feeship']; 
                                            ?> 
                                            <span
                                                style="margin-left: 17px;">
                                                {{-- 25.000đ --}}
                                                {{ '+' . number_format($fee_feeship, 0, ',', '.') . 'đ' }} 
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                            @if (session()->get('coupon-cart') != null)
                                <?php $coupon = session()->get('coupon-cart'); ?> 
                                <div class="contentBox-Text-Bottom-Box-One-Box">
                                    <div
                                        class="contentBox-Text-Bottom-Box-One-Item contentBox-Text-Bottom-Box-One-Item-Layout">
                                        <div class="contentBox-Text-Bottom-Box-One-Item-Layout-item">
                                            <span>Mã giảm giá</span>
                                        </div>
                                        <div class="contentBox-Text-Bottom-Box-One-Item-Layout-item-Sale">
                                            <span>
                                                {{ $coupon->coupon_name_code }} 
                                                {{-- 25.000đ --}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="contentBox-Text-Bottom-Box-One-Item">
                                        <div class="contentBox-Text-Bottom-Box-One-Item-Top">
                                            <?php
                                            
                                            $price_sale = 0;
                                            $coupon_condition = $coupon->coupon_condition;
                                            if ($coupon_condition == 1) {
                                                $price_sale = ($price_all_product / 100) * $coupon->coupon_price_sale;
                                            } else {
                                                $price_sale = $coupon->coupon_price_sale;
                                            } 
                                            ?> 
                                            <span
                                                style="color: #68c78f;margin-left: 17px;">
                                                {{-- 50.000đ --}}
                                                {{ '-' . number_format($price_sale, 0, ',', '.') . 'đ' }} 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <?php $price_sale = 0; ?>
                            @endif 

                            <div class="Totalpayment">
                                <div class="Totalpayment-left">
                                    <div class="Totalpayment-left-top">
                                        <span>Tổng tiền thanh toán</span>
                                    </div>
                                    <div class="Totalpayment-bottom">
                                        <span>Đã bao gồm thuế, phí, VAT</span>
                                    </div>
                                </div>
                                <div class="Totalpayment-right">
                                    <div class="Totalpayment-right-Top">
                                        <?php
                                            if($price_all_product > $price_sale){
                                                $totalpayment = $price_all_product + $fee_feeship - $price_sale; 
                                            }else{
                                                $totalpayment = $fee_feeship;
                                            } 
                                        ?> 
                                        <span>
                                            {{-- 100.000đ  --}}
                                            {{ number_format($totalpayment, 0, ',', '.') . 'đ' }} 
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if (session()->get('coupon-cart') != null) 
                                <div class="Content-end">
                                    <i class="fa-solid fa-money-bill"></i>
                                    <span style="margin-left: 5px;">
                                        Chúc mừng! Bạn đã tiết kiệm được
                                        {{-- 25.000đ --}}
                                        {{ number_format($price_sale, 0, ',', '.') . 'đ' }}</span> 
                                </div>
                            @endif 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src=" {{ asset('public/fontend/assets/js/thanhtoan.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
       
   
    <script>
        $('#insert-notes').blur(function() {
            var content_notes = $(this).val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            
                $.ajax({
                    url: '{{ url('/thanh-toan/yeu-cau-rieng') }}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        content_notes: content_notes,
    
                    },
                    success: function(data) {
                        if (data == "true") {
                            message_toastr("success", "Đã Ghi Lại Yêu Cầu!", "Thông báo");
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
        });
    </script>

    <script>
       $('.Special-requirements').click(function(){
        if (document.getElementById("requirements-two").checked == true) {
            var choosetwo = $('#requirements-two').data('choose');
        }else {
                var choosetwo = 0;
        }
        // alert(choosetwo);
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{ url('/thanh-toan/yeu-cau-dac-biet') }}',
            method: 'get',
            data: {
                _token: _token,
                choosetwo: choosetwo,

            },
            success: function(data) {
                if (data == "true") {
                    message_toastr("success", "Đã Ghi Lại Yêu Cầu!");
                }else{
                    message_toastr('success', "Đã Hủy Yêu Cầu!")
                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            }
        })
       })

       $('.Btn_payment_box-Btn').click(function() {
            var type_payment = $('input[type="radio"][name="type-payment"]:checked').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            if(type_payment == 1){
                window.location = '{{ url('/thanh-toan/momo-payment') }}';
            }else if (type_payment == 4) {
                window.location = '{{ url('/thanh-toan/direct-payment') }}';
            }
        });
    </script>
@endsection
