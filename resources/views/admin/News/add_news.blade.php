@extends('admin.admin_layout')
@section('admin_content')

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-crosshairs-gps"></i>
            </span> Quản Lý Bài Báo
        </h3>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 style="margin-top: -15px" class="card-title">Thêm Bài Báo Mới</h4>
                <form class="forms-sample" action="{{ 'save-news' }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Tiêu đề bài báo</label>
                        <input type="text" name="news_title" class="form-control" id="" placeholder="Tiêu đề Báo">
                    </div>
            
                    <div class="form-group">
                        <label>Tải Ảnh Lên</label>
                        <input id="news_image" type="file" name="news_image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Tải ảnh lên">
                            <span class="input-group-append">
                                <label class=" btn btn-gradient-primary" style="
                                height: 100%;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            ">Tải Lên</label>
                            </span>
                        </div>
                    </div>


                    <div class="big-form-group" style="padding: 1.5rem; border: 2px solid black; margin: 0 1.5rem; ">
                        
                        <div class="sub-big-form-group" count_subNews="1">
                            <div class="form-group">
                                <label for="">Tiêu đề con 1</label>
                                <input type="text" name="subTitle1" class="form-control" id="" placeholder="Tiêu đề con 1">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Mô Tả Bài Báo 1</label>
                                <textarea rows="8" class="form-control" name="subContent1" id="editor"></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- button add and remove subtitle  --}}
                    <div class="form-group" style="padding: 1.5rem; border: 2px solid black; margin: 0 1.5rem;">
                        <div class="input-group col-xs-12" >
                            <span class="addOneContentSubNews">
                                <label class=" btn btn-gradient-primary" style="color: black !important; border: 2px solid black;">Thêm một nội dung</label>
                            </span>
                            <span class="removeOneContentSubNews" >
                                <label class=" btn btn-gradient-primary" style="color: black !important; border: 2px solid black;">Xóa bớt nội dung</label>
                            </span>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-gradient-primary me-2" style="margin-top: 1.5rem;">Xác Nhận</button>
                    <button class="btn btn-light" style="margin-top: 1.5rem;">Quay Lại</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/backend/assets/js/newsAdmin.js') }}"></script>
@endsection