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
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-top: -15px" class="card-title">Thêm Sản Phẩm</h4>
                <form class="forms-product" action="{{ 'save-product' }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputName1">Tên Sản Phẩm</label>
                        <input type="text" name="product_name" class="form-control mb-2" id="name"
                            placeholder="Name" value="">
                            <span class="text-danger form-message pt-2"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Danh Mục Sản Phẩm</label>
                        <select class="form-control m-bot15" id="category" name="category_id">
                            @foreach ($data_category as $key => $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleTextarea1">Mô Tả Sản Phẩm</label>
                        {{-- <input type="text" id="product_desc" value="" name="product_desc"> --}}
                        <textarea rows="8" class="form-control mb-2" name="product_desc" id="desc"></textarea>
                        <br>
                        <span class="text-danger form-message"></span>
                    </div>

                    <div class="form-group">
                        <label>File upload</label>
                        <div class="mb-3">
                            {{-- <label for="formFile" class="form-label">Default file input example</label> --}}
                            <input name="product_image" class="form-control mb-2" type="file" id="formFile">
                            <br>
                            <span class="text-danger form-message pt-2"></span>
                          </div>
                        {{-- <input id="product_image" type="file" name="product_image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <label for="product_image" class="file-upload-browse btn btn-gradient-primary"
                                    type="button">Upload</label>
                            </span>
                        </div> --}}
                    </div>

                    {{-- <div class="form-group">
                        <label for="">Đơn Vị</label>
                        <select class="form-control" name="product_unit">
                            <option value="0">Con</option>
                            <option value="1">Phần</option>
                            <option value="2">khay</option>
                            <option value="3">Túi</option>
                            <option value="4">Kg</option>
                            <option value="5">Gam</option>
                            <option value="6">Combo set</option>
                        </select>
                    </div> --}}
  
                    {{-- <div class="form-group">
                        <label for="">Lượng Bán</label>
                        <input type="number" class="form-control" name="product_unit_sold" id="" placeholder="Lượng Bán">
                    </div> --}}

                    <div class="form-group">
                        <label for="">Giá Sản Phẩm</label>
                        <input type="number" class="form-control mb-2" name="product_price" id="price" placeholder="Giá" value="">
                        <span class="text-danger form-message mt-2"></span>
                    </div>
                   
                    <div class="form-group">
                        <label for="">Hiển thị</label>
                        <select class="form-control" name="product_status">
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
    <script>
        
    </script>
     <script src="{{ asset('public/fontend/assets/js/validate.js')}}"></script>
   
     <script>
             Validator({
                 form: '.forms-product',
                 errorSelector: '.form-message',
                 rules: [
                     Validator.isRequired('#name', 'Vui lòng nhập tên sản phẩm'),
                     Validator.isRequired('#formFile', 'Vui lòng tải lên ảnh Sản Phẩm'),
                     Validator.isRequired('#desc', 'Vui lòng nhập mô tả sản phẩm'),
                     Validator.minPrice('#price', 20000),
                     Validator.maxPrice('#price', 200000),
                 ]
             });
     
             $(':input[type="submit"]').prop('disabled', true);
     
             $('.form-control').blur(function(){
                 if ($('#name').val() != '' && $('#desc').val() != ''  && $('#price').val() != '' && $('#price').val() >= 20000 && $('#price').val() <= 200000) {
                     $(':input[type="submit"]').prop('disabled', false);
                 }
             })
    </script>
@endsection
