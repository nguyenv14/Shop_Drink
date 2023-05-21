@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-variant"></i>
            </span> Quản Lý Vận Chuyển
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
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-top: -15px" class="card-title">Thiết Lập Phí Vận Chuyển</h4>
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="">Chọn Tỉnh Thành Phố</label>
                        <select class="form-control choose  city" name="city" id="city">
                            <option value="">---Chọn Tỉnh Thành Phố---</option>
                            @foreach ($cities as $key => $city)
                                <option value="{{ $city->matp }}">{{ $city->name_city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Chọn Quận Huyện</label>
                        <select class="form-control choose  province" name="province" id="province">
                            <option value="">---Chọn Quận Huyện---</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Chọn Xã Phường Thị Trấn</label>
                        <select class="form-control wards" name="wards" id="wards">
                            <option value="">---Chọn Xã Phường---</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for=""> Phí Vận Chuyển</label>
                        <input type="text" class="form-control fee_ship" name="fee_ship">
                    </div>

                    <button type="button" id="summit_feeship" class="btn btn-gradient-primary me-2">Thêm Phí Vận
                        Chuyển</button>
                    <button class="btn btn-light">Trở Lại</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="display: flex;justify-content: space-between">
                <div class="card-title col-sm-5">Bảng Danh Sách Phí Vận Chuyển</div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-gradient-primary me-2">Tìm kiếm</button>
                        </span>
                    </div>
                </div>
            </div>
            <table style="margin-top:20px " class="table table-bordered table-feeship">
                <thead>
                    <tr>
                        <th> #ID </th>
                        <th> Tỉnh Thành Phố </th>
                        <th> Quận Huyện </th>
                        <th> Xã Thị Trấn </th>
                        <th> Phí Ship </th>
                        <th> Thao Tác </th>
                    </tr>
                </thead>
                <tbody id="load_delivery">

                </tbody>
            </table>
        </div>
    </div>


    {!! $fee_ship->links('admin.ComponentPages.pagination') !!}



    <div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa phí khu vực này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-danger btn_deleted" data-dismiss="modal">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    


    <script>


var notePage = 1;
        $('.pagination a').unbind('click').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            notePage = page;
            // alert(notePage)
            loading_delivery(page);
        });

        function loading_delivery(page) {
            $.ajax({
                url: '{{ url('admin/delivery/loading-feeship?page=') }}' + page,
                method: 'get',
                data: {

                },
                success: function(data) {
                    $('#load_delivery').html(data);
                },
                error: function() {
                    alert("Bug Huhu :<<");
                }
            })
        }
        loading_delivery(notePage);



       


        $('.choose').change(function() {
            var action = $(this).attr('id'); /* Lấy Thuộc Tính Của ID */
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if (action == 'city') {
                result = 'province';
            } else {
                result = 'wards';
            }
            $.ajax({
                url: '{{ url('/admin/delivery/select-delivery') }}',
                method: 'POST',
                data: {
                    action: action,
                    ma_id: ma_id,
                    _token: _token,

                },
                success: function(data) {
                    $('#' + result).html(data);
                },
                error: function() {
                    alert("Ngu quá, Fix Bug Huhu :<");
                },
            });
        });



        $('#summit_feeship').click(function() {
                var city = $('.city').val();
                var province = $('.province').val();
                var wards = $('.wards').val();
                var fee_ship = $('.fee_ship').val();
                var _token = $('input[name="_token"]').val();


                if(city == '' || province == '' || wards == ''){
                    message_toastr('error', 'Hãy nhập đầy đủ các trường!!!');
                }else if(fee_ship < 1000){
                    message_toastr('warning', 'Phí ship phải trên 1.000đ!!');
                }else if(fee_ship >= 100000){
                    message_toastr('warning', 'Phí ship không được cao quá 100.000đ');
                }else{
                    $.ajax({
                        url: '{{ url('admin/delivery/insert-delivery') }}',
                        method: 'get',
                        data: {
                            city: city,
                            province: province,
                            wards: wards,
                            fee_ship: fee_ship,
                            _token: _token,
    
                        },
                        success: function(data) {
                            // alert("Thêm Phí Vận Chuyển Thành Công !");
                            if(data == 'error'){
                                message_toastr('warning', 'Khu vực này đã thêm phí ship');
                            }else{
                                message_toastr('success', 'Đã thêm phí ship thành công');
                                loading_delivery(notePage);
                            }
                        },
                        error: function() {
                            alert("nguuuu Fix Bug Huhu :<");
                        },
                    });
                }
            });


                /* Xóa FeeShip */
            $('#load_delivery').on('click', '.delete_fee', function() {
                var feeship_id = $(this).data('id_fee');
                var _token = $('input[name="_token"]').val();
                $('.btn_deleted').click(function(){
                    $.ajax({
                        url: '{{ url('admin/delivery/delete-delivery') }}',
                        method: 'POST',
                        data: {
                            feeship_id: feeship_id,
                            _token: _token,
                        },
                        success: function(data) {
                            message_toastr("success", "Phí Vận Chuyển Đã Được Xóa !");
                            loading_delivery(notePage);
                        },
                        error: function() {
                            alert("Nguyên Ơi Fix Bug Huhu :<");
                        },
                    });
                })
            });


            //     /* Cập Nhật FeeShip */
            $('#load_delivery').on('blur', '.fee_change', function() {
                var feeship_id = $(this).data('id_fee');
                var feeship_value = $(this).text();
                var _token = $('input[name="_token"]').val();
                if(feeship_value < 1000){
                    message_toastr('warning', 'Phí ship phải trên 1.000đ!!');
                    loading_delivery(notePage);
                }else if(feeship_value >= 100000){
                    message_toastr('warning', 'Phí ship không được cao quá 100.000đ');
                    loading_delivery(notePage);
                }else{
                $.ajax({
                    url: '{{ url('admin/delivery/update-delivery') }}',
                    method: 'POST',
                    data: {
                        feeship_id: feeship_id,
                        feeship_value: feeship_value,
                        _token: _token,
                    },
                    success: function(data) {
                        message_toastr("success", "Phí Vận Chuyển Đã Được Cập Nhật !");
                        loading_delivery(notePage);
                    },
                    error: function() {
                        alert("Nguyên Ơi Fix Bug Huhu :<");
                    },
                });
                }
            });
    </script>
@endsection
