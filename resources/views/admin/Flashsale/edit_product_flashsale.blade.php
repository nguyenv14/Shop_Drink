@extends('admin.admin_layout')
@section('admin_content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Sự Kiện Flashsale
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
                <h4 style="margin-top: -15px" class="card-title">Thêm Sản Phẩm Vào Sự Kiện</h4>
                <form class="forms-sample" action="{{ 'update-product-flashsale' }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                   <input type="hidden" name="flashsale_id" value="{{  $flashsale_old->flashsale_id }}">
                   <input type="hidden" name="product_id" value="{{  $flashsale_old->product_id }}">
                    <div class="form-group">
                        <label for="">Sản Phẩm {{ $flashsale_old->product->product_name }}</label>
                    </div>
                  
                    <div class="form-group">
                        <label for="">Loại Giảm Giá</label>
                        <select class="form-control" name="flashsale_condition">
                            @if($flashsale_old->flashsale_condition == 0)
                            <option selected value="0">Giảm Giá Theo %</option>
                            <option value="1">Giảm Giá Theo Số Tiền</option>
                            @else
                            <option selected value="1">Giảm Giá Theo Số Tiền</option>
                            <option value="0">Giảm Giá Theo %</option>
                            @endif
                        </select>
                    </div>
  
                    <div class="form-group">
                        <label for="">Mức Giảm</label>
                        <input type="number" class="form-control" name="flashsale_percent" id="" placeholder="Số Tiền Giảm Giá" value="{{  $flashsale_old->flashsale_percent }}">
                    </div>
                   
                    <button type="submit" class="btn btn-gradient-primary me-2">Cập Nhật</button>
                    <button class="btn btn-light">Quay Lại</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#editor1'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
