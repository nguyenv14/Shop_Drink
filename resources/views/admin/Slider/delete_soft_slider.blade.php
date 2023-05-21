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
                </div>
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th>Tên Slider</th>
                            <th>Ảnh Slider</th>
                            <th> Mô Tả </th>
                            <th> Thời gian xóa</th>
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

    <script>
        // load_slider();
        load_slider_delete_soft();
        // setInterval(load_slider_delete_soft, 20);
        function load_slider_delete_soft(){
            $.ajax({
                url: '{{ url('admin/slider/trash-slider/load-slider-delete-soft') }}',
                method: 'get',
                data: {
                },
                success: function(data){
                    $('tbody').html(data);
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        }

        $('tbody').on('click', '.btn-delete-force', function(){
            var slider_id = $(this).data('delete_id');
            // alert(slider_id);
            var type = $(this).data('restore_id');
            // alert(slider_id + "  " + restore);
            $.ajax({
                url: '{{ url('admin/slider/trash-slider/un-or-force-delete-slider') }}',
                method: 'get',
                data: {
                    slider_id : slider_id,
                    type: type
                },
                success: function(data){
                    // $('tbody').html(data);
                    message_toastr('success', 'Thành công', 'Slide đã được xóa vĩnh viễn');
                    load_slider_delete_soft();
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        })

        $('tbody').on('click', '.btn-restore', function(){
            var slider_id = $(this).data('restore_id');
            // alert(slider_id);
            var type = $(this).data('delete_id');
            // alert(slider_id + "  " + restore);
            $.ajax({
                url: '{{ url('admin/slider/trash-slider/un-or-force-delete-slider') }}',
                method: 'get',
                data: {
                    slider_id : slider_id,
                    type : type
                },
                success: function(data){
                    // $('tbody').html(data);
                    message_toastr('success', 'Thành công', 'Slide đã được khôi phục');
                    load_slider_delete_soft();
                },
                error: function(data) {
                        alert("Fix Bug Huhu :<");
                },
            })
        })


    </script>
        {{-- Phân Trang Bằng Paginate + Boostraps , Apply view Boostrap trong Provider--}}
        {{-- <nav aria-label="Page navigation example">
            {!!  $all_slider->links()  !!}
       </nav> --}}

@endsection
