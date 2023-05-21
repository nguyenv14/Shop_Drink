@extends('admin.admin_layout')
@section('admin_content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-certificate"></i>
        </span> Quản Lý Admin
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
            <h4 style="margin-top: -15px" class="card-title">Thêm Mới Quản Trị</h4>
            <form class="forms-sample" action="{{ ('save-admin') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @foreach ($errors->all() as $error)
                <script>
                    message_toastr("warning", '{{ $error }}');
                </script>
                @endforeach
                <div class="form-group">
                    <label for="exampleInputName1">Tên Quản Trị</label>
                    <input type="text" name="admin_name"  class="form-control" id="" value="{{ old('admin_name') }}" placeholder="Nhập Tên">
                </div>
                
                <div class="form-group">
                    <label for="exampleInputName1">Email Quản trị</label>
                    <input type="text" name="admin_email" class="form-control" id="" value="{{ old('admin_email') }}" placeholder="Nhập Email">
                </div>

                <div class="form-group">
                    <label for="exampleTextarea1">Số điện thoại</label>
                    <input type="text" class="form-control" name="admin_phone" id="" value="{{ old('admin_phone') }}">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Mật Khẩu Quản trị</label>
                    <input type="password" name="admin_password_1" value="{{ old('admin_password_1') }}" class="form-control" id="" placeholder="Mật khẩu" >
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Mật Khẩu Xác Nhận</label>
                    <input type="password" name="admin_password_2" value="{{ old('admin_password_2') }}" class="form-control" id="" placeholder="Xác nhận mật khẩu">
                </div>
                
                <div class="row mt-4 mb-5">
                    <div class="col-md-3">
                        <h5>Phân Quyền</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-1 me-2"><input type="radio" id='admin' class="form-check-input" name="roles" value="admin"></div>
                        <label for="admin" class="form-check-label"> Quản Trị </label>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-1 me-2">
                            <input type="radio" id="manager" class="form-check-input" name="roles" value="manager">
                        </div>
                    <label for="manager" class="form-check-label"> Quản Lý </label>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-1 me-2">
                            <input type="radio" id="employee" class="form-check-input" name="roles" checked value="employee">
                        </div>
                    <label for="employee" class="form-check-label"> Nhân Viên </label>
                </div>
                </div>
                {{-- <div class="form-group">
                    <label for="">Tính Năng Của Mã</label>
                    <select class="form-control" name="coupon_condition">
                       @if($coupon_old->coupon_condition == 1 )
                       <option active value="1">Giảm Giá Theo %</option>
                       <option value="2">Giảm Giá Theo Số Tiền</option>
                       @endif
                       @if($coupon_old->coupon_condition == 2 )
                       <option active value="2">Giảm Giá Theo Số Tiền</option>
                       <option  value="1">Giảm Giá Theo %</option>
                       @endif
                    </select>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="exampleInputName1">Số Tiền Hoặc Số % Giảm Giá</label>
                    <input type="text"  name="coupon_price_sale"  value="{{ $coupon_old->coupon_price_sale }} " class="form-control" id="" placeholder="Nhập Số Tiền Hoặc Số % Giảm Giá">
                </div> --}}
                <button type="submit" class="btn btn-gradient-primary me-2">Thêm mới</button>
             
            </form>
        </div>
    </div>
</div>
@endsection
