<!DOCTYPE html>
<html lang="en">
<?php 
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href=" {{ asset('public/backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('public/backend/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('public/backend/assets/images/favicon.ico') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Toastr Css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <style>
        @font-face {
            
            src: url({{ asset('public/backend/assets/fonts/Mt-Regular.otf') }});
            
        }

        .chongloihuhu {}
    </style>
    <script>
          function message_toastr(type, content) {
            Command: toastr[type](content)
            toastr.options = {
                "closeButton": true,
                "debug": true,
                "newestOnTop": false,
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

<body>

    <?php
    if(session()->get('message') != null){
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
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="{{ URL::to('admin/dashboard') }}"><img
                        src="{{ asset('public/backend/assets/images/logo.svg') }}" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href=""><img
                        src="{{ asset('public/backend/assets/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <div class="search-field d-none d-md-block">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search projects">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{ asset('public/backend/assets/images/faces/face1.jpg') }}" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">
                                    <?php
                                    // dd(Auth::user());
                                    // $admin_name = session()->get('Auth_info');
                                    // if (session()->get('Auth_info')) {
                                        // echo $admin_name['admin_name'];
                                    // }
                                    if (Auth::check()) {
                                    echo Auth::user()->admin_name;
                                }
                                    ?></p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ URL::to('/admin/auth/logout') }}">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="mdi mdi-email-outline"></i>
                          <span class="count-symbol bg-warning"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                          <h6 class="p-3 mb-0">Messages</h6>
                          <div class="dropdown-divider"></div>
                          <div class="load_mess">

                          </div>
                          
                          <div class="dropdown-divider"></div>
                        </div>
                      </li>

                    <li class="nav-item d-none d-lg-block full-screen-link">
                        <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                        </a>
                    </li>

                    <li class="nav-item nav-logout d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-format-line-spacing"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="{{ asset('public/backend/assets/images/faces/face1.jpg') }}" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2"><?php
                                
                                if (Auth::check()) {
                                    echo Auth::user()->admin_name;
                                }
                                ?>
                                </span>
                                <span class="text-secondary text-small">Quản Lý Dự Án</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ URL::to('admin/dashboard') }}">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>

                    @hasrole('admin')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-roles" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Admin</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-account-multiple"></i>
                        </a>
                        <div class="collapse" id="ui-basic-roles">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/auth') }}">Danh Sách Admin</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/auth/add-admin') }}">Thêm Nhân Viên</a></li>
                            </ul>
                        </div>
                    </li>
                    @endhasrole

                    @hasanyroles(['admin', 'manager'])
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-user" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý User</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-account-multiple"></i>
                        </a>
                        <div class="collapse" id="ui-basic-user">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/user') }}">Danh Sách User</a></li>
                                {{-- <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/auth/add-admin') }}">Thêm </a></li> --}}
                            </ul>
                        </div>
                    </li>

                    @endhasanyroles

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-slider" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Slider</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-animation"></i>
                        </a>
                        <div class="collapse" id="ui-basic-slider">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/slider/all-slider') }}">Danh Sách Slider</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/slider/add-slider') }}">Thêm Slider</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-category"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Danh Mục</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-format-list-bulleted"></i>
                        </a>
                        <div class="collapse" id="ui-basic-category">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/category/all-category') }}">Danh Sách Danh Mục</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/category/add-category') }}">Thêm Danh Mục</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-product" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Sản Phẩm</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-food-fork-drink"></i>
                        </a>
                        <div class="collapse" id="ui-basic-product">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/product/all-product') }}">Danh
                                        Sách Sản Phẩm</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/product/add-product') }}">Thêm
                                        Sản Phẩm</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-type"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Size</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-glass-mug"></i>
                        </a>
                   

                        <div class="collapse" id="ui-basic-type">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('admin/product/product-type/all-product-type') }}">Danh Sách Loại Sản Phẩm</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                    href="{{ URL::to('admin/product/product-type/add-product-type') }}">Thêm Loại Sản Phẩm</a>
                            </li>
                            </ul>
                        </div>
                    </li>

                    @hasanyroles(['admin', 'manager'])
                    <li class="nav-item">

                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-coupon" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Sự Kiện Ưu Đãi</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-coupon">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    Quản Lí Mã Giảm Giá
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/coupon/all-coupon') }}">Danh
                                        Sách Mã Giảm Giá</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/coupon/add-coupon') }}">Thêm
                                        Mã Giảm
                                        Giá</a>
                                </li>
                            </ul>

                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    Quản Lí Sự Kiện FlashSale
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/flashsale/all-product-flashsale') }}">Danh
                                        Sách Sản Phẩm</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/flashsale/add-product-flashsale') }}">Thêm
                                        Sản Phẩm Vào SK</a>
                                </li>
                            </ul>

                        </div>

                    </li>
                    @endhasanyroles
                    @hasanyroles(['admin', 'manager'])
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-delivery"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Phí Ship</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-truck-delivery"></i>
                        </a>
                   

                        <div class="collapse" id="ui-basic-delivery">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('admin/delivery') }}">Danh Sách Phí Ship</a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>
                    @endhasanyroles

                    <li class="nav-item" style="margin-top:-10px ">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-order" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Đơn Hàng</span>
                            <i class="menu-arrow"></i>
                            <i style="font-size: 20px" class="mdi mdi-clipboard-outline"></i>
                        </a>
                        <div class="collapse" id="ui-order">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/order-manager') }}">Danh
                                        Sách Đơn Hàng</a></li>
                                {{-- <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/add-product') }}">Thêm Sản Phẩm</a></li> --}}
                            </ul>
                        </div>
                    </li>

                    @hasrole('admin')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-config-web"
                            aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Cấu Hình WebSite</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-account-circle menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic-config-web">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ URL::to('/admin/web') }}">Cấu
                                        Hình Web</a></li>

                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/config-footer') }}">Cấu Hình Footer</a></li>
                            </ul>
                        </div>
                    </li>
                    @endhasrole

                    @impersonate
                    <li class="nav-item" style="margin-top:-10px ">
                        <a class="nav-link"  href="{{ url('/admin/auth/destroy-impersonate') }}" >
                            <span class="menu-title">Hủy Chuyển Quyền  
                                <i style="font-size: 20px" class="mdi mdi-account-key"></i>    
                            </span>   
                            
                           
                        </a>
                        
                    </li>
                    @endimpersonate

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-news" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Báo</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-newspaper"></i>
                        </a>
                        <div class="collapse" id="ui-basic-news">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/admin/news') }}">Danh Sách Báo</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('admin/news/add-news') }}">Thêm Báo</a></li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item" style="margin-top:-10px ">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-delivery" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Quản Lý Vận Chuyển</span>
                            <i class="menu-arrow"></i>
                            <i style="font-size: 20px" class="mdi mdi-clipboard-outline"></i>
                        </a>
                        <div class="collapse" id="ui-delivery">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="{{ URL::to('/show-delivery') }}">Thiết Lập Phí Vận Chuyển</a></li>
                               
                            </ul>
                        </div>
                    </li> --}}


                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('admin_content')

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid d-flex justify-content-between">
                        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Đồ Án Cơ Sở 2</span>
                        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Nguyên - Tùng - Laravel</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    
    
    {{-- capcha gg --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('public/backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    

    
    <!-- Plugin js for this page -->
    <script src="{{ asset('public/backend/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    
    
    
    <!-- inject:js -->
    <script src="{{ asset('public/backend/assets/js/off-canvas.js') }}"></script>
    <script src=" {{ asset('public/backend/assets/js/hoverable-collapse.js') }}"></script>
    <script src=" {{ asset('public/backend/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    
    
    <!-- Custom js for this page -->
    <script src="  {{ asset('public/backend/assets/js/dashboard.js') }}"></script>
    <script src=" {{ asset('public/backend/assets/js/todolist.js') }}"></script>
    <!-- End custom js for this page -->

    {{-- Js Toast  --}}



    {{-- Toàn Bộ Script Liên Quan Đến Product --}}
    <script>
        // $(document).ready(function() {
        //     // load_all_product();
        //     function load_all_product() {
        //         $.ajax({
        //             url: '{{ url('/admin/product/all-product-ajax') }}',
        //             method: 'GET',
        //             data: {

        //             },
        //             success: function(data) {
        //                 // alert(data);
        //                 $('#loading_all_product').html(data);
        //             },
        //             error: function(data) {
        //                 alert("Nguyên Ơi Fix Bug Huhu :<");
        //             },
        //         });
        //     }
        // });

            setInterval(() => {
                $.ajax({
                    url: '{{ url('/admin/order-manager/load-count-order') }}',
                    method: 'GET',
                    data: {

                    },
                    success: function(data) {
                        // alert(data);
                        $('.load_mess').html(data);
                    },
                    error: function(data) {
                        alert("Nguyên Ơi Fix Bug Huhu :<");
                    },
                });
            }, 5000);

       
    </script>



</body>

</html>
