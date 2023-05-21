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
                    <div class="card-title col-sm-9">Bảng Danh Sách Đơn Hàng</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="searchbyname" placeholder="Tìm Mã Đơn Hàng">
                        </div>

                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID Đơn Hàng </th>
                            <th>Trạng Thái</th>
                            {{-- <th>Thanh Toán</th> --}}
                            {{-- <th>Trạng Thanh Toán</th> --}}
                            <th>Ngày Xóa Đơn</th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody id="loading-order-manager">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="restone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn muốn khôi phục đơn hàng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-success btn_deleted" data-dismiss="modal">Có</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa đơn hàng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-danger btn_deleted" data-dismiss="modal">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        load_delete_order_list();




        //     $(document).on('click', '.btn-order-status', function() {
        //         var order_code = $(this).data('order_code');
        //         var order_status =   $(this).data('order_status');
        //         var _token = $('meta[name="csrf-token"]').attr('content');

        //         $.ajax({
        //             url: '{{ url('admin/order/order-status') }}',
        //             method: 'POST',
        //             data: {
        //                 _token: _token,
        //                 order_code: order_code,
        //                 order_status: order_status,
        //             },
        //             success: function(data) {
        //                 loading_order_manager();
        //               if(data == "refuse"){
        //                 message_toastr("success", "Đơn Hàng Đã Bị Từ Chối !");
        //               } else if(data == "browser"){
        //                 message_toastr("success", "Đơn Hàng Đã Được Duyệt !");
        //               } else if(data == "success"){
        //                 message_toastr("success", "Đơn Hàng Đã Giao Thành Công !");
        //               } else if(data == "return"){
        //                 message_toastr("success", "Đơn Hàng Đã Bị Bom Huhu :< Icon Mếu");
        //               }
        //             },
        //             error: function(data) {
        //                 alert("Nhân Ơi Fix Bug Huhu :<");
        //             },
        //         });

        //     });




        function load_delete_order_list() {
            $.ajax({
                url: '{{ url('/admin/order-manager/trash-order/loading-delete-order') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('#loading-order-manager').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }


        
        $(document).on('click', '.btn-order-status', function() {
            var order_id = $(this).data('order_id');
            var order_status = $(this).data('order_status');
            $('.btn_deleted').click(function(){
                // alert(order_id);
                // alert('click');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('/admin/order-manager/trash-order/restone-or-delete') }}',
                    method: 'post',
                    data: {
                        order_id: order_id,
                        order_status:order_status
                    },
                    success: function(data) {
                        // $('#loading-order-manager').html(data);
                        load_delete_order_list();
                        if(order_status == 1){
                            message_toastr('success', 'Khôi phục đơn hàng thành công!!');
                        }else{
                            message_toastr('success', 'Đơn hàng đã bị xóa vĩnh viễn');
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
            })
        })
    </script>
@endsection
