@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Thùng Rác Sản Phẩm
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
                    <div class="card-title col-sm-9">Thùng Rác Sản Phẩm</div>
                    {{-- <div class="col-sm-3">
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
                            <th> Tên Sản Phẩm </th>
                            <th>  Danh Mục </th>
                            {{-- <th> Mô Tả </th> --}}
                            <th> Giá </th>
                            <th> Hình Ảnh</th>
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
    {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider --}}
    {{-- <nav aria-label="Page navigation example">
        {!! $all_category->links() !!}
    </nav> --}}

 

    <script>

        // load_category();
        // setInterval( load_delete_soft_category, 500);
        load_delete_soft_product();

        function load_delete_soft_product() {
            $.ajax({
                url: '{{ url('admin/product/trash-product/load-delete-soft-product') }}',
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

        $('tbody').on('click', '.btn-delete-force', function() {
            var product_id = $(this).data('delete_id');
            var type = $(this).data('restore_id');
            // alert(category_id);
            $.ajax({
                url: '{{ url('admin/product/trash-product/delete-restore-product') }}',
                method: 'get',
                data: {
                    product_id: product_id,
                    type: type
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_delete_soft_product();
                    message_toastr('success', 'Sản phẩm đã bị xóa vĩnh viễn');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-restore', function() {
            var product_id = $(this).data('restore_id');
            var type = $(this).data('delete_id');
            // alert(category_id);
            $.ajax({
                url: '{{ url('admin/product/trash-product/delete-restore-product') }}',
                method: 'get',
                data: {
                    product_id: product_id,
                    type: type
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_delete_soft_product();
                    message_toastr('success', 'Sản phẩm đã được khôi phục');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })
    </script>
@endsection
