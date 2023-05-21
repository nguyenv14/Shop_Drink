<div class="banner-overlay"></div>
<div class="banner">
    <div class="banner-image">
        <div class="banner-close">
            <span> <i class="fa-solid fa-xmark"></i></span>
        </div>
        <a href="#">
            <img src="{{ $new_banner->news_image }}" alt="">
        </a>
    </div>
    <div class="banner-text">
        <div class="banner-title">
            <span>{{ $new_banner->news_title }}</span>
        </div>
        <div class="banner-text">
           <span>
               {{ $new_banner->subnews->sub_title }}
             </span> 
            {{-- <span>Tháng 11, bạn muốn đi du lịch Tây Bắc? Chọn ngay Sapa khỏi phải nghĩ</span> --}}
        </div>
    </div>
    <a href="{{ url('/newsPageContent?id_news='.$new_banner->id_news.'') }}">
        <div class="banner-button">
            <div class="banner-btn">
                <span>Xem Thêm</span>
            </div>
        </div>
    </a>
</div>

<script>
    $('.banner-close').click(function() {
        $('.banner-overlay').hide();
        $('.banner').hide();
    });
    $('.banner-overlay').click(function() {
        $('.banner-overlay').hide();
        $('.banner').hide();
    });
</script>
