@extends('admin.admin_layout')
@section('admin_content')

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Bài Báo
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
                    <div class="card-title col-sm-9">Bảng Danh Sách Bài Báo</div>
                </div>
                
                <table style="margin-top:20px " class="table table-bordered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th>Tên Bài Báo</th>
                            <th>Ảnh Bài Báo</th>
                            <th>Số nội dung con</th>
                            <th>Hiển thị</th>
                            <th>Xem bài</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataNewsPage as $key => $subData)
                            <tr class="row_data_news">
                                <td class="get_id_data_news"><label>{{ $subData['id_news'] }}</label></td>
                                <td style="width: 70px; text-overflow: hidden;">
                                    
                                <div style="width: 270px; overflow: hidden;">{{ $subData['news_title'] }}</div>
                                </td>
                            
                                <td>
                                    <img style="object-fit: cover; border-radius: 0px" width="100px" height="50px"
                                        src="{{ URL::to($subData['news_image']) }}"
                                        alt="">
                                </td>

                                <td>{{ $subData['count_sub_news'] }}</td>

                                <td>
                                    @if ($subData['display'] == 1)
                                        <input type="checkbox" class="checkBox{{ $subData['id_news'] }}" name="" id="" checked>
                                    @else
                                        <input type="checkbox" class="checkBox{{ $subData['id_news'] }}" name="" id="">
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="btn btn-inverse-danger btn-icon btn-view-news"><i class="mdi mdi-newspaper"></i></button>
                                </td>

                                <td>
                                    
                                    <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-news"><i class="mdi mdi-delete"></i></button>
                                    <button type="button" class="btn btn-inverse-danger btn-icon btn-update-news"><i class="mdi mdi-lead-pencil"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <script>
        $('.btn-view-news').click(function() {
            console.log('click');
            // e.parent().children('.get_id_data_news');
            // e.closest('.row_data_n.ews').children('.get_id_data_news').text()
            // console.log(id);

            var id = $(this).closest('.row_data_news').children('.get_id_data_news').text();
            window.location.href = '/bonodrink/newsPageContent?id_news='+id+'';
        });

        $('.btn-delete-news').click(function() {
            console.log('click');
            // e.parent().children('.get_id_data_news');
            // e.closest('.row_data_n.ews').children('.get_id_data_news').text()
            // console.log(id);

            var id = $(this).closest('.row_data_news').children('.get_id_data_news').text();
            window.location.href = '/bonodrink/admin/news/delete-news?id_news='+id+'';
        });

        $('.btn-update-news').click(function() {
            console.log('click');
            // e.parent().children('.get_id_data_news');
            // e.closest('.row_data_n.ews').children('.get_id_data_news').text()
            // console.log(id);

            var id = $(this).closest('.row_data_news').children('.get_id_data_news').text();
            window.location.href = '/bonodrink/admin/news/update-news?id_news='+id+'';
        });    
    </script>
    <script>
        var max = 5;
        var checkboxes = $('input[type="checkbox"]');   
        // console.log(checkboxes);
        checkboxes.change(function() {
            var current = checkboxes.filter(':checked').length;
            checkboxes.filter(':not(:checked)').prop('disabled', current >= max);
            // console.log(current);
        });

        $('input[type="checkbox"]').click(function(event) {
            event.target.checked
            var id = $(this).closest('.row_data_news').children('.get_id_data_news').text();
            if(event.target.checked) {
                // console.log('da check .checkBox'+id+'');
                window.location.href = '/bonodrink/admin/news/displayView?id_news='+id+'&&display=1';
            } else {
                // console.log("chua check");
                window.location.href = '/bonodrink/admin/news/displayView?id_news='+id+'&&display=0';
            }
            
            // console.log(id);

        })


    </script>

@endsection