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
                    <div class="card-title col-sm-4">Bảng Danh Sách Đơn Hàng</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                           <select name="" id="filter" class="btn btn-outline-secondary">
                                <option class="btn btn-outline-secondary" value="">Bộ lọc</option>
                                <option class="btn btn-outline-secondary" value="1">Đã Duyệt</option>
                                <option class="btn btn-outline-secondary"  value="0">Chờ Duyệt</option>
                                <option class="btn btn-outline-secondary" value="-1">Đã Từ Chối</option>
                                <option class="btn btn-outline-secondary" value="2">Hoàn Thành</option>
                                <option class="btn btn-outline-secondary" value="3">Hoàn Trả</option>
                           </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" class="form-control" name="searchbyname" placeholder="Tìm Mã Đơn Hàng">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <a style="text-decoration: none" href="{{ URL::to('admin/order-manager/trash-order') }}">
                                <button type="button" class="btn btn-outline-secondary">Thùng Rác
                                    {{-- ( {{ $countDelete }} )  --}}
                                    <span class="count-delete" style="color: red;font-weight: 700"></span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID Đơn Hàng </th>
                            <th>Trạng Thái</th>
                            <th>Thanh Toán</th>
                            <th>Trạng Thanh Toán</th>
                            <th>Ngày Tạo Đơn</th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody id="loading-order-manager">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        load_order_list();
        load_count_delete()


        function load_order_list() {
            $.ajax({
                url: '{{ url('/admin/order-manager/loading-order-manager') }}',
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

        function load_count_delete(){
            $.ajax({
                url: '{{ url('/admin/order-manager/count-delete-soft') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('.count-delete').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }


        $(document).on('click', '.btn-order-status', function() {
            var order_code = $(this).data('order_code');
            var order_status = $(this).data('order_status');
            // alert(order_code + " " + order_status);
            $.ajax({
                url: '{{ url('/admin/order-manager/edit-order-status') }}',
                method: 'get',
                data: {
                    order_code: order_code,
                    order_status: order_status,
                },
                success: function(data) {
                    // $('#loading-order-manager').html(data);
                    load_order_list();
                    if (data == "refuse") {
                        message_toastr("success", "Đơn Hàng Đã Bị Từ Chối !");
                    } else if (data == "browser") {
                        message_toastr("success", "Đơn Hàng Đã Được Duyệt !");
                    } else if (data == "success") {
                        message_toastr("success", "Đơn Hàng Đã Giao Thành Công !");
                    } else if (data == "return") {
                        message_toastr("success", "Đơn Hàng Đã Bị Bom Huhu :< Icon Mếu");
                    }

                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        })

        $(document).on('click', '.btn-delete-order', function() {
            var order_id = $(this).data('order_id');
            
            $('.btn_deleted').click(function(){
                // alert(order_id);
                // alert('click');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('/admin/order-manager/delete-soft-order') }}',
                    method: 'post',
                    data: {
                        order_id: order_id,
                    },
                    success: function(data) {
                        // $('#loading-order-manager').html(data);
                        load_order_list();
                        load_count_delete();
                        message_toastr('success', 'Xóa đơn hàng thành công!!')
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
            })
        })

        $('#filter').change(function(){
            var value = $(this).val();
            $.ajax({
                    url: '{{ url('/admin/order-manager/filer-order') }}',
                    method: 'get',
                    data: {
                        value: value,
                    },
                    success: function(data) {
                        $('#loading-order-manager').html(data);
                        // load_order_list();
                        // load_count_delete();
                        // message_toastr('success', 'Xóa đơn hàng thành công!!')

                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
        })
    </script>
@endsection
