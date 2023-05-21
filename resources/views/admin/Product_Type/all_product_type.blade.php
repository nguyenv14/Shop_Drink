@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Quản Lý Loại Sản phẩm
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
                    <div class="card-title col-sm-5">Bảng Danh Sách Loại Sản Phẩm

                        
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-outline-success btn-fw"><a
                                href="{{ url('admin/product/product-type/trash-product-type') }}"
                                style="text-decoration: none;color: black"><i class="mdi mdi-delete-sweep"></i> Thùng rác <span class="count-delete"
                                    style="color: red"></span></a></button>
                    </div>
                    {{-- <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-gradient-primary me-2">Tìm kiếm</button>
                            </span>
                        </div>
                    </div> --}}
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th> Tên Loại Sản Phẩm </th>
                            <th> Giá </th>
                            {{-- <th> Từ Khóa (SEO) </th> --}}
                            <th> Hiễn Thị </th>
                            <th> Ngày Thêm </th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider --}}
    {{-- <nav aria-label="Page navigation example">
        {!! $all_product_type->links() !!}
    </nav> --}}

    

    <script>
        // $.get('http://localhost/DoAnCNWeb/api/admin/product_type/all-product_type',function(res){
        //     //console.log(res);
        //     if(res.status_code == 200){ /* Kiểm Tra */
        //         let all_product_type = res.data;
        //         //console.log(all_product_type);
        //         // all_product_type.forEach(function(item){
        //         //     console.log(item);
        //         // })
        //     }
        // });

        load_product_type();
        // count_Delete()
        
        // count_Delete();
        setInterval( count_Delete, 500);

        function load_product_type() {
            $.ajax({
                url: '{{ url('admin/product/product-type/load-product-type') }}',
                method: 'get',
                data: {},
                success: function(data) {
                    $('tbody').html(data);
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        }

        $('tbody').on('click', '.btn-delete-product_type', function() {
            var product_type_id = $(this).data('delete_id');
            // alert(product_type_id);
            $.ajax({
                url: '{{ url('admin/product/product-type/delete-soft-product-type') }}',
                method: 'get',
                data: {
                    product_type_id: product_type_id
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_product_type();

                    message_toastr('success', 'Thành công', 'Danh mục đã bị xóa');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-un-active', function() {
            var product_type_id = $(this).data('product_type_id');
            var status = $(this).data('status');
            // alert(product_type_id);
            $.ajax({
                url: '{{ url('/admin/product/product-type/un-active-product-type') }}',
                method: 'get',
                data: {
                    product_type_id: product_type_id,
                    status: status,
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_product_type();

                    if (status == 0)
                        message_toastr('success', 'Thành công', 'Loại sản phẩm đã bị vô hiệu hóa');
                    else
                        message_toastr('success', 'Thành công', 'Loại sản phẩm đã được kích hoạt');

                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        function count_Delete(){
            $.ajax({
                url: '{{ url('admin/product/product-type/count-delete') }}',
                method: 'get',
                data: {
                   
                },
                success: function(data) {
                    $('.count-delete').html(data);
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        }
    </script>
@endsection
