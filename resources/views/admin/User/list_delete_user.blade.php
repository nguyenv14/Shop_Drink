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
                    <div class="card-title col-sm-4">Thùng Rác Admin</div>
                    {{-- <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                           
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <a style="text-decoration: none" href="{{ URL::to('admin/auth/trash-admin') }}">
                                <button type="button" class="btn btn-outline-secondary">Thùng Rác
                                    <span class="count-delete" style="color: red;font-weight: 700"></span>
                                </button>
                            </a>
                        </div>
                    </div> --}}
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> Tên Người Dùng </th>
                            <th> Số Điện Thoại </th>
                            <th> Email </th>
                            <th> Quyền Hạn </th>
                            {{-- <th> Quản Lý </th> --}}
                            {{-- <th> Nhân Viên </th> --}}
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

    <div class="modal fade" id="restore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn Khôi phục người quản trị này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-success btn_deleted" data-dismiss="modal">Khôi Phục</button>
                </div>
            </div>
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
                    Bạn có chắc chắn muốn xóa người quản trị này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-danger btn_deleted" data-dismiss="modal">Xóa</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        load_delete_all_admin();
        function load_delete_all_admin(){
            $.ajax({
                url: '{{ url('admin/auth/trash-admin/loading-delete-admin') }}',
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
    </script>


    <script>
        // $(document).on( 'click', '.form-check-input', function() {
        //     var admin_id = $(this).data('admin_id');
        //     var index_roles = $('input[type="radio"][name="roles' + admin_id + '"]:checked').val();
        //     var _token = $('meta[name="csrf-token"]').attr('content');
        //     $.ajax({
        //         url: '{{ url('admin/auth/assign-roles') }}',
        //         method: 'POST',
        //         data: {

        //             admin_id: admin_id,
        //             index_roles: index_roles,
        //             _token: _token,

        //         },
        //         success: function(data) {
        //             load_all_admin();
        //             if (data == "admin") {
        //                 message_toastr("success", "Cấp Quyền Quản Trị Thành Công!", "Thông báo");
        //             } else if (data == "manager") {
        //                 message_toastr("success", "Cấp Quyền Quản Lý Thành Công!", "Thông báo");
        //             } else if (data == "employee") {
        //                 message_toastr("success", "Cấp Quyền Nhân Viên Thành Công!", "Thông báo");
        //             } else if (data = "error_permit") {
        //                 message_toastr("warning",
        //                     "Quản Trị Viên Không Thể Tự Cấp Lại Quyền Cho Chính Mình!",
        //                     "Oh Noooooo!");
        //             }
        //         },
        //         error: function() {
        //             alert("Bug Huhu :<<");
        //         }
        //     })

        // });

        $(document).on( 'click', '.btn-admin-roles', function(){
            var admin_id = $(this).data('admin_id');
            var status = $(this).data('status');
            var _token = $('meta[name="csrf-token"]').attr('content');
            $('.btn_deleted').click(function(){
                // alert(admin_id + " " + status);
                $.ajax({
                    url: '{{ url('admin/auth/trash-admin/restore-delete-admin') }}',
                    method: 'get',
                    data: {
                        admin_id: admin_id,
                        status:status,
                        _token: _token,
                    },
                    success: function(data) {
                        load_delete_all_admin();
                       if(status == 1){
                        message_toastr("success",
                                "Nhân viên đã được khôi phục quyền của mình!");
                        }else{
                            message_toastr("success", "Đã Xóa Nhân Viên Vĩnh Viễn!");
                        }
                    },
                    error: function() {
                        alert("Bug Huhu :<<");
                    }
                })
            })

        });
    </script>
@endsection
