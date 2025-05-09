@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Sản Phẩm
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
                    <div class="card-title col-sm-9">Bảng Danh Sách Chi Tiết Sản Phẩm {{ $product->product_name }}
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th> #ID </th>
                            <td>{{ $product->product_id }}</td>
                        </tr>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <td>{{ $product->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>{{ $product->category->category_name }}</td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td>{{ number_format($product->product_price, 0, ',', '.') }}đ</td>
                        </tr>
                        <tr>
                            <th>Ảnh Đại Diện</th>
                            <td><img style="object-fit: cover" width="40px" height="20px"
                                    src="{{ URL::to('public/fontend/assets/img/product/' . $product->product_image) }}"
                                    alt=""></td>
                        </tr>
                        <tr>
                            <th>Giảm giá</th>
                            @if ($product->flashsale_status == 1)
                            <td> Có </td>
                            @else
                            <td> Không </td>
                            @endif
                        </tr>
                        <tr>
                            <th>Nội Dung</th>
                            
                            <td><div class="" style="width: 660px;overflow: hidden; text-overflow: ellipsis">{{ $product->product_desc }}</div></td>
                        </tr>
                        <tr>
                            <th>Trạng Thái</th>
                            @if ($product->product_status == 1)
                            <td>Hiển thị</td>
                            @else
                            <td>Ẩn</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Ngày Thêm Vào</th>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Cập Nhật Lần Cuối</th>
                            <td>{{ $product->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div  class="card-title col-sm-9">Thư Viện Ảnh Của Sản Phẩm "{{ $product->product_name }}"
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>
                <form action="{{ URL::to('/admin/product/insert-gallery?product_id='. $product->product_id) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Thêm Ảnh Vào Thư Viện Ảnh</label>
                        <input class="form-control" type="file" name="file[]" id="formFile" accept="image/*" multiple>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <table style="margin-top:20px " class="table table-bordered tab-gallery">
                    <form>
                        <input type="hidden" value="{{ $product->product_id }}" id="pro_id" name="pro_id">
                        @csrf
                        <thead>
                            <tr>
                                <th> #STT </th>
                                <th>Tên Ảnh</th>
                                <th>Hình Ảnh</th>
                                <th>Nội Dung Ảnh</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="loading_gallery_product"> 

                        </tbody>
                    </form>
                </table>

            </div>
        </div>
    </div>
    {{-- Toàn Bộ Script Liên Quan Đến Gallery --}}
    <script>
        //     /* Loading Gallrery On Table */
            load_gallery_product();

            function load_gallery_product() {
                var product_id = $("input[name='pro_id']").val();
                $.ajax({
                    url: '{{ url('admin/product/loading-gallery') }}',
                    method: 'get',
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        $('#loading_gallery_product').html(data);
                    },
                    error: function(data) {
                        alert("Load gallery Fix Bug Huhu :<");
                    },
                });

            }

        //     /* Cập Nhật Nội Dung Ảnh Gallery */
            $('.tab-gallery #loading_gallery_product').on('blur', '.edit-content', function() {
                var gallery_id = $(this).data('gallery_id');
                var _token = $("input[name='_token']").val();
                var gallery_content = $(this).text();
                var type = $(this).data('type');
                $.ajax({
                    url: '{{ url('admin/product/update-content-gallery') }}',
                    method: 'post',
                    data: {
                        _token: _token,
                        gallery_id: gallery_id,
                        gallery_content: gallery_content,
                        type: type
                    },
                    success: function(data) {
                        message_toastr("success", type + " Đã Được Cập Nhật !");
                        load_gallery_product();
                    },
                    error: function(data) {
                        alert("Nhân Ơi Fix Bug Huhu :<");
                    },
                });
            });


        //     /* Xóa Gallery */
            $('.tab-gallery #loading_gallery_product').on('click', '.delete_gallery_product', function() {
                var gallery_id = $(this).data('gallery_id');
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '{{ url('admin/product/delete-gallery') }}',
                    method: 'post',
                    data: {
                        _token: _token,
                        gallery_id: gallery_id,
                    },
                    success: function(data) {
                        message_toastr("success", "Ảnh Đã Được Xóa Khỏi Sản Phẩm!");
                        load_gallery_product();
                    },
                    error: function(data) {
                        alert("Nhân Ơi Fix Bug Huhu :<");
                    },
                });

            });
        $(document).ready(function() {

            $('.tab-gallery #loading_gallery_product').on('change', '.up_load_file', function(e) {
                var gallery_id = $(this).data('gallery_id');
                //var image = document.getElementById('up_load_file'+gallery_id).files[0];
                //var formdata = new FormData();
                var formData = new FormData();
                var file = event.target.files[0];
              //  form_data.append("file",document.getElementById('up_load_file'+gallery_id).files[0]);
                formData.append('file', file);
                formData.append('gallery_id', gallery_id);  

                $.ajax({
                    url: '{{ url('admin/product/update-image-gallery') }}',
                    method: 'post',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType:false,
                    processData:false,
                    success: function(data) {
                        message_toastr("success", "Cập Nhật Ảnh Thành Công !");
                        load_gallery_product();
                    },
                    error: function(data) {
                    alert("Nhân Ơi Fix Bug Huhu :<");
                    console.log(file);
                    },
                });
            });
})

    </script>
@endsection
