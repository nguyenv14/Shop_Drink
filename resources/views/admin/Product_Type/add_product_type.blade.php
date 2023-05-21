@extends('admin.admin_layout')
@section('admin_content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-variant"></i>
        </span> Quản Lý Loại Sản Phẩm
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
            <h4 style="margin-top: -15px" class="card-title">Thêm Loại Sản Phẩm</h4>
            <form class="forms-sample" action="{{ ('save-product-type') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputName1">Size Sản Phẩm</label>
                    <input type="text" name="product_type_name" class="form-control mb-2" id="name" placeholder="Name">
                    <span class="text-danger form-message mt-2"></span>
                </div>
                
                <div class="form-group">
                    <label for="exampleTextarea1">Giá tương ứng</label>
                    <input type="text" name="product_type_price" class="form-control mb-2" id="price" placeholder="Price...">
                    <span class="text-danger form-message mt-2"></span>
                </div>

                {{-- <div class="form-group">
                    <label for="exampleTextarea1">Từ Khóa Hiển Thị (SEO)</label>
                    <textarea class="form-control" name="meta_keywords" id="exampleTextarea1" rows="4"></textarea>
                </div> --}}
               
                <div class="form-group">
                    <label for="">Hiễn thị</label>
                    <select class="form-control" name="product_type_status">
                        <option value="0">Ẩn</option>
                        <option value="1">Hiện</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('public/fontend/assets/js/validate.js')}}"></script>
   
<script>
        Validator({
            form: '.forms-sample',
            errorSelector: '.form-message',
            rules: [
                Validator.isRequired('#name', 'Vui lòng nhập size sản phẩm'),
                
                Validator.minPrice('#price', 1000),
                Validator.maxPrice('#price', 50000),
            ]
        });

        $(':input[type="submit"]').prop('disabled', true);

        $('.form-control').blur(function(){
            if ($('#name').val() != '' && $('#price').val() != '' && $('#price').val() >= 1000 && $('#price').val() <= 50000) {
                $(':input[type="submit"]').prop('disabled', false);
            }
        })
</script>
@endsection
