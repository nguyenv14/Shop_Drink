@extends('admin.admin_layout')
@section('admin_content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-certificate"></i>
        </span> Quản Lý Mã Giảm Giá
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
            <h4 style="margin-top: -15px" class="card-title">Thêm Mã Giảm Giá</h4>
            <form class="forms-sample" action="{{ ('update-admin') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="admin_id" value="{{ $admin->admin_id }}">
                <div class="form-group">
                    <label for="exampleInputName1">Tên Quản Trị</label>
                    <input type="text" name="admin_name" value="{{ $admin->admin_name }}" class="form-control" id="" placeholder="Nhập Tên Mã Giảm Giá">
                </div>
                
                <div class="form-group">
                    <label for="exampleInputName1">Email Quản trị</label>
                    <input type="text" name="admin_email" value="{{ $admin->admin_email }} "class="form-control" id="" placeholder="Nhập Mã Giảm Giá">
                </div>

                <div class="form-group">
                    <label for="exampleTextarea1">Số điện thoại</label>
                    <input type="text" class="form-control" name="admin_phone" id="" value="{{$admin->admin_phone}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Mật Khẩu Quản trị 1</label>
                    <input type="password" name="admin_password_1" value="{{ $admin->admin_password }}" class="form-control" id="" placeholder="Nhập Số Lượng Mã">
                </div>

                <div class="form-group">
                    <label for="exampleInputName1">Mật Khẩu Xác Nhận</label>
                    <input type="password" name="admin_password_2" value="{{ $admin->admin_password }}" class="form-control" id="" placeholder="Nhập Số Lượng Mã">
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
                <button type="submit" class="btn btn-gradient-primary me-2">Cập Nhật</button>
                <button class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
