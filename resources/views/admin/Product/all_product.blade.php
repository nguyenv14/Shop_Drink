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
            <div class="card-body ">
                <div style="display: flex;justify-content: space-between ">
                    <div class="card-title col-sm-3">Bảng Danh Sách Sản Phẩm</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input id="search" type="text" class="form-control" name="search"
                                placeholder="Tìm Kiếm Sản Phẩm">
                        </div>
                    </div>
                    <div class="col-sm-2">
                       
                        {{-- <div class="btn-group"> --}}
                            <button type="button" width="100px"  class="btn btn-outline-secondary dropdown-toggle"
                                data-bs-toggle="dropdown">Danh Mục</button>
                            <div class="dropdown-menu">
                                <span class="dropdown-item" data-category_id="0">Tất Cả</span>
                                @foreach ($data_category as $category)
                                    <span class="dropdown-item"
                                        data-category_id="{{ $category->category_id }}">{{ $category->category_name }}</span>
                                @endforeach
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <a style="text-decoration: none" href="{{ URL::to('admin/product/trash-product') }}">
                                <button type="button" class="btn btn-outline-secondary">Thùng Rác
                                    {{-- ( {{ $countDelete }} )  --}}
                                    <span class="count-delete" style="color: red"></span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <label for="product_name">Tên Sản Phẩm <i style="font-size: 18px"
                                        class="mdi mdi-sort-alphabetical"></i></label>
                                <input type="checkbox" hidden class="btn-sort" id="product_name" data-type='product'>
                            </th>
                            <th>
                                <label for="product_category"> Danh Mục <i style="font-size: 18px"
                                        class="mdi mdi-sort-alphabetical"></i></label>
                                <input type="checkbox" hidden class="btn-sort" id="product_category" data-type='category'>
                            </th>
                            {{-- <th>
                                <label for="product_quantity">Lượng Bán<i style="font-size: 18px" class="mdi mdi-sort-numeric"></i></label>
                                <input type="checkbox" hidden class="btn-sort" id="product_quantity" data-type='quantity'>
                            </th> --}}
                            <th>
                                <label for="product_price">Giá<i style="font-size: 18px"
                                        class="mdi mdi-sort-numeric"></i></label>
                                <input type="checkbox" hidden class="btn-sort" id="product_price" data-type='price'>
                            </th>

                            <th>Ảnh Đại Diện</th>
                            <th>Hiển Thị</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="loading-table-product">

                    </tbody>
                </table>

            </div>
        </div>
    </div>



    {!! $all_product->links('admin.ComponentPages.pagination') !!}


    {{-- Phân Trang Bằng Ajax --}}
    
    <script>
        var notePage = 1;
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            // alert(notePage)
            getPosts(page);
        });

        function getPosts(page) {
            $.ajax({
                url: '{{ url('admin/product/load-product?page=') }}' + page,
                method: 'get',
                data: {

                },
                success: function(data) {
                    $('#loading-table-product').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        getPosts(notePage);

        count_Delete();

      

        function count_Delete() {
            $.ajax({
                url: '{{ url('/admin/product/count-delete') }}',
                method: 'GET',
                data: {

                },
                success: function(data) {
                    // alert(data);
                    $('.count-delete').html(data);
                },
                error: function(data) {
                    alert("Fix Bug count delete :<");
                },
            });
        }




        $('tbody').on('click', '.mdi-delete', function() {
            var product_id = $(this).data('product_id');
            var _token = $('meta[name="csrf-token"]').attr('content');
            // alert(product_id);
            $.ajax({
                url: '{{ url('/admin/product/delete-soft-product') }}',
                method: 'POST',
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    message_toastr("success", "Sản phẩm đã vào thùng rác");
                    // alert(notePage);
                    getPosts(notePage);
                    count_Delete();
                },
                error: function() {
                    alert("Bug Huhu delete :<<");
                }
            })
        })

        $('tbody').on('click', '.btn-un-active', function() {
            var product_id = $(this).data('product_id');
            var status = $(this).data('status');
            $.ajax({
                url: '{{ url('admin/product/un-active-product') }}',
                method: 'get',
                data: {
                    product_id: product_id,
                    status: status,
                },
                success: function(data) {
                    // $('tbody').html(data);
                    // alert(notePage);
                    getPosts(notePage);

                    if (status == 0)
                        message_toastr('success', 'Sản phẩm đã bị vô hiệu hóa');
                    else
                        message_toastr('success', 'Sản phẩm đã được kích hoạt');

                },
                error: function(data) {
                    alert("Fix Bug un-active Huhu :<");
                },
            })
        })
    </script>
    <script>
        $('#search').keyup(function() {
            var key_sreach = $(this).val();
            $.ajax({
                url: '{{ url('/admin/product/all-product-sreach') }}',
                method: 'GET',
                data: {
                    key_sreach: key_sreach,
                },
                success: function(data) {
                    $('#loading-table-product').html(data);
                },
                error: function() {
                    alert("Bug Huhu search :<<");
                }
            })
        });
    </script>
    <script>
        $('.dropdown-item').click(function() {
            var category_id = $(this).data('category_id');
            // alert(category_id);
            $.ajax({
                url: '{{ url('/admin/product/sort-product-by-category') }}',
                method: 'GET',
                data: {
                    category_id: category_id,
                },
                success: function(data) {
                    $('#loading-table-product').html(data);
                },
                error: function() {
                    alert("Bug Huhu dropdown :<<");
                }
            })
        });
    </script>
    <script>
        $('.btn-sort').click(function() {
            // var status = $(this).data('name_check');
            var check = $(this).prop("checked");
            var type = $(this).data('type');
            // alert(status + " " + id_checked + " " + type)
            $.ajax({
                url: '{{ url('/admin/product/sort-all') }}',
                method: 'GET',
                data: {
                    check: check,
                    type: type
                },
                success: function(data) {
                    $('#loading-table-product').html(data);
                },
                error: function() {
                    // alert("Bug Huhu :<<");
                }
            })
        })
    </script>
@endsection
