@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Slider
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
                    <div class="card-title col-sm-9">Bảng Danh Sách Slider</div>
                    <div class="col-sm-3">
                        <button class="btn btn-outline-success btn-fw"><a href="{{ url('admin/slider/trash-slider') }}" style="text-decoration: none;color: black">Thùng rác <span class="count-delete" style="color: red"></span></a></button>
                    </div>
                </div>
                
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th>Tên Slider</th>
                            <th>Ảnh Slider</th>
                            <th> Mô Tả </th>
                            <th> Hiễn Thị </th>
                            <th> Thao Tác </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($sliders as $key => $slider)
                            <tr>
                                <td>{{ $slider->slider_id }}</label>
                                </td>
                                <td>{{ $slider->slider_name }}</td>
                               
                                <td><img style="object-fit: cover" width="40px" height="20px"
                                        src="{{ URL::to('public/fontend/assets/img/slider/'.$slider->slider_image) }}"
                                        alt=""></td>
                                <td>{{ $slider->slider_desc }}</td>
                                <td>
                                    @if ($slider->slider_status == 1)
                                        <a href="{{ URL::to('admin/slider/unactive-slider?slider_id=' . $slider->slider_id) }}">
                                            <i style="color: rgb(52, 211, 52); font-size: 30px"
                                            class="mdi mdi-toggle-switch"></i>
                                        </a>
                                    @else
                                        <a href="{{ URL::to('admin/slider/active-slider?slider_id=' . $slider->slider_id) }}">
                                            <i style="color: rgb(196, 203, 196);font-size: 30px"
                                            class="mdi mdi-toggle-switch-off"></i>
                                        </a>
                                    @endif
                                </td>

                                <td>
                                    
                                    <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-slider"><i class="mdi mdi-delete"></i></button>
                                    <button type="button" class="btn btn-inverse-danger btn-icon"><i class="mdi mdi-lead-pencil"></i></button>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {!! $sliders->links('admin.ComponentPages.pagination') !!}

    <script>
        
        
        var notePage = 1;
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            // alert(notePage)
            load_slider(page);
        });

        function load_slider(page) {
            $.ajax({
                url: '{{ url('admin/slider/load-slider?page=') }}' + page,
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
        load_slider(notePage);

        setInterval(load_count_delete, 200);
        // function load_slider(){
        //     $.ajax({
        //         url: '{{ url('admin/slider/load-slider') }}',
        //         method: 'get',
        //         data: {
        //         },
        //         success: function(data){
        //             $('tbody').html(data);
        //         },
        //         error: function(data) {
        //                 alert("Fix Bug Huhu :<");
        //         },
        //     })
        // }
        // setInterval(load_slider, 1000);
        $('tbody').on('click', '.btn-delete-slider', function(){
            var slider_id = $(this).data('delete_id');
            // alert(slider_id);
            $.ajax({
                url: '{{ url('admin/slider/delete-soft-slider') }}',
                method: 'get',
                data: {
                    slider_id : slider_id,
                },
                success: function(data){
                    // $('tbody').html(data);
                    load_slider(notePage);
                    message_toastr('success', 'Thành công', 'Slide đã vào thùng rác');
                    // load_slider();
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-un-active', function(){
            var slider_id = $(this).data('slider_id');
            var status = $(this).data('slider_status');
            // alert(slider_id + " " + status);
            $.ajax({
                url: '{{ url('admin/slider/un-active-slider') }}',
                method: 'get',
                data: {
                    slider_id : slider_id,
                    status : status
                },
                success: function(data){
                    // $('tbody').html(data);
                    if(status == 0)
                    message_toastr('success', 'Thành công', 'Slide đã bị vô hiệu');
                    else
                    message_toastr('success', 'Thành công', 'Slide đã được kích hoạt');

                    // load_slider();
                    load_slider(notePage);
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        })



        function load_count_delete(){
            $.ajax({
                url: '{{ url('admin/slider/count-delete') }}',
                method: 'get',
                data: {
                },
                success: function(data){
                    $('.count-delete').html(data);
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        }

    </script>
        {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider--}}
        {{-- <nav aria-label="Page navigation example">
            {!!  $all_slider->links()  !!}
       </nav> --}}

@endsection
