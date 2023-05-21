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
                <h4 style="margin-top: -15px" class="card-title">Cập Nhật Bài Báo </h4>
                <form class="forms-sample" action="{{ 'save-update-news' }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Tiêu đề bài báo</label>
                        <input type="hidden" name="id_news" value="{{ $newsPage['id_news'] }}">
                        <input type="text" name="news_title" class="form-control" id="" placeholder="Tiêu đề Báo" value="{{ $newsPage['news_title'] }}">
                    </div>
            
                    <div class="form-group" style="width: 100%; text-align: center;" alight="center">
                        <figure class="figure" style="">
                    <div class="form-group" style="width: 100%; text-align: center;" alight="center">
                            <img class="media" src="{{  URL::to($newsPage['news_image']) }}" alt="" style="width: 100%;">
                            <figcaption class="figcaption">Tùng Trương mãi đỉnh.</figcaption>
                        </figure>
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

                    {{-- @for($i = 1; $i <= $newsPage['count_sub_title']; $i++)
                        
                    @endfor --}}

                    
                    <div class="big-form-group" style="padding: 1.5rem; border: 2px solid black; margin: 0 1.5rem; ">
                        @if($newsPage['count_sub_title'] == '0') 
                            
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

                            <?php $countSub = 0; ?>
                        @endif
                        <?php $i = 1; ?>
                        @foreach($subNewsPage as $key => $subNewsPageData) 
                            <div class="sub-big-form-group" count_subNews="{{ $i }}">
                                <div class="form-group">
                                    <label for="">Tiêu đề con {{ $i }}</label>
                                    <input type="hidden" name="id_sub_news" value="{{ $subNewsPageData->id_sub_news }}">
                                    <input type="text" name="subTitle{{ $i }}" class="form-control" id="" placeholder="Tiêu đề con {{ $i }}" value="{{ $subNewsPageData->sub_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Mô Tả Bài Báo {{ $i }}</label>
                                    <textarea rows="8" class="form-control" name="subContent{{ $i }}" id="editor" >{{ $subNewsPageData->sub_content }}</textarea>
                                </div>
                            </div>
                        <?php 
                            $i = $i + 1; 
                            $countSub = $i;
                        ?>
                        @endforeach
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

    <script>

        // import
        let fileUploadDefault = document.querySelector('.file-upload-default'); 


        uploadImageNews();
        @if($countSub == "0")
            addAndRemoveOneContentSubNews('1');
        @else
            addAndRemoveOneContentSubNews('{{ $countSub - 1  }} ');
        @endif


        // function thêm và xóa sub title
        function addAndRemoveOneContentSubNews(countSub) {
            let addOneContentSubNews = document.querySelector('.addOneContentSubNews');
            let removeOneContentSubNews = document.querySelector('.removeOneContentSubNews');
            let count = parseInt(countSub);

            addOneContentSubNews.addEventListener('click', function () {
                if(count <= 4)
                {
                    count = count + 1;
                    let newHtml = `
                        <div class="sub-big-form-group" count_subNews="`+ count +`">
                            <div class="form-group">
                                <label for="">Tiêu đề con `+ count +`</label>
                                <input type="text" name="subTitle`+ count +`" class="form-control" id="" placeholder="Tiêu đề con `+ count +`">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Mô Tả Bài Báo `+ count +`</label>
                                <textarea rows="8" class="form-control" name="subContent`+ count +`" id="editor"></textarea>
                            </div>
                        </div>
                    `;
                    document.querySelector('.big-form-group').insertAdjacentHTML('beforeend', newHtml);
                }
            });

            removeOneContentSubNews.addEventListener('click', function() {
                if(count >= 2) {
                    count = count - 1;
                    let subBigFormGroup = document.querySelectorAll('.sub-big-form-group');
                    subBigFormGroup[subBigFormGroup.length-1].remove();
                }
            });







        }
        // function upload and display image
        function uploadImageNews() {


            let inputGroupAppend = document.querySelector('.input-group-append');
            inputGroupAppend.addEventListener('click', function() {
                
                fileUploadDefault.click();
                displayNameFile();

            });

        }
        function displayNameFile() {

            fileUploadDefault.addEventListener('change', function (event) {
                let fileUploadInfo = document.querySelector('.file-upload-info');
                fileUploadInfo.value = event.currentTarget.files[0].name;

                var image = document.querySelector('.media');
                image.src = URL.createObjectURL(event.target.files[0]);
                // $('.media').attr('src', event.target.result);
            });

        }


    </script>

    {{-- <script src="{{ asset('public/backend/assets/js/newsAdmin.js') }}"></script> --}}
@endsection