@extends('pages.page_layout')
@section('web_content')


<link rel="stylesheet" href="{{ asset('public/fontend/assets/css/myorder.css') }}">

<div class="container history-order" style="margin-top: 300px">
    <div class="row">
        <div class="col-md-8">
            <h2>Đơn Hàng Của {{ $customer->customer_name }}</h2>
            <input type="text" id="customer_id" value="{{ $customer->customer_id }}" hidden>
        </div>
        <div class="col-md-4">
            <input type="text" style="height: 30px; outline: none" id="code">
            <button class="btn btn-danger btn_search_order_code">Tìm kiếm</button>
        </div>
    </div>
    <hr width="100%">

    <div class="order_content">

    <div class="container order_box mt-3">
        <h4>Mã Đơn: TGD2234</h4>
        <hr width="100%">
        <div class="row mt-2 mb-2">
            <div class="col-md-4 product_item">
                <img width="100px" style="object-fit: cover;border-radius: 10px; margin-right: 20px;" src="https://product.hstatic.net/1000075078/product/bg-cloudfee-roasted-almond_ac9a236a27274a568ac6c8630047859f_large.jpg" alt="">
                <div class="ms-4 mt-2">
                    <span style="font-weight: 500;">Cà phê Sữa Đá say nguyen </span> <br>
                    Số lượng: 1 <br>
                    Giá: 49.000đ
                </div>
                
            </div>
            <div class="col-md-4 product_item">
                <img width="100px" style="object-fit: cover;border-radius: 10px;" src="https://product.hstatic.net/1000075078/product/bg-cloudfee-roasted-almond_ac9a236a27274a568ac6c8630047859f_large.jpg" alt="">
                <div class="ms-5 mt-2">
                    <span style="font-weight: 500;">Cà phê Sữa Đá say nguyen </span> <br>
                    Số lượng: 1 <br>
                    Giá: 49.000đ
                </div>
            </div>
            <div class="col-md-4 product_item">
                <img width="100px" style="object-fit: cover;border-radius: 10px;" src="https://product.hstatic.net/1000075078/product/bg-cloudfee-roasted-almond_ac9a236a27274a568ac6c8630047859f_large.jpg" alt="">
                <div class="ms-5 mt-2">
                    Cà phê sữa đá <br>
                    Số lượng: 1 <br>
                    Giá: 49.000đ
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7 shopper_detail mt-4">
                <h5>Người Đặt: Vĩnh Nguyên</h5>
                <h5>SĐT: 083951415</h5>
                <h5>Địa Chỉ: 131, Trần Dư, Phường An Xuân, Thành Phố Tam Kỳ, Tỉnh Quảnh Nam</h5>
            </div>
            <div class="col-md-5">
                <table class="m-3" style="width: 90%;">
                    <tr style="border-bottom: 1px solid #0c0c0c;">
                        <th>Phí Ship</th>
                        <th style="text-align: right;">12.000đ</th>
                    </tr>
                    
                    <tr style="border-bottom: 1px solid #0c0c0c;">
                        <th>Mã Giảm Giá</th>
                        <th style="text-align: right;">Không có</th>
                    </tr>
                    <tr style="border-bottom: 1px solid #0c0c0c;">
                        <th>Tổng tiền</th>
                        <th style="color: red;text-align: right;">100.000đ</th>
                    </tr>
                    <tr>
                        <th>Tình Trạng</th>
                        <th style="text-align: right;color: red;">Đang Duyệt</th>
                    </tr>
                </table>

                <div class="row ms-3 me-3 mt-3">
                    <button class="btn-primary btn-danger btn_cancel_order">Hủy Đơn Hàng</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="mt-5">
    {!! $orders->links('admin.ComponentPages.pagination') !!}
   </div>
    

</div>

<div class="modal fade" id="deleted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn hủy đơn hàng này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-danger btn_deleted" data-dismiss="modal">Có</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn đã xác nhận nhận được đơn hàng này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-success btn_deleted" data-dismiss="modal">Xác nhận</button>
            </div>
        </div>
    </div>
</div>


{{-- modal đánh giá --}}
<div class="modal fade" id="danhgia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header colored">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Tiêu đề</label>
              <input type="text" class="form-control title_cm" id="recipient-name" placeholder="Nhập tiêu đề">
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Nội dung</label>
              <textarea class="form-control content_cm content_cm" id="message-text" placeholder="Nhập nội dung"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn_cancel" data-dismiss="modal">Thoát</button>
          <button type="button" class="btn btn-primary btn_submit_cm" data-dismiss="">Gửi <i class="fa-solid fa-paper-plane"></i></button>
        </div>
      </div>
    </div>
  </div>
   

    

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

var notePage = 1;
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            // alert(notePage)
            load_order_user(page);
        });

        function load_order_user(page) {
            var customer_id = $('#customer_id').val();
            $.ajax({
                url: '{{ url('user/order/loading-order?page=') }}' + page,
                method: 'get',
                data: {
                    customer_id : customer_id
                },
                success: function(data) {
                    $('.order_content').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        load_order_user(notePage);
    // load_order_user();
    // function load_order_user(){
    //     var customer_id = $('#customer_id').val();
    //     // alert(customer_id); 
    //     $.ajax({
    //             url: '{{ url('user/order/loading-order') }}',
    //             method: 'get',
    //             data: {
    //                 customer_id : customer_id
    //             },
    //             success: function(data) {
    //                 $('.order_content').html(data);
    //             },
    //             error: function() {
    //                 alert("Bug Huhu :<<");
    //             }
    //         })
    // }

    //Button nhận hoặc trả đơn hàng
    $(document).on('click', '.btn_cancel_order', function(){
        var order_id = $(this).data('order_id');
        var order_status = $(this).data('order_status');
        // alert(order_id+order_status);
        $('.btn_deleted').click(function(){
            $.ajax({
                    url: '{{ url('user/order/submit-order') }}',
                    method: 'get',
                    data: {
                        order_id : order_id,
                        order_status : order_status,
                    },
                    success: function(data) {
                        load_order_user(notePage);
                        if(order_status == 'nhận'){
                            message_toastr('success', "Cảm ơn Bạn Đã Mua Hàng Của BonoDrinks, Mãii Yeeuuu <3");
                        }else{
                            message_toastr('success', "Đã Hủy Đơn Hàng Thành Công!!!");
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
        })
    })

    $('.btn_search_order_code').click(function(){
        var code = $('#code').val();
        var customer_id = $('#customer_id').val();
        // alert(code);
        $.ajax({
                url: '{{ url('user/order/search-order') }}',
                method: 'get',
                data: {
                    order_code : code,
                    customer_id : customer_id,
                },
                success: function(data) {
                        // load_order_user(notePage);
                    if(data == 'fail'){
                        message_toastr('error', "Mã Đơn Hàng Không Hợp Lệ");
                    }else{ 
                            $('.order_content').html(data);
                            message_toastr('success', "Đã Tìm Thấy Đơn Hàng " + $code + " !!!");
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
    })
</script>

<script>
    var order_code = '';
    $('.order_content').on('click', '.btn_cm', function(){
        order_code = $(this).data('order_code');
        // alert(order_code);
        $('.btn_submit_cm').attr('data-dismiss', '');
    })

    $('.btn_submit_cm').click(function(){
            var title_cm = $('.title_cm').val();
            var content_cm = $('.content_cm').val();
            // alert(title_cm + content_cm + " " + order_code);
            if(title_cm == '' || content_cm == ''){
                message_toastr('warning', 'Vui lòng nhập đầy đủ trường để thực hiện thao tác!');
            }else{
                $('.btn_submit_cm').attr('data-dismiss', 'modal');
                $.ajax({
                    url: '{{ url('user/order/comment-order') }}',
                    method: 'get',
                    data: {
                        order_code : order_code,
                        title_cm : title_cm,
                        content_cm : content_cm
                    },
                    success: function(data) {
                        if(data == 'success'){
                            message_toastr('success', 'Đã đăng đánh giá thành công!!!');
                            $('.title_cm').val('');
                            $('.content_cm').val('');
                        }else{
                            message_toastr('error', 'Đã xuất hiện một số lỗi khi thực hiện thao tác');
                        }
                        // load_order_user(notePage);
                    },
                        error: function() {
                            alert("Bug Huhu :<<");
                        }
                })
            }
            // alert(title_cm + " " + content_cm);
        })

    $('.btn_cancel').click(function(){
        $('.title_cm').val('');
        $('.content_cm').val('');
    })
</script>
@endsection
