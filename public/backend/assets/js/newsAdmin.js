addAndRemoveOneContentSubNews();
uploadImageNews();

// import 
let fileUploadDefault = document.querySelector('.file-upload-default'); 


// function thêm và xóa sub title
function addAndRemoveOneContentSubNews() {
    let addOneContentSubNews = document.querySelector('.addOneContentSubNews');
    let removeOneContentSubNews = document.querySelector('.removeOneContentSubNews');
    let count = 1;

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
    });

}



