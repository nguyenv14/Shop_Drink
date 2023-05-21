@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Quản Lý Loại Sản Phẩm
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
                    <div class="card-title col-sm-9">Bảng Danh Sách Loại Sản Phẩm</div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-gradient-primary me-2">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th> Size Sản Phẩm </th>
                            <th> Giá  </th>
                            <th> Ngày Xóa </th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

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

        // load_product_type();
        // setInterval( load_delete_soft_product_type, 500);
        load_delete_soft_product_type();

        function load_delete_soft_product_type() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ url('admin/product/product-type/trash-product-type/load-delete-soft-product-type') }}',
                method: 'post',
                data: {
                    _token: _token,
                },
                success: function(data) {
                    $('tbody').html(data);
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        }

        $('tbody').on('click', '.btn-delete-force', function() {
            var product_type_id = $(this).data('delete_id');
            var type = $(this).data('restore_id');
            var _token = $('meta[name="csrf-token"]').attr('content');
            // alert(product_type_id);
            $.ajax({
                url: '{{ url('admin/product/product-type/trash-product-type/delete-restore-product-type') }}',
                method: 'post',
                data: {
                    product_type_id: product_type_id,
                    type: type,
                    _token: _token,
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_delete_soft_product_type();
                    message_toastr('success', 'Thành công', 'Size sản phẩm đã bị xóa vĩnh viễn');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-restore', function() {
            var product_type_id = $(this).data('restore_id');
            var type = $(this).data('delete_id');
            var _token = $('meta[name="csrf-token"]').attr('content');
            // alert(product_type_id);
            $.ajax({
                url: '{{ url('admin/product/product-type/trash-product-type/delete-restore-product-type') }}',
                method: 'post',
                data: {
                    product_type_id: product_type_id,
                    type: type,
                    _token: _token,

                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_delete_soft_product_type();
                    message_toastr('success', 'Thành công', 'Size sản phẩm đã được khôi phục');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })
    </script>
@endsection
