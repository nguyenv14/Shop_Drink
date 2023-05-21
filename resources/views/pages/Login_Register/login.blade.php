
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
<form id="login" class="fromlogin" method="post" action="{{ url('/user/login-customer') }}">
{{ csrf_field() }}
{{-- <div for="input-fromlogin" class="fromlogin-close">
    <span> <i  class="close-box fa-solid fa-xmark"></i></span>
</div> --}}
@foreach ($errors->all() as $error)
                                <script>
                                        message_toastr("warning", '{{ $error }}', "Cảnh Báo !");
                                </script>
@endforeach
<div class="fromlogin-box">
    <div class="fromlogin-title">
        <label for=""><span>Đăng nhập</span></label>
    </div>

   <a href="{{ URL::to('/user/login-facebook') }}">
    <div class="fromlogin-item">
        <div class="fromlogin-item-logo">
            <!-- <i class="fa-brands fa-facebook"></i> -->
            <img width="30px" height="30px" style="object-fit: cover;margin-left: -4px;"
                src="{{ asset('public/fontend/assets/img/icon/fb-login-icon.png') }}"
                alt="">
        </div>
        <div class="fromlogin-item-text">
            <span style="margin-left: -3px;">Đăng nhập bằng facebook</span>
        </div>
    </div>
   </a>

   <a href="{{ URL::to('/user/login-google') }}">
    <div class="fromlogin-item">
        <div class="fromlogin-item-logo">
            <!-- <i class="fa-brands fa-google"></i> -->
            <img width="24px" height="24px" style="object-fit: cover;"
                src="{{ asset('public/fontend/assets/img/icon/gg-login-icon.png') }}"
                alt="">
        </div>
        <div class="fromlogin-item-text">
            <span>Đăng nhập bằng Google</span>
        </div>
    </div>
   </a>

    <div style="margin-top:16px" class="fromlogin-item-input-box">
        <input id="email" class="fromlogin-item-input mb-3" type="text" name="customer_name" required>
        <label class="fromlogin-item-lable" for="">Tài khoản Hoặc Email</label>
        <span class="form-message mb-2"></span>
    </div>
    <div style="margin-top: 30px;" class="fromlogin-item-input-box">
        <input id="password" class="fromlogin-item-input mb-3" type="password" name="customer_password"
            required>
        <label class="fromlogin-item-lable" for="">Mật khẩu</label>
        <span class="form-message mb-2"></span>
    </div>
    
    <div style="margin-top: 30px" class="g-recaptcha"
        data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
    <br />
    @if ($errors->has('g-recaptcha-response'))
        <span class="invalid-feedback" style="display:block">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
        <script>
              message_toastr("warning", "Bạn Chưa Vượt Mã Xác Minh Google !");
        </script>
    @endif

    <input type="submit" class="fromlogin-btn" value="Đăng nhập" id="btn-login-submit">
    <div style="cursor: pointer" id="recoverypassaccount" class="fromlogin-restore">
        <span>Khôi phục mật khẩu</span>
    </div>
    <div class="fromlogin-end">
        <span>Chưa có tài khoản?</span>
        <span id="registeraccount" style="cursor: pointer;color: #00b6f3;">Đăng ký tài khoản</span>
    </div>
</div>
</form>

