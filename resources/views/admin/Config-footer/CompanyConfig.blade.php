@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Footer
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
                    <div class="card-title col-sm-9">Bảng Danh Sách Cấu Hình 
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th> #ID </th>
                            <td>{{ $company_config->company_id }}</td>
                        </tr>
                        <tr>
                            <th>Tên Công Ty/Shop</th>
                            <td contenteditable class="company_edit" data-company_type="1">{{ $company_config->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Tổng Đài Chăm Sóc</th>
                            <td contenteditable class="company_edit" data-company_type="2">{{ $company_config->company_hostline }}</td>
                        </tr>
                        <tr>
                            <th>Email Đơn Vị</th>
                            <td contenteditable class="company_edit" data-company_type="3">{{ $company_config->company_mail }}</td>
                        </tr>
                        <tr>
                            <th>Địa Chỉ</th>
                            <td contenteditable class="company_edit" data-company_type="4">{{ $company_config->company_address }}</td>
                        </tr>
                        <tr>
                            <th>Slogan Công Ty</th>
                            <td contentEditable class="company_edit" data-company_type="5"><div class="company_edit" style="width: 660px;overflow: hidden">{{ $company_config->company_slogan }}</div> </td>
                        </tr>
                        {{-- <tr>
                            <th>Ảnh Đại Diện</th>
                            <td><img style="object-fit: cover" width="40px" height="20px"
                                    src="{{ URL::to('public/fontend/assets/img/product/' . $product->product->product_image) }}"
                                    alt=""></td>
                        </tr> --}}
                        <tr>
                            <th>Copyright</th>
                            <td contentEditable class="company_edit" data-company_type="6"><div class="company_edit" style="width: 660px;overflow: hidden">{{ $company_config->company_copyright }}</div> </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    
    {{-- Toàn Bộ Script Liên Quan Đến Gallery --}}
    <script>
        $(document).ready(function() {
            /* Loading Gallrery On Table */
            // load_gallery_product();


            $('.table-bordered tbody').on('blur', '.company_edit', function(){
                var content_edit = $(this).text();
                var edit_type = $(this).data('company_type');
                // alert(content_edit);
                // var _token = $("input[name='_token']").val();

                $.ajax({
                    url: '{{ url('admin/config-footer/edit-content-footer') }}',
                    method: 'post',
                    data: {
                        // _token: _token,
                        content_edit: content_edit,
                        edit_type:edit_type
                    },
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // $('#loading_gallery_product').html(data);
                        message_toastr("success", "Cập nhập thông tin trang web thành công")
                    },
                    error: function(data) {
                        alert("Fix Bug Huhu :<");
                    },
                });

            })

            
        });
    </script>
@endsection
