@extends('admin.admin_layout')
@section('admin_content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-variant"></i>
        </span> Quản Lý Danh Mục
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
            <h4 style="margin-top: -15px" class="card-title">Thêm Danh Mục</h4>
            <form class="forms-sample" action="{{ ('save-category') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputName1">Tên Danh Mục</label>
                    <input type="text" name="category_name" class="form-control mb-2" id="name" placeholder="Name">
                    <span class="text-danger form-message mt-2"></span>
                </div>
                
                <div class="form-group">
                    <label for="exampleTextarea1">Mô Tả Danh Mục</label>
                    <textarea class="form-control mb-2" name="category_desc" id="desc" rows="4"></textarea>
                    <span class="text-danger form-message mt-2"></span>
                </div>

                {{-- <div class="form-group">
                    <label for="exampleTextarea1">Từ Khóa Hiển Thị (SEO)</label>
                    <textarea class="form-control" name="meta_keywords" id="exampleTextarea1" rows="4"></textarea>
                </div> --}}
               
                <div class="form-group">
                    <label for="">Hiễn thị</label>
                    <select class="form-control" name="category_status">
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
                     Validator.isRequired('#name', 'Vui lòng nhập tên danh mục'),
                     Validator.isRequired('#desc', 'Vui lòng nhập mô tả danh mục'),
                 
                 ]
             });
     
             $(':input[type="submit"]').prop('disabled', true);
     
             $('.form-control').change(function(){
                 if ($('#name').val() != '' && $('#desc').val() != '' && $('.form-group').hasClass('invalid') == false) {
                     $(':input[type="submit"]').prop('disabled', false);
                 }
             })
</script>
@endsection
