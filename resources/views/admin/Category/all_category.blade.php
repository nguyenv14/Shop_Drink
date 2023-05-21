@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Quản Lý Thể Loại
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
                    <div class="card-title col-sm-5">Bảng Danh Sách Thể Loại

                        
                    </div>
                    <div class="col-sm-3">
                        {{-- <button class="btn btn-outline-success btn-fw"><a
                                href="{{ url('admin/category/trash-category') }}"
                                style="text-decoration: none;color: black"> Thùng rác <span class="count-delete"
                                    style="color: red"></span></a></button> --}}
                                    <a style="text-decoration: none"
                            href="{{ url('admin/category/trash-category') }}">
                                <button type="button" class="btn btn-outline-secondary">Thùng Rác
                                     {{-- ( {{ $countDelete }} )  --}}
                                     <span class="count-delete"
                                    style="color: red"></span>
                                    </button>
                            </a>
                    </div>
                    <div class="col-sm-4">
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
                            <th> Tên Danh Mục </th>
                            <th> Mô Tả </th>
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
        {!! $all_category->links() !!}
    </nav> --}}

    {{-- <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="display: flex;justify-content: space-between">
                    <div class="card-title col-sm-9">Bảng Danh Sách Thể Loại Lấy Dữ Liệu Bằng API</div>
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
                            <th> Tên Danh Mục </th>
                            <th> Mô Tả </th>
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
    </div> --}}


    {!! $all_category->links('admin.ComponentPages.pagination') !!}


    <script>
        // $.get('http://localhost/DoAnCNWeb/api/admin/category/all-category',function(res){
        //     //console.log(res);
        //     if(res.status_code == 200){ /* Kiểm Tra */
        //         let all_category = res.data;
        //         //console.log(all_category);
        //         // all_category.forEach(function(item){
        //         //     console.log(item);
        //         // })
        //     }
        // });



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
                url: '{{ url('admin/category/load-category?page=') }}' + page,
                method: 'get',
                data: {

                },
                success: function(data) {
                    $('tbody').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        getPosts(notePage);        
        count_Delete();
        // setInterval( count_Delete, 1000);

        // function load_category() {
        //     $.ajax({
        //         url: '{{ url('admin/category/load-category') }}',
        //         method: 'get',
        //         data: {},
        //         success: function(data) {
        //             $('tbody').html(data);
        //         },
        //         error: function(data) {
        //             alert("Fix Bug Huhu :<");
        //         },
        //     })
        // }

        $('tbody').on('click', '.btn-delete-category', function() {
            var category_id = $(this).data('delete_id');
            // alert(category_id);
            $.ajax({
                url: '{{ url('admin/category/delete-soft-category') }}',
                method: 'get',
                data: {
                    category_id: category_id
                },
                success: function(data) {
                    // $('tbody').html(data);
                    getPosts(notePage);
                    count_Delete();
                    message_toastr('success', 'Thành công', 'Danh mục đã bị xóa');
                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-un-active', function() {
            var category_id = $(this).data('category_id');
            var status = $(this).data('status');
            $.ajax({
                url: '{{ url('admin/category/un-active-category') }}',
                method: 'get',
                data: {
                    category_id: category_id,
                    status: status,
                },
                success: function(data) {
                    // $('tbody').html(data);
                    getPosts(notePage);
                    if (status == 0)
                        message_toastr('success', 'Thành công', 'Danh mục đã bị vô hiệu hóa');
                    else
                        message_toastr('success', 'Thành công', 'Danh mục đã được kích hoạt');

                },
                error: function(data) {
                    alert("Fix Bug Huhu :<");
                },
            })
        })

        function count_Delete(){
            $.ajax({
                url: '{{ url('admin/category/count-delete') }}',
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
