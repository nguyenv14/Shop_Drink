<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang Chủ</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link REL="SHORTCUT ICON" href="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/thongtinkhachsan.css')}}">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/trangchu.css')}}">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/resTrangchu.css')}}">
    <link rel="stylesheet" href="{{  asset('public/fontend/assets/css/banner.css')}}">

    {{-- Mess toasr --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script src="https://codeseven.github.io/toastr/build/toastr.min.js"></script>
    

    <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
    <script>
        function message_toastr(type, content) {
            Command: toastr[type](content)
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }
    </script>
</head>

<style>

</style>

<body class="preloading">
    <!-- <div class="load">
        <img src="assets/img/loader.gif" alt="">
    </div> -->
    <?php
    if(session()->get('message')!=null){
       $message = session()->get('message');
       $type = $message['type'];
       $content = $message['content'];
    ?>
    <script>
        message_toastr("{{ $type }}", "{{ $content }}");
    </script>
    <?php
    session()->forget('message');
    }
    ?>

    {{-- Header  --}}

    <div class="header">
        <div class="videoContainer">
            <video type="video/mp4" autoplay="" muted="" loop="">
                <source src="{{ asset('public/fontend/assets/video/videobanner.mp4')}}" />
                Your browser does not support the video tag.
            </video>

            <div class="ContentInVideo">

                <nav class="navbar">

                    <div class="navbar-logo">
                        <a class="navbar-item-link" href="{{ url('/') }}"> <img
                                style="width: 60px; height: 45px;object-fit: cover;"
                                src="{{ asset('public/fontend/assets/iconlogo/logo1.png')}}" alt=""> </a>
                    </div>

                    <ul class="navbar-list navbar-list--left">
                        <li class="navbar-item res-navbar-item-589">
                            <a class="navbar-item-link" href="{{ url('/') }}">
                                <i class="fa-solid fa-house"></i>
                            </a>
                            <a class="navbar-item-link res-navbar-item-589" href="{{ url('/') }}"><span>Trang
                                    Chủ</span></a>
                        </li>
                        <li class="navbar-item">
                            <a class="navbar-item-link res-navbar-item-589" href="{{ url('/cua-hang') }}"><span>Shop Coffee</span></a>
                        </li>
                        <li class="navbar-item res-navbar-item-1230">
                            <a class="navbar-item-link" href=""><span>Hệ Thống Cửa Hàng</span></a>
                        </li>
                        <li class="navbar-item res-navbar-item-1297">
                            <a class="navbar-item-link" href=""><span>Thông Tin & Sự Kiện</span></a>
                        </li>
                    </ul>

                    <ul class="navbar-list navbar-list--right">
                        {{-- <li class="navbar-item res-navbar-item-1120">
                            <a class="navbar-item-link" href="">
                                <i class="fa-solid fa-gift"></i>
                            </a>
                            <a class="navbar-item-link" href="gioithieunhanqua.html">
                                Giới Thiệu Nhận Quà
                            </a>
                        </li> --}}
                        <li class="navbar-item res-navbar-item-768">
                            @if(session()->get('customer_id') != null)
                            <a class="navbar-item-link" href="{{ url('user/order?customer_id='.session()->get('customer_id').'') }}">
                                <i class="fa-solid fa-bus"></i>
                            </a>
                            @else
                            <a class="navbar-item-link" href="{{ url('user/order?customer_id=-1') }}">
                                <i class="fa-solid fa-bus"></i>
                            </a>
                            @endif
                        </li>
                        <li class="navbar-item res-navbar-item-589">
                            <a href="{{ url('/gio-hang') }}" style="cursor: pointer;" for="Notification-input" class="navbar-item-link cart">
                              
                                <i class="fa-solid fa-cart-shopping"></i> 
                             
                              <span class="count-cart">
                                {{ Cart::count(); }}
                              </span>
                            </a>
                        </li>
                        <span class="user_info">
                            
                        @if (session()->get('customer_id') != null)
                            <label class="navbar-item">
                                <a href="{{ url('user/order?customer_id='.session()->get('customer_id').'') }}" >
                                    <label class="navbar-item-link">
                                        <i class="fa-solid fa-user"></i>
                                    </label>
                                    <label class="navbar-item-link">
                                        {{ session()->get('customer_name') }}
                                    </label>
                                </a>
                            </label>
                            <a href="{{ url('user/logout') }}">
                                <label class="navbar-item">
                                    <label class="navbar-item-link">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </label>
                                    <label class="navbar-item-link">
                                        Đăng Xuất
                                    </label>
                                </label>
                            </a>
                        @else
                        <label for="nav-login-logout" class="navbar-item">
                            <label for="nav-login-logout" class="navbar-item-link">
                                <i class="fa-solid fa-user"></i>
                            </label>
                            <label for="nav-login-logout" class="navbar-item-link">
                                <i class="fa-solid fa-caret-down"></i>
                            </label>
                        </label>
                    @endif
                    </span>
                        <li class="navbar-item ">
                            <label style="cursor: pointer;" for="nav-input" class="navbar-item-link">
                                <i class="fa-solid fa-bars"></i>
                            </label>
                        </li>
                    </ul>

                    <input type="checkbox" hidden class="Notification-input-select" name="" id="Notification-input">
                    <label class="nooverlay-Notification" for="Notification-input">
                    </label>
                    <label for="Notification-input" class="Notification">
                        <div class="Notification-img">
                            <img src="assets/img/trangchu/icon_notification_empty.svg" alt="">
                        </div>
                        <div class="Notification-text">
                            <span>Không có thông báo nào!</span>
                        </div>
                    </label>

                    <input type="checkbox" hidden class="nav-login-logout-select" name=""
                        id="nav-login-logout">
                    <label class="nooverlay-login-logout" for="nav-login-logout">
                    </label>
                    <div class="nav-login-logout">
                        <div class="nav-login-logout-box">
                            <label id="dangnhap" for="input-fromlogin" class="nav-login-logout-box-item">
                                <span class="nav-login-logout-box-text">Đăng Nhập</span>
                            </label>
                            <label id="dangky" for="input-fromsignup" class="nav-login-logout-box-item">
                                <span class="nav-login-logout-box-text">Đăng Ký</span>
                            </label>
                        </div>
                    </div>

                    @include('pages.Login_Register.login')
                    @include('pages.Login_Register.register')
                    @include('pages.Login_Register.verycode')
                    @include('pages.Login_Register.recoverypw')
                    @include('pages.Login_Register.code_confirmation')
                    @include('pages.Login_Register.confirmpassword')

                    <div class="fromsignup-overlay" id="overlay">
                    </div>

                    <input type="checkbox" hidden class="nav-input-select" name="" id="nav-input">
                    <label for="nav-input" class="nav-overlay">
                    </label>
                    
                    <div class="nav-menu">
                        <div class="nav-menu-box">
                            <label for="nav-input" class="nav-menu-close">
                                <i class="nav-menu-close fa-solid fa-xmark"></i>
                            </label>
                            <ul>
                                <li class="nav-menu-item"><i style="color: #00b6f3;" class="fa-solid fa-house"></i><span
                                        class="nav-menu-item-text"><a href="{{ url('/') }}">Trang Chủ</a></span></li>
                                <li class="nav-menu-item nav-menu-item-boder"><i style="color: #00b6f3;"
                                        class="fa-solid fa-heart"></i><span class="nav-menu-item-text">Yêu Thích</span>
                                </li>
                                <li class="nav-menu-item"><i style="color: #ffc043;" class="fa-solid fa-hotel"></i><span
                                        class="nav-menu-item-text">Khách Sạn</span></li>
                                <li class="nav-menu-item"><i style="color: #ff2890;" class="fa-solid fa-plane"></i><span
                                        class="nav-menu-item-text">Vé Máy Bay</span></li>
                                <li class="nav-menu-item"><i style="color: #ff2890;"
                                        class="fa-solid fa-hand-holding-heart"></i><span class="nav-menu-item-text">The
                                        Memories</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-briefcase"></i><span class="nav-menu-item-text">Tour & Sự
                                        Kiện</span></li>
                                <li class="nav-menu-item nav-menu-item-boder"><i style="color: #48bb78;"
                                        class="fa-solid fa-book"></i><span class="nav-menu-item-text">Cẩm Năng Du
                                        Lịch</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-briefcase"></i><span class="nav-menu-item-text">Tuyển
                                        Dụng</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-headphones-simple"></i><span class="nav-menu-item-text">Hỗ
                                        Trợ</span></li>
                                <li class="nav-menu-item nav-menu-item-boder"><i style="color: #00b6f3;"
                                        class="fa-solid fa-sack-dollar"></i><span class="nav-menu-item-text">Trở Thành
                                        Đối Tác Liên Kết</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-handshake"></i><span class="nav-menu-item-text">Hợp Tác Với
                                        Chúng Tôi</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-mobile"></i><span class="nav-menu-item-text">Tải Ứng Dụng
                                        MyHotel</span></li>
                                <li class="nav-menu-item"><i style="color: #00b6f3;"
                                        class="fa-solid fa-share-nodes"></i><span class="nav-menu-item-text">Giới Thiệu
                                        Bạn Bè</span></li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <input type="checkbox" name="" hidden class="input_suports_select" id="input_suports">
                <label for="input_suports" class="suportsone">
                    <div class="suportsone-layout">
                        <div class="suportsone-title">
                            <span>Hỗ Trợ & Tư Vấn</span>
                        </div>
                        <div class="suportsone-icon">
                            <span><i class="fa-solid fa-angle-up"></i></span>
                        </div>
                    </div>
                </label>
                <div class="suportstwo">
                    <label for="input_suports" class="suportstwo-top">
                        <div class="suportstwo-layout">
                            <div class="suportsone-title">
                                <span>Hỗ Trợ & Tư Vấn</span>
                            </div>
                            <div class="suportsone-icon">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                        </div>
                    </label>
                    <div class="suportstwo-header">
                        <div class="suportstwo-header-box">
                            <div class="suportstwo-header-icon">
                                <i style="color: #ff3366; font-size: 20px;" class="fa-solid fa-headphones-simple"></i>
                            </div>
                            <div class="suportstwo-header-name">
                                <div class="suportstwo-header-name-top">
                                    <span>Nguyễn Văn Vĩnh Nguyên</span>
                                </div>
                                <div class="suportstwo-header-name-bottom">
                                    <span>Chuyên viên CSKH</span>
                                </div>
                            </div>
                            <div class="suportstwo-header-feel">
                                <div class="suportstwo-header-feel-like">
                                    <i class="suportstwo-header-feel-like fa-solid fa-thumbs-up"></i>
                                </div>
                                <div class="suportstwo-header-feel-dislike">
                                    <i class="suportstwo-header-feel-dislike fa-solid fa-thumbs-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="suportstwo-content">
                        <div class="suportstwo-content-img">
                            <img style="object-fit: cover;" src="assets/img/trangchu/cskh.png" alt="">
                        </div>
                        <div class="suportstwo-content-text">
                            <span>
                                Xin chào <b>Quý khách!</b> <br>
                                mình là <b>Nguyên Vĩnh</b>, chuyên viên <br>
                                chăm sóc khách hàng. mình có thể giúp gì <br>
                                được cho bạn?</span>
                        </div>
                    </div>
                    <div class="suportstwo-end">
                        <div class="suportstwo-end-box">
                            <div class="suportstwo-end-box-text">Chát Ngay Bây Giờ!</div>
                        </div>
                    </div>
                </div>

                <div class="BoxSearch">

                    <div class="BoxSearch-title">
                        <ul class="BoxSearch-list">
                            <li class="BoxSearch-item">
                                <span class="BoxSearch-link" href=""><i class="fa-solid fa-mug-saucer"></i></span>
                                <span class="BoxSearch-link" href="">Tìm Kiếm Tên Sản Phẩm</span>
                            </li>
                        </ul>
                    </div>

                    <div class="BoxSearch-Bottom">
                        <div class="BoxSearch-Bottom-One">
                            <div class="BoxSearch-Bottom-One-Title">
                                Nhập dô để tìm kiếm!
                            </div>
                            <form class="BoxSearch-Bottom-One-Input">
                                <input class="BoxSearch-Bottom-One-input-size" type="text"
                                    placeholder="Cà phê, trà sữa,...">
                                <div class="inputsearchhotel">

                                </div>
                            </form>
                        </div>
                        <a href="thongtinkhachsan.html">
                            <div class="BoxSearch-Bottom-BtnSrearch">
                                <div class="BoxSearch-Bottom-BtnSrearch-Box">
                                    <i class="fa-solid fa-magnifying-glass BoxSearch-Bottom-BtnSrearch-Box-Icon"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kết thúc header --}}



  


    @yield('web_content')

    {{-- Footer --}}

    <div class="infohotel">
        <div class="BoxNhapSDT">
            <div class="BoxNhapSDT-left">
                <div class="BoxNhapSDT-left-img">
                    <img src="assets/img/trangchu/icon_mail_red.svg" alt="">
                </div>
                <div class="BoxNhapSDT-left-text">
                    <div class="BoxNhapSDT-left-text-title">
                        <span>Bạn muốn tiết kiện 50% khi đặt hải sản ?</span>
                    </div>
                    <div class="BoxNhapSDT-left-text-content">
                        <span>Nhập số điện thoại để Thế Giới Hải Sản có thể gửi đến bạn những chương trình khuyến mại
                            mới nhất!</span>
                    </div>
                </div>
            </div>
            <div class="BoxNhapSDT-right">
                <div class="BoxNhapSDT-right-Groupinput">
                    <div class="BoxNhapSDT-right-input">
                        <input type="text" placeholder="Nhập số điện thoại">
                    </div>
                    <label class="BoxNhapSDT-right-lable" for="">
                        <span>Đăng ký</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="infohotel-box">
            <div class="infohotel_logo">
                <img width="90px" height="55px" style="object-fit: cover;"
                    src="{{ asset('public/fontend/assets/img/config/' . $config_logo_web->config_image) }}"
                    alt="">
            </div>
            <div class="infohotel_content">
                <div class="infohotel_content_box">
                    <div class="infohotel_content_title">
                        {{ $company_config->company_name }}
                    </div>
                    <div class="infohotel_content_text">
                        Tổng đài chăm sóc: {{ $company_config->company_hostline }}
                        <br>
                        Email: {{ $company_config->company_mail }}
                        <br>
                        Văn phòng Đà Nẵng: {{ $company_config->company_address }}
                        <br>
                    </div>
                </div>
                <div class="infohotel_content_box">
                    <div class="infohotel_content_title">
                        Chính sách & Quy định
                    </div>
                    <div class="infohotel_content_text">
                        Điều khoản và điều kiện <br>
                        Quy định về thanh toán <br>
                        Chính sách bảo mật thông tin <br>
                        Quy chế hoạt động <br>
                        Quy trình giải quyết tranh chấp, khiếu nại <br>
                    </div>
                </div>
                <div class="infohotel_content_box">
                    <div class="infohotel_content_title">
                        Khách hàng và đối tác
                    </div>
                    <div class="infohotel_content_text">
                        Đăng nhập HMS <br>
                        Tuyển dụng <br>
                        Liên hệ <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-content">
            <div class="footer-content">
                {{ $company_config->company_slogan }}
                {{-- BonoDrinks - Drinks Coffee and Chilling with Mucsic  --}}
            </div>
            <div class="footer-content">
                @foreach ($config_brand_web as $brand)
                <a href="{{ $brand->config_content }}" target="_blank"><img width="100px" height="70px"
                    style="border-radius: 8px;object-fit: cover; margin:15px"
                    src="{{ asset('public/fontend/assets/img/config/' . $brand->config_image) }}"
                    alt=""></a>
                @endforeach
            </div>
            <div class="footer-content">
                {{ $company_config->company_copyright }}
                {{-- Copyright © 2022 - Đồ Án Cơ Sở 2 - Đề Tài Website Thương Mai BonoDrinks - Nguyễn Văn Vĩnh Nguyên - Trương Thanh Tùng - Website Bắt Đầu Thực Hiện Vào Ngày 16/10 --}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="shopping" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle"><span>Đặt Hàng Sản Phẩm</span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="row">
                <div class="col-lg-5 col-sm-12 img">
                    <img class="flashsalehotel_img" width="284px" height="160px" style="object-fit: cover;"
                    src="https://product.hstatic.net/1000075078/product/bg-cloudfee-roasted-almond_ac9a236a27274a568ac6c8630047859f_large.jpg" alt="">
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="product_name">
                        <h2>Sản phẩm</h2>
                    </div>
                    <div class="flashsalehotel_place">
                        <div class="category_name">
                            <i class="fa-solid fa-certificate"></i>
                            Danh Mục Sản Phẩm
                        </div>
                        <br>
                        <div class="price">
                            39.000đ/29.000đ
                        </div>
                    </div><hr width="100%">

                    <div class="product-size-box">
                        <div class="product-size">
                            
                               <div class="size-main">
                                <label class="size-detail" for="nho"><i class="fas fa-coffee"></i> Nhỏ + 0đ</label>
                                <input id="nho" type="radio" name="size" hidden>
                               </div>
                                <div class="size-main">
                                    <label class="size-detail" for="vua"><i class="fas fa-coffee"></i> Vừa + 6.000đ</label>
                                    <input id="vua" type="radio" name="size" hidden>
                                </div>
        
                                <div class="size-main">
                                    <label class="size-detail" for="lon"><i class="fas fa-coffee"></i> Lớn + 10.000đ</label>
                                    <input id="lon" type="radio" name="size" hidden> 
                                </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row quantity_row">
                        <div class="quantity-class">
                            <span>Số lượng: </span> <input type="number" min="1" max="100" value="1">
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div class="modal-button">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger button_cart" data-dismiss=""><i class="fa-solid fa-cart-shopping" ></i>Thêm vào giỏ</button>
                </div>
            </div>
          </div>
        </div>
    </div>



    {{-- Kết thúc Footer --}}
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('public/fontend/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('public/fontend/assets/js/main.js')}}"></script>
    <script src="{{ asset('public/fontend/assets/js/trangchu.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    
    {{-- Captcha gg --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    {{-- Mess toasr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        new WOW().init();
    </script>

    <script>

$(document).on('click','.size-main',function(){
            $(this).addClass('active').siblings().removeClass('active');
        })

        Validator({
            form: '#form-1',
            errorSelector: '.form-message',
            rules: [
            Validator.isRequired('#fullname' , 'Vui lòng nhập tên đầy đủ của bạn'),
            Validator.isRequired('#email'),
            Validator.isEmail('#email'),
            Validator.isRequired('#phone'),
            Validator.minLength('#password',6),
            Validator.isRequired('#password_confirmation'),
            Validator.isConfirmed('#password_confirmation', function(){
                return document.querySelector('#form-1 #password').value;
            }, 'Mật khẩu nhập lại không chính xác')
            ]
        });


        Validator({
            form: '#login',
            errorSelector: '.form-message',
            rules: [
            Validator.isRequired('#email'),
            Validator.isEmail('#email'),
            Validator.minLength('#password',6),
            ]
        });

        

        function message_toastr(type, title, content) {
            Command: toastr[type](content, title)

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }

        //$(document).onload(function(){
            $('.fromsignup-btn').click(function(){
                if($('.form-message').text() != ''){
                  //  alert("dô");
                    $("#form-1").submit(function(e){
                        e.preventDefault();
                    });
                }
            })
        //})



        
    </script>
    <script>
        $('#overlay').click(function() {
            $("#form-1").css({
                "display": "none"
            });
            $("#from-verycode").css({
                "display": "none"
            });
            $("#overlay").css({
                "display": "none"
            });
            $(".fromlogin").css({
                "display": "none"
            });
            $(".form-vecovery-password").css({
                "display": "none"
            });
            $(".code_confirmation").css({
                "display": "none"
            });
            $(".password_confirmation").css({
                "display": "none"
            });
            $('#ShowImgHotel').hide();
        });
        $('.close-box').click(function() {
            $("#form-1").css({
                "display": "none"
            });
            $(".from-verycode").css({
                "display": "none"
            });
            $("#overlay").css({
                "display": "none"
            });
            $(".fromlogin").css({
                "display": "none"
            });
            $(".form-vecovery-password").css({
                "display": "none"
            });
            $(".code_confirmation").css({
                "display": "none"
            });
            $(".password_confirmation").css({
                "display": "none"
            });
        });

        $('#dangnhap').click(function() {
            $(".fromlogin").css({
                "display": "flex"
            });
            $("#overlay").css({
                "display": "flex"
            });
        });
        $('#dangky').click(function() {
            $("#form-1").css({
                "display": "flex"
            });
            $("#overlay").css({
                "display": "block"
            });
        });
        $('#loginaccount').click(function() {
            $("#form-1").css({
                "display": "none"
            });
            $(".fromlogin").css({
                "display": "block"
            });
        });
        $('#registeraccount').click(function() {
            $("#form-1").css({
                "display": "block"
            });
            $(".fromlogin").css({
                "display": "none"
            });
        });
        $('#recoverypassaccount').click(function() {
            $(".form-vecovery-password").css({
                "display": "block"
            });
            $(".fromlogin").css({
                "display": "none"
            });
        });
    </script>


 {{-- Js về đăng ký tài khoản --}}
 <script>
    $("#btn-register-account").on("click", function() {

        if (document.getElementById("customer_checkbox_user").checked == true) {
            var customer_name = $("input[name='customer_name_user']").val();
            var customer_phone = $("input[name='customer_phone_user']").val();
            var customer_email = $("input[name='customer_email_user']").val();
            var customer_password = $("input[name='customer_password1_user']").val();
            var customer_password2 = $("input[name='customer_password2_user']").val();
            var _token = $("input[name='_token']").val();

        $.ajax({
            url: '{{ url('/user/create-customer') }}',
            method: 'POST',
            data: {
                customer_name: customer_name,
                customer_phone: customer_phone,
                customer_email: customer_email,
                customer_password: customer_password,
                customer_password2: customer_password2,
                _token: _token,
            },
            success: function(data) {
                if(data == 'trung'){
                    message_toastr("warning", "Cảnh Báo !", "Tai khoản Hoặc Email đã được đăng ký!");
                }else{
                    $(".fromsignup").css({
                        "display": "none"
                    });
                    $(".from-verycode").css({
                        "display": "block"
                    });
                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            }
        })
        }else {
            message_toastr("warning", "Cảnh Báo !", " Bạn Chưa Đồng Ý Điều Khoản !");
        }
        
    });

    $("#submit_verycode").on("click", function() {

        var verycoderg = $("input[name='very_code']").val();
        var _token = $("input[name='_token']").val();

        $.ajax({
            url: '{{ url('/user/verification-code-rg') }}',
            method: 'POST',
            data: {
                verycoderg: verycoderg,
                _token: _token,
            },
            success: function(data) {
                if (data == "error_very_code") {
                    message_toastr("error", "Mã Xác Nhận Sai !!! Nhập Lại Nhé Ahihi :>", "Lỗi !");
                } else {
                    message_toastr("success", "Đăng Ký Tài Khoản Thành Công !", "Thành Công !");
                    $(".from-verycode").css({
                        "display": "none"
                    });
                    $("#overlay").css({
                        "display": "none"
                    });
                    $(".fromlogin").css({
                        "display": "block"
                    });

                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            }
        })
    });
</script>

<script>
    $("#submit_emailorname").on("click", function() {

        var customer_name_mail = $("input[name='emailorname']").val();
        var _token = $("input[name='_token']").val();

        $.ajax({
            url: '{{ url('/user/find-account-recovery-pw') }}',
            method: 'POST',
            data: {
                customer_name_mail: customer_name_mail,
                _token: _token,
            },
            success: function(data) {
                if (data == "account_not_found") {
                    message_toastr("error", "Không thành công", "Tài Khoản Không tồn tại trong hệ thống")
                    
                }else{
                    $(".code_confirmation").css({
                        "display": "block"
                    });
                    $(".form-vecovery-password").css({
                        "display": "block"
                    });
                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            },
        })
    });


    $("#submit_code_confirmation").on("click", function() {
        var verycoderc = $("input[name='very_code_rc']").val();
        var _token = $("input[name='_token']").val();
        $.ajax({
            url: '{{ url('/user/verification-code-rc') }}',
            method: 'POST',
            data: {
                verycoderc: verycoderc,
                _token: _token,
            },
            success: function(data) {
                if (data == "error_very_code") {
                    message_toastr("error",  "Lỗi !","Mã Xác Nhận Sai !!! Nhập Lại Nhé");
                } else {
                    message_toastr("success", "Hãy Đặt Lại Mật Khẩu !", "Xác Nhận Thành Công !");
                    $(".code_confirmation").css({
                        "display": "none"
                    });
                    $(".password_confirmation").css({
                        "display": "block"
                    });
                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            }
        })
    });
    $("#submit_password_confirmation").on("click", function() {
        var password1 = $("input[name='password1']").val();
        var password2 = $("input[name='password2']").val();
        var _token = $("input[name='_token']").val();

        $.ajax({
            url: '{{ url('/user/confirm-password') }}',
            method: 'POST',
            data: {
                password1: password1,
                password2: password2,
                _token: _token,
            },
            success: function(data) {
                if (data == 'success') {
                    message_toastr("success", "Mật Khẩu Đã Được Đặt Lại!", "Hoàn Thành !");

                    $(".password_confirmation").css({
                        "display": "none"
                    });
                    $("#overlay").css({
                        "display": "none"
                    });
                    $(".fromlogin").css({
                        "display": "block"
                    });
                    /* Bug Không Xác Định */
                    $(".form-vecovery-password").css({
                        "display": "none"
                    });

                } else if(data == 'error'){
                    message_toastr("error", "Mật Khẩu Không Khớp Nhau !", "Lỗi !");
                }else if(data == 'error1'){
                    message_toastr("error", "Đã xảy ra lỗi !", "Lỗi !");
                }
            },
            error: function() {
                alert("Bug Huhu :<<");
            }
        })
    });
</script>

<script>
    // Hàm search 
    $('.BoxSearch-Bottom-One-input-size').keyup(function(){
        var text = $(this).val();
        // console.log(text);
        // var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{ url('/trang-chu/search-product') }}',
            method: 'get',
            data: {
                text: text
                // _token: _token,
            },
            success: function(data) {
               $('.inputsearchhotel').html(data);
            },
            error: function() {
                alert("Search box Bug Huhu :<<");
            }
        })
    })  
</script>

<script>
    load_quantity_cart();
    function load_quantity_cart(){
        $.ajax({
                url: '{{ url('/gio-hang/load-quantity-cart') }}',
                method: 'get',
                data: {
                    // _token: _token,
                
                },
                success: function(data) {
                    // load_cart();
                    $('.count-cart').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
    }
</script>

{{-- Thêm vào giỏ hàng --}}
<script>
    //  $(".size-main").click(function(){
    //         $('.button_cart').attr('data-dismiss', 'modal');
    //     })
    // load_user_login();

    // function load_user_login(){
    //     $.ajax({
    //             url: '{{ url('/user/load-login-customer') }}',
    //             method: 'get',
    //             data: {
    //                 // _token: _token,
                
    //             },
    //             success: function(data) {
    //                 // load_cart();
    //                 $('.user_info').html(data);
    //             },
    //             error: function() {
    //                 alert("Bug Huhu :<<");
    //             }
    //         })
    // }

    // $('#btn-login-submit').click(function(){
    //         var customer_name = $("input[name='customer_name']").val();
    //         var customer_password = $("input[name='customer_password']").val();
    //         var _token = $('meta[name="csrf-token"]').attr('content'); 
    //         if( customer_name == '' || customer_password == ''){
                
    //             if(customer_name == ''){
    //                 message_toastr('error', 'Tên tài khoản chưa được nhập!');
    //             }
    //             if(customer_password == ''){
    //                 message_toastr('error', 'Mật khẩu chưa được nhập');s
    //             }

    //         }
    //         else{
    //             $.ajax({
    //                 url: '{{ url('user/login-customer') }}',
    //                 method: 'post',
    //                 data: {
    //                     customer_name: customer_name,
    //                     customer_password: customer_password,
    //                     _token: _token, 
    //                 },
    //                 success: function(data) {
    //                     if(data == 'error'){
    //                         message_toastr("warning", "Tên Tài Khoản Hoặc Mật Khẩu Không Chính Xác !", "Cảnh Báo !");
    //                     }else{
    //                         load_user_login();
    //                         message_toastr("success", "Đăng Nhập Thành Công !", "Thành Công !");
    //                         $("#overlay").css({
    //                             "display": "none"
    //                         });
    //                         $(".fromlogin").css({
    //                             "display": "none"
    //                         });
    //                     }
    //                 },
    //                 error: function() {
    //                     alert("Bug Huhu :<<");
    //                 }
    //             })
    //         }


    //     });
    
    
    $(document).on("click", '.button_cart', function() {
        var product_id = $("#product_id").val();       
        var product_qty = $('#quantity').val();
        var product_type = $("input[name='size']:checked").val();
        // $('.button_cart').attr('data-dismiss', '');
        // alert(product_id + " " + product_type + " " + product_qty);
        // $("input[name='size']").click(function(){
        //     $('.button_cart').attr('data-dismiss', 'modal');
        // });
        if($("input[name='size']").is(':checked') == false){
           
            message_toastr('warning', 'Bạn chưa chọn size đồ uống !!');
         
            $('.button_cart').attr('data-dismiss', 'modal');
        }else{
            
            $.ajax({
                url: '{{ url('/gio-hang/save-cart') }}',
                method: 'get',
                data: {
                   
                    product_id: product_id,
                    product_qty: product_qty,
                    product_type: product_type
                },
               
                success: function(data) {
                    // load_cart();
                    // $('#shopping').hide();
                    // $('.button_cart').attr('data-dismiss', 'modal');
                    load_quantity_cart();
                        message_toastr("success",
                            'Bạn đã thêm sản phẩm vào giỏ hàng!!!',
                            'Thành công');
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })

        }
    });

    $('.modal').on('click', "input[name='size']", function(){
            // alert('hihi');
            var product_type_id = $(this).val();
            var product_id = $("#product_id").val();

            // alert(product_type_id);
            $.ajax({
                url: '{{ url('/san-pham/edit-price') }}',
                method: 'get',
                data: {
                   
                    product_id: product_id,
                    product_type_id: product_type_id,
                    // product_type: product_type
                },
                success: function(data) {
                    // load_cart();
                    // $('#shopping').hide();
                    // $('.button_cart').attr('data-dismiss', 'modal');
                    $('.flashsalehotel_place .price').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
    })

    $(document).on('click', '.cart-hover', function(){
        $('.modal').addClass('loading_product');
        var product_id = $(this).data('product_id');
        
        $("input[name='size']").click(function(){
            $('.button_cart').attr('data-dismiss', 'modal');
        });

        $.ajax({
            url: '{{ url('/trang-chu/show-detail-product') }}',
            method: 'get',
            data: {
                product_id : product_id
            },
            success: function(data) {
                $('.modal .modal-body').html(data);
                $('.modal .button_cart').attr('data-dismiss', '');
                $("input[name='size']").click(function(){
                    $('.modal .button_cart').attr('data-dismiss', 'modal');
                });
                // $(this).attr('data-target', '#shopping');
        $('.modal').removeClass('loading_product');
            },
            error: function() {
                alert("Ngu sửa Bug đi con Huhu :<<");
            }
        })
    })
</script>
</body>

</html>