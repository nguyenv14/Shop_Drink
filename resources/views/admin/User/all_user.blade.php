@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Quản Lý Admin
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="mdi mdi-timetable"></i>
                    <span><?php
                    $today = date('d/m/Y');
                    echo $today;
                    ?></span>
                </li>
            </ul>
        </nav>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-4">Bảng Danh Sách Admin</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search_user" placeholder="Tìm kiếm">
                           
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            {{-- <a style="text-decoration: none" href="{{ URL::to('admin/auth/trash-admin') }}">
                                <button type="button" class="btn btn-outline-secondary">Thùng Rác
                                    ( {{ $countDelete }} ) 
                                    <span class="count-delete" style="color: red;font-weight: 700"></span>
                                </button>
                            </a> --}}
                        </div>
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> Tên Người Dùng </th>
                            <th> Số Điện Thoại </th>
                            <th> Email </th>
                            <th>Đơn hàng</th>
                            <th>Đơn Từ Chối</th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        {{-- @foreach ($admins as $key => $admin)
                            <tr>
                                <td>{{ $admin->admin_name }}</td>
                                <td>{{ $admin->admin_phone }}</td>
                                <td>{{ $admin->admin_email }}</td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="roles{{ $admin->admin_id }}"
                                                {{ $admin->hasRoles('admin') ? 'checked' : '' }} value="1"
                                                data-admin_id="{{ $admin->admin_id }}">
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="roles{{ $admin->admin_id }}"
                                                {{ $admin->hasRoles('manager') ? 'checked' : '' }} value="2"
                                                data-admin_id="{{ $admin->admin_id }}">
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input"
                                                name="roles{{ $admin->admin_id }}"
                                                {{ $admin->hasRoles('employee') ? 'checked' : '' }} value="3"
                                                data-admin_id="{{ $admin->admin_id }}">
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <div style="margin-top: 10px">
                                        <button type="button" class="btn-sm btn-gradient-dark btn-rounded btn-fw btn-delete-admin-roles" data-admin_id="{{ $admin->admin_id }}">Xóa Quản Trị 
                                        </button>
                                    </div>
                                    <div style="margin-top: 10px">
                                        <a href="{{ url('admin/auth/impersonate?admin_id=' . $admin->admin_id) }}"><button
                                                type="button" class="btn-sm btn-gradient-info btn-rounded btn-fw">Chuyển
                                                Quyền</button>
                                        </a>
                                    </div>

                                    <div style="margin-top: 10px">
                                        <a href="{{ url('admin/auth/edit-admin?admin_id=' . $admin->admin_id) }}"><button
                                                type="button" class="btn-sm btn-gradient-danger btn-dangee btn-fw">Chỉnh sửa</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider --}}
    {{-- <nav aria-label="Page navigation example">
        {!! $admins->links() !!}
    </nav> --}}

    <div class="modal fade" id="unactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn ngưng hoạt động của khách hàng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-danger btn_deleted" data-dismiss="modal">Chấp nhận</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn khách hàng này hoạt động lại?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-success btn_deleted" data-dismiss="modal">Chấp nhận</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        load_all_user();
        count_delete();
        function load_all_user(){
            $.ajax({
                url: '{{ url('admin/user/loading-user') }}',
                method: 'get',
                data: {
                },
                success: function(data) {
                    $('#tbody').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        // function count_delete(){
        //     $.ajax({
        //         url: '{{ url('admin/auth/count-delete') }}',
        //         method: 'get',
        //         data: {
        //         },
        //         success: function(data) {
        //             $('.count-delete').html(data);
        //         },
        //         error: function() {
        //             alert("Bug Huhu :<<");
        //         }
        //     })
        // }
    </script>


    <script>
            $('#search_user').keyup(function(){
                var text = $(this).val();
                $.ajax({
                url: '{{ url('admin/user/search-user') }}',
                method: 'get',
                data: {
                    text: text,
                },
                success: function(data) {
                    $('#tbody').html(data);
                    // count_delete();
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
            })

            var customer_id = 0;
            var status = 0;
        $(document).on( 'click', '.btn_report', function(){
            customer_id = $(this).data('customer_id');
            status = $(this).data('status');
            // var _token = $('meta[name="csrf-token"]').attr('content');
            // alert(customer_id + " " + status);
        });
        $('.btn_deleted').click(function(){
            $.ajax({
                url: '{{ url('admin/user/active-unactive-user') }}',
                method: 'get',
                data: {
                    customer_id: customer_id,
                    status: status,
                },
                success: function(data) {
                   if(status == "1"){
                    message_toastr("success",
                            "Đã kích hoạt tài khoản thành công!");
                    }else{
                        message_toastr("success", "Đã vô hiệu hóa tài khoản thành công!");
                    }
                    load_all_user();
                    // count_delete();
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        })
    </script>
@endsection
