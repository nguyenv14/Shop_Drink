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
                    <div class="card-title col-sm-5">Bảng Danh Sách Sản Phẩm</div>
                    <div class="col-sm-7">
                        <form action="{{ URL::to('admin/product/all-product-sreachbyname') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchbyname" placeholder="Search">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-gradient-primary me-2">Tìm kiếm</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            {{-- <th> #ID </th> --}}
                            <th>Tên Sản Phẩm <i style="font-size: 18px" class="mdi mdi-sort-alphabetical"></th>
                            <th>Loại Giảm Giá</th>
                            <th>Mức giảm</th>
                            <th>Giá Tiền Gốc</th>
                            <th>Giá Tiền Giảm</th>
                            <th>Hiển Thị</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            {{-- <tr>
                                
                                <td>{{ $flashsale->product->product_name }}</td>
                                <td>
                                    
                                <td>{{ $flashsale->flashsale_percent . $type }}</td>
                               
                                <td>
                                    {{ number_format($flashsale->product->product_price, 0, ',', '.') . 'đ' }}
                                </td>

                                <td>
                                    {{ number_format($flashsale->flashsale_price_sale, 0, ',', '.') . 'đ' }}
                                </td>
                                <td>
                                    @if ($flashsale->flashsale_status == 1)
                                        <i style="color: rgb(52, 211, 52); font-size: 30px"
                                            class="mdi mdi-toggle-switch btn-un-active"
                                            data-flashsale_id="{{ $flashsale->flashsale_id }}" data-status="0"></i>
                                    @else
                                        <i style="color: rgb(196, 203, 196); font-size: 30px"
                                            class="mdi mdi-toggle-switch-off btn-un-active"
                                            data-flashsale_id="{{ $flashsale->flashsale_id }}" data-status="1"></i>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-inverse-danger btn-icon">
                                        <a
                                            href="{{ URL::to('admin/flashsale/edit-product-flashsale?flashsale_id=' . $flashsale->flashsale_id) }}">
                                            <i style="font-size: 20px" class="mdi mdi-lead-pencil"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-inverse-danger btn-icon">
                                        <i style="font-size: 22px" class="mdi mdi-delete-sweep text-danger btn-delete"
                                            data-flashsale_id="{{ $flashsale->flashsale_id }}" data-toggle="modal"
                                            data-target="#Delete"></i>
                                    </button>
                                </td>
                            </tr> --}}
                        
                    </tbody>

                </table>

                <!-- Modal -->
                <!-- Button trigger modal -->


                <!-- Modal -->
                @include('admin.Modal.modal');
            </div>
        </div>
    </div>

    {!! $flashsales->links('admin.ComponentPages.pagination') !!}

    

    <script>

        var notePage = 1;
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            // alert(notePage)
            load_all_flashsale(page);
        });

        function load_all_flashsale(page) {
            $.ajax({
                url: '{{ url('admin/flashsale/load-product-flashsale?page=') }}' + page,
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
        load_all_flashsale(notePage);


        // load_all_flashsale();

        // function load_all_flashsale() {
        //     $.ajax({
        //         url: '{{ url('/admin/flashsale/load-product-flashsale') }}',
        //         method: 'GET',
        //         data: {
        //         },
        //         success: function(data) {
        //             // alert(data);
        //             $('.table-bordered tbody').html(data);
        //         },
        //         error: function(data) {
        //             alert("Fix Bug load_flashsale :<");
        //         },
        //     });
        // }


        $('tbody').on('click', '.btn-delete', function() {
            var flashsale_id = $(this).data('flashsale_id');
            $('.btn_deleted').attr('data-dismiss', '');
            // alert(flashsale_id);
            $('.btn_deleted').click(function() {
                // alert(flashsale_id);
                $('.btn_deleted').attr('data-dismiss', 'modal');
                $.ajax({
                    url: '{{ url('admin/flashsale/delete-product-flashsale') }}',
                    method: 'get',
                    data: {
                        flashsale_id: flashsale_id,

                    },
                    success: function(data) {
                        // $('tbody').html(data);
                        load_all_flashsale(notePage);
                        
                        message_toastr('success', 'Xóa sản phẩm khỏi mục giảm giá thành công')
                    },
                    error: function(data) {
                        alert("Fix Bug un-active Huhu :<");
                    },
                })

            })
        })

        $('tbody').on('click', '.btn-un-active', function() {
            var flashsale_id = $(this).data('flashsale_id');
            var status = $(this).data('status');
            // alert(flashsale_id + " " + status);
            $.ajax({
                url: '{{ url('admin/flashsale/un-active-flashsale') }}',
                method: 'get',
                data: {
                    flashsale_id: flashsale_id,
                    status: status,
                },
                success: function(data) {
                    // $('tbody').html(data);
                    load_all_flashsale(notePage);

                    if (status == 0)
                        message_toastr('success', 'Sản phẩm giảm giá đã bị vô hiệu hóa');
                    else
                        message_toastr('success', 'Sản phẩm giảm giá đã được kích hoạt');

                },
                error: function(data) {
                    alert("Fix Bug un-active Huhu :<");
                },
            })
        })
    </script>
@endsection
