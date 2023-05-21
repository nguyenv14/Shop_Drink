<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\APICategoryProduct;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FlashsaleController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LoginAndRegister;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfigWebController;
use App\Http\Controllers\CompanyConfigController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\CommentProductController;
use App\Http\Controllers\NewsPageContentController;
use App\Http\Controllers\UserController;

/* Back-end */


Route::group(['prefix' => 'admin/auth'], function () {
    Route::get('/register-auth', [AuthController::class, 'register_auth']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login-auth', [AuthController::class, 'login_auth']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
});


Route::group(['middleware' => 'protect.auth'], function () {
    Route::group(['prefix' => 'admin/auth'], function () {
        Route::group(['middleware' => 'admin.roles'], function () {
            Route::get('/', [AdminController::class, 'all_admin']);
            Route::get('/loading-admin', [AdminController::class, 'loading_admin']);

            Route::get('/add-admin', [AdminController::class, 'add_admin']);
            Route::post('/save-admin', [AdminController::class, 'save_admin']);
            Route::post('/assign-roles', [AdminController::class, 'asssign_roles']);
            Route::get('/delete-admin', [AdminController::class, 'delete_admin']);
            Route::get('/count-delete', [AdminController::class, 'count_delete']);
            Route::get('/impersonate', [AdminController::class, 'impersonate']);
            
            Route::get('/trash-admin', [AdminController::class, 'trash_admin']);
            Route::get('/trash-admin/loading-delete-admin', [AdminController::class, 'loading_delete_admin']);
            Route::get('/trash-admin/restore-delete-admin', [AdminController::class, 'restore_delete_admin']);
            
        }); 
        Route::get('/destroy-impersonate', [AdminController::class, 'destroy_impersonate']);
    });

    Route::group(['prefix' => 'admin/web'], function () {
        Route::group(['middleware' => 'admin.roles'], function () {
            Route::get('/', [ConfigWebController::class, 'show_config']);
            Route::post('/insert-config-image', [ConfigWebController::class, 'insert_config_image']);
            Route::post('/load-config-slogan', [ConfigWebController::class, 'loading_config_slogan']);
            Route::post('/edit-config-title', [ConfigWebController::class, 'edit_config_title']);
            Route::post('/edit-config-content', [ConfigWebController::class, 'edit_config_content']);
            Route::post('/update-image-config', [ConfigWebController::class, 'update_image_config']);
            Route::post('/load-logo-config', [ConfigWebController::class, 'load_logo_config']);
            Route::post('/delete-config-slogan', [ConfigWebController::class, 'delete_config_slogan']);
            Route::get('/load-config-brand', [ConfigWebController::class, 'load_config_brand']);
        }); 
    });

    Route::group(['prefix' => 'admin/config-footer'], function () {
        Route::group(['middleware' => 'admin.roles'], function () {
            Route::get('/', [CompanyConfigController::class, 'show_company_config']);
            Route::post('/edit-content-footer', [CompanyConfigController::class, 'edit_content_footer']);
        }); 
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'show_dashboard']);
        Route::get('/dashboard',  [AdminController::class, 'show_dashboard']);
        Route::get('/dashboard/filter-doanh-thu',  [DashBoardController::class, 'filter_doanh_thu']);
        Route::get('/dashboard/doanh-thu-five-day',  [DashBoardController::class, 'doanh_thu_five_day']);

        
    });



    /* Slider */
    Route::group(['prefix' => 'admin/slider'], function () {
        Route::get('/', [SliderController::class, 'all_slider']);
        Route::get('/load-slider', [SliderController::class, 'load_slider']);
        Route::get('/add-slider', [SliderController::class, 'add_slider']);
        Route::post('/save-slider', [SliderController::class, 'save_slider']);
        Route::get('/all-slider', [SliderController::class, 'all_slider']);
        Route::get('/un-active-slider', [SliderController::class, 'un_active_slider']);
        Route::get('/edit-slider', [SliderController::class, 'edit_slider']);
        Route::post('/update-slider', [SliderController::class, 'update_slider']);


        Route::get('/count-delete', [SliderController::class, 'count_delete']);
        Route::get('/trash-slider', [SliderController::class, 'trash_slider']);
        Route::get('/trash-slider/load-slider-delete-soft', [SliderController::class, 'load_slider_delete_soft']);
        Route::get('/delete-soft-slider', [SliderController::class, 'delete_soft_slider']);
        Route::get('/trash-slider/un-or-force-delete-slider', [SliderController::class, 'un_or_force_delete_slider']);
    });

    /* Category Product */
    Route::group(['prefix' => 'admin/category'], function () {
        Route::get('/', [CategoryController::class, 'all_category']);
        Route::get('/all-category', [CategoryController::class, 'all_category']); // đưa về view
        Route::get('/add-category', [CategoryController::class, 'add_category']); // thêm danh mục
        Route::get('/load-category', [CategoryController::class, 'load_category']); // load danh mục = ajax
        Route::get('/edit-category', [CategoryController::class, 'edit_category']); // đưa về view chỉnh sửa
        Route::post('/update-category', [CategoryController::class, 'update_category']); // cập nhập danh mục
        Route::post('/save-category', [CategoryController::class, 'save_category']); // lưu khi thêm danh mục
        Route::get('/un-active-category', [CategoryController::class, 'un_active_category']); // vô hiệu hoặc kích hoạt danh mục
        Route::get('/count-delete', [CategoryController::class, 'count_delete']); // đếm slider nằm trong thùng rác


        Route::get('/delete-soft-category', [CategoryController::class, 'delete_soft_category']); // xóa vào thùng rác
        Route::get('/trash-category', [CategoryController::class, 'trash_category']); //view thùng rác
        Route::get('/trash-category/delete-restore-category', [CategoryController::class, 'delete_restore_category']); // khôi phục và xóa 
        Route::get('/trash-category/load-delete-soft-category', [CategoryController::class, 'load_delete_soft_category']);
    });

    
    Route::group(['prefix' => 'admin/user'], function () {
        Route::get('/', [UserController::class, 'all_user']);
        Route::get('/loading-user', [UserController::class, 'loading_user']);
        Route::get('/active-unactive-user', [UserController::class, 'active_unactive_user']);
        Route::get('/search-user', [UserController::class, 'search_user']);
        
    });



    /* Product */
    Route::group(['prefix' => 'admin/product'], function () {
        /* Product */
        Route::get('/', [ProductController::class, 'all_product']);
        Route::get('/all-product', [ProductController::class, 'all_product']);
        Route::get('/load-product', [ProductController::class, 'load_product']);
        Route::get('/product-detail', [ProductController::class, 'product_detail']);
        Route::get('/count-delete', [ProductController::class, 'count_delete']);


        Route::get('/add-product', [ProductController::class, 'add_product']);
        Route::post('/save-product', [ProductController::class, 'save_product']);
        Route::get('/edit-product', [ProductController::class, 'edit_product']);
        Route::post('/update-product', [ProductController::class, 'update_product']);
        Route::get('/un-active-product', [ProductController::class, 'un_active_product']);
        Route::get('/all-product-sreachbyname', [ProductController::class, 'all_product_sreachbyname']);
        Route::get('/sort-product-by-category', [ProductController::class, 'sort_product_by_category']);
        Route::get('/all-product-sreach', [ProductController::class, 'all_product_sreach']);
        Route::get('/sort-all', [ProductController::class, 'sort_all']);


        /* Gallery */
        Route::post('/insert-gallery', [ProductController::class, 'insert_gallery']);
        Route::get('/loading-gallery', [ProductController::class, 'loading_gallery']);
        Route::post('/update-image-gallery', [ProductController::class, 'update_image_gallery']);
        Route::post('/delete-gallery', [ProductController::class, 'delete_gallery']);
        Route::post('/update-content-gallery', [ProductController::class, 'update_content_gallery']);
        
        
        
        /*  */
        Route::post('/delete-soft-product', [ProductController::class, 'delete_soft_product']);

        Route::get('/trash-product', [ProductController::class, 'trash_product']);
        Route::get('/trash-product/load-delete-soft-product', [ProductController::class, 'load_delete_soft_product']);
        Route::get('/trash-product/delete-restore-product', [ProductController::class, 'delete_restore_product']);



        /* Loại sản phẩm */

        Route::get('/product-type', [ProductTypeController::class, 'all_product_type']);
        Route::get('/product-type/all-product-type', [ProductTypeController::class, 'all_product_type']);
        Route::get('/product-type/load-product-type', [ProductTypeController::class, 'load_product_type']);
        Route::get('/product-type/add-product-type', [ProductTypeController::class, 'add_product_type']);
        Route::post('/product-type/save-product-type', [ProductTypeController::class, 'save_product_type']);
        Route::get('/product-type/edit-product-type', [ProductTypeController::class, 'edit_product_type']);
        Route::post('/product-type/update-product-type', [ProductTypeController::class, 'update_product_type']);
        Route::get('/product-type/un-active-product-type', [ProductTypeController::class, 'un_active_product_type']);

        Route::get('/product-type/delete-soft-product-type', [ProductTypeController::class, 'delete_soft_product_type']); // xóa vào thùng rác
        Route::get('/product-type/trash-product-type', [ProductTypeController::class, 'trash_product_type']); //view thùng rác
        Route::post('/product-type/trash-product-type/delete-restore-product-type', [ProductTypeController::class, 'delete_restore_product_type']); // khôi phục và xóa 
        Route::post('/product-type/trash-product-type/load-delete-soft-product-type', [ProductTypeController::class, 'load_delete_soft_product_type']);
        Route::get('/product-type/count-delete', [ProductTypeController::class, 'count_delete']); // khôi phục và xóa 

    });


   

    /* Delivery*/
    
    Route::group(['middleware' => 'admin.manager'], function () {
        Route::group(['prefix' => 'admin/delivery'], function () {
            Route::get('/', [DeliveryController::class, 'show_delivery']);
            Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
            Route::get('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
            Route::get('/loading-feeship', [DeliveryController::class, 'loading_feeship']);
            Route::post('/delete-delivery', [DeliveryController::class, 'delete_delivery']);
            Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);
        });
    
        /* Coupon Product */
        Route::group(['prefix' => 'admin/coupon'], function () {
            Route::get('/', [CouponController::class, 'all_coupon']);
            Route::get('/all-coupon', [CouponController::class, 'all_coupon']); // đưa về view
            Route::get('/add-coupon', [CouponController::class, 'add_coupon']); // thêm danh mục
            Route::get('/load-coupon', [CouponController::class, 'load_coupon']); // load danh mục = ajax
            Route::get('/edit-coupon', [CouponController::class, 'edit_coupon']); // đưa về view chỉnh sửa
            Route::post('/update-coupon', [CouponController::class, 'update_coupon']); // cập nhập danh mục
            Route::post('/save-coupon', [CouponController::class, 'save_coupon']); // lưu khi thêm danh mục
            Route::get('/un-active-coupon', [CouponController::class, 'un_active_coupon']); // vô hiệu hoặc kích hoạt danh mục
            Route::get('/count-delete', [CouponController::class, 'count_delete']); // đếm slider nằm trong thùng rác


            Route::get('/delete-soft-coupon', [CouponController::class, 'delete_soft_coupon']); // xóa vào thùng rác
            Route::get('/trash-coupon', [CouponController::class, 'trash_coupon']); //view thùng rác
            Route::get('/trash-coupon/delete-restore-coupon', [CouponController::class, 'delete_restore_coupon']); // khôi phục và xóa 
            Route::get('/trash-coupon/load-delete-soft-coupon', [CouponController::class, 'load_delete_soft_coupon']);
        });


         /* Flashsale */
        Route::group(['prefix' => 'admin/flashsale'], function () {
            Route::get('/', [FlashsaleController::class, 'all_product_flashsale']);
            Route::get('/add-product-flashsale', [FlashsaleController::class, 'add_product_flashsale']);
            Route::get('load-product-flashsale', [FlashsaleController::class, 'load_product_flashsale']);
            Route::post('/save-product-flashsale', [FlashsaleController::class, 'save_product_flashsale']);
            Route::get('/all-product-flashsale', [FlashsaleController::class, 'all_product_flashsale']);
            Route::get('/edit-product-flashsale', [FlashsaleController::class, 'edit_product_flashsale']);
            Route::post('/update-product-flashsale', [FlashsaleController::class, 'update_product_flashsale']);
            Route::get('/delete-product-flashsale', [FlashsaleController::class, 'delete_product_flashsale']);
            Route::get('/un-active-flashsale', [FlashsaleController::class, 'un_active_flashsale']);
        
        });

       

    });

    Route::group(['prefix' => '/admin/order-manager'], function () {
        Route::get('/', [OrderController::class, 'show_order_manager']);
        
        Route::get('/loading-order-manager', [OrderController::class, 'loading_order_manager']);
        Route::get('/edit-order-status', [OrderController::class, 'edit_order_status']);
        Route::get('/view-order', [OrderController::class, 'view_order']);
        Route::get('/print-order', [OrderController::class, 'print_order']);
        Route::post('/delete-soft-order', [OrderController::class, 'delete_soft_order']);
        Route::get('/trash-order', [OrderController::class, 'show_delete_soft_order']);
        Route::get('/trash-order/loading-delete-order', [OrderController::class, 'loading_delete_order']);
        Route::get('/count-delete-soft', [OrderController::class, 'count_delete_soft']);
        Route::post('/trash-order/restone-or-delete', [OrderController::class, 'restone_or_delete']);
        Route::get('/filer-order', [OrderController::class, 'filer_order']);
        Route::get('/load-count-order', [OrderController::class, 'load_count_order']);
        
        
    });

    Route::group(['prefix' => 'admin/news'], function () {
        Route::get('/', [NewsPageContentController::class, 'show_all_newspaper']);
        Route::get('/all-news', [NewsPageContentController::class, 'show_all_newspaper']);
        Route::get('/add-news', [NewsPageContentController::class, 'show_add_newspaper']);
        Route::post('/save-news', [NewsPageContentController::class, 'save_newspaper']);
        Route::get('/delete-news', [NewsPageContentController::class, 'delete_newspaper']);
        Route::get('/update-news', [NewsPageContentController::class, 'show_update_newspaper']);
        Route::post('/save-update-news', [NewsPageContentController::class, 'update_newspaper']);
        Route::get('/displayView', [NewsPageContentController::class, 'update_display_newspaper']);
        
        

    });
    // Kết thúc middleware auth
});
    Route::get('/newsPageContent', [NewsPageContentController::class, 'index']);

/* Order Manager */


/* Font-End */

/* Đăng Ký - Đăng Nhập - Quên Mật Khẩu ! */
Route::group(['prefix' => '/user'], function () {

    /* Đăng Nhập Tài Khoản Hệ Thống*/
    Route::post('/login-customer', [LoginAndRegister::class, 'login_customer']);
    Route::get('/load-login-customer', [LoginAndRegister::class, 'load_login_customer']);
    
    /* Đăng Nhập Bằng Tài Khoản Google */
    Route::get('/login-google', [LoginAndRegister::class, 'login_google']);
    /* Đăng Ký */
    Route::post('/create-customer', [LoginAndRegister::class, 'create_customer']);
    Route::post('/verification-code-rg', [LoginAndRegister::class, 'verification_code_rg']);
    Route::get('/MailToCustomer', [LoginAndRegister::class, 'MailToCustomer']);
    Route::get('/successful-create-account', [LoginAndRegister::class, 'successful_create_account']);
    /* Quên Mật Khẩu */
    Route::post('/find-account-recovery-pw', [LoginAndRegister::class, 'find_account_recovery_pw']);
    Route::post('/verification-code-rc', [LoginAndRegister::class, 'verification_code_rc']);
    Route::post('/confirm-password', [LoginAndRegister::class, 'confirm_password']);
    /* Đăng Xuất */
    
    
    Route::get('/order', [OrderController::class, 'show_order']);
    Route::get('/order/loading-order', [OrderController::class, 'loading_order']);
    Route::get('/order/submit-order', [OrderController::class, 'submit_order']);
    Route::get('/order/search-order', [OrderController::class, 'search_order']);
    Route::get('/order/check-order', [OrderController::class, 'check_order']);
    Route::get('/order/submit-order-check', [OrderController::class, 'submit_order_check']);
    Route::get('/order/comment-order', [OrderController::class, 'comment_order']);

    
});

/* Trang Chủ */
Route::get('/', [HomeController::class, 'index']);

Route::group(['prefix' => '/trang-chu'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/search-by-voice', [HomeController::class, 'search_by_voice']);
    Route::get('/show-detail-product', [HomeController::class, 'show_detail_product']);
    Route::get('/search-product', [HomeController::class, 'search_product']);
    
});
Route::get('/user/logout', [LoginAndRegister::class, 'logout']);

Route::group(['prefix' => '/cua-hang'], function(){
    Route::get('/', [HomeController::class, 'danh_sach_san_pham']);
    Route::get('/danh-sach-san-pham', [HomeController::class, 'danh_sach_san_pham']);
    Route::get('/load-danh-sach-san-pham', [HomeController::class, 'load_danh_sach_san_pham']);
    Route::get('/search-san-pham', [HomeController::class, 'search_san_pham']);
});


/* Chi Tiết Sản Phẩm */
Route::group(['prefix' => '/san-pham'], function () {
    Route::get('/san-pham-chi-tiet-flash-sale', [ProductController::class, 'san_pham_chi_tiet_flash_sale']);
    Route::get('/san-pham-chi-tiet', [ProductController::class, 'san_pham_chi_tiet']);
    Route::get('/edit-price', [HomeController::class, 'edit_price']);

    Route::middleware('Auth.CheckLogin')->post('/uploadCommentProduct', [CommentProductController::class, 'uploadComment']);
    Route::get('/reloadCommentProduct', [CommentProductController::class, 'reloadComment']);
    Route::get('/reloadTop5CommentProduct', [CommentProductController::class, 'reloadTop5Comment']);
});

Route::get('/bug', [LoginAndRegister::class, 'bug']);
// Route::get('/index', [TestController::class, 'show']);

// Route::get('/bug-1', [TestController::class, 'index']);



Route::group(['prefix' => '/gio-hang'], function () {
    Route::get('/', [CartController::class, 'show_cart']);
    Route::get('/save-cart', [CartController::class, 'save_cart']);

    Route::get('/load-cart', [CartController::class, 'load_cart']);
    Route::get('/load-quantity-cart', [CartController::class, 'load_quantity_cart']);
    Route::get('/load-payment', [CartController::class, 'load_payment']);
    Route::get('/load-coupon', [CartController::class, 'load_coupon']);
    Route::get('/update-size-cart', [CartController::class, 'update_size_cart']);

    // Route::POST('/save-cart', [CartController::class, 'save_cart']);
    Route::get('/delete-cart', [CartController::class, 'delete_cart']);
    Route::POST('/delete-all-cart', [CartController::class, 'delete_all_cart']);
    Route::POST('/update-all-cart', [CartController::class, 'update_all_cart']);
    Route::get('/check-coupon', [CartController::class, 'check_coupon']);
    Route::get('/delete-coupon', [CartController::class, 'delete_coupon']);
    Route::POST('/select-delivery', [CartController::class, 'select_delivery']);
    
    Route::POST('/caculate-fee', [CartController::class, 'caculator_fee']);
    Route::post('/confirm-cart', [CartController::class, 'confirm_cart']);

});


Route::group(['prefix' => '/thanh-toan'], function () {
    Route::get('/', [CheckoutController::class, 'show_payment']);
    
    Route::get('/yeu-cau-dac-biet', [CheckoutController::class, 'check_requirement_special']);
    Route::POST('/yeu-cau-rieng', [CheckoutController::class, 'check_require_private']);
    Route::get('/direct-payment', [CheckOutController::class, 'direct_payment']);
    Route::get('/hoa-don', [CheckOutController::class, 'show_receipt']);
    Route::get('/un-set-order', [CheckOutController::class, 'un_set_order']);
    Route::get('/momo-payment', [CheckOutController::class, 'momo_payment']);
    Route::get('/momo-payment-callback', [CheckOutController::class, 'momo_payment_callback']);
});



// Route::group(['prefix' => '/admin/login-auth'], function () {
//     Route::get('/', [OrderController::class, 'show_order_manager']);
    
//     Route::get('/loading-order-manager', [OrderController::class, 'loading_order_manager']);
//     Route::get('/edit-order-status', [OrderController::class, 'edit_order_status']);
//     Route::get('/view-order', [OrderController::class, 'view_order']);

// });



