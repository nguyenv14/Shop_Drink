<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\SubNews;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class NewsPageContentController extends Controller
{
    public function index(Request $request) {

        $id_news = $request->id_news;
        $dataNewsPage = News::where('id_news', $id_news)->first();

        $count = SubNews::where('id_news', $id_news)->get();

        
        $newPage = array(
            'news_title'=>$dataNewsPage->news_title,
            'news_image'=>$dataNewsPage->news_image,
            'created_at'=>$dataNewsPage->created_at,
            'count_sub_title'=> count($count)
        );
        return view('pages.news_page_layout', ['newsPage'=>$newPage, 'subNewsPage'=>json_decode($count)]);
    }

    public function show_all_newspaper() {
        // 
        $newsPage = News::select('id_news', 'news_title', 'news_image', 'display')->get();
        $dataNewsPage = array();
        $count = 0;
        foreach($newsPage as $key => $subNewsPage) {
            $dataNewsPage[$count]['id_news'] = $subNewsPage->id_news;
            $dataNewsPage[$count]['news_title'] = $subNewsPage->news_title;
            $dataNewsPage[$count]['news_image'] = $subNewsPage->news_image;
            $dataNewsPage[$count]['display'] = $subNewsPage->display;

            $countData = SubNews::where('id_news', $subNewsPage->id_news)->count();
            $dataNewsPage[$count]['count_sub_news'] = $countData;

            $count = $count + 1;
        }
        return view('admin.News.all_news', ['dataNewsPage'=>$dataNewsPage]);
    }

    public function show_add_newspaper() {
        return view('admin.News.add_news');
    }

    public function save_newspaper(Request $request) {
        $dataNews = $request->all();
        $news = new News();
        $news['news_title'] = "";
        $news['news_image'] = "";
        $get_image = $request->file('news_image');
        $get_title = $request['news_title'];
        if($get_title) {
            $news['news_title'] = $dataNews['news_title'];
        }
        else 
        {
            return Redirect()->back();
        }
        if($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name .'.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public\fontend\assets\img\news', $new_image);
            $news_image = 'public\fontend\assets\img\news\\'. $new_image;
            $news['news_image'] = $news_image;
        } else {
            return Redirect()->back();
        }
        $news->save();
        $id_news = News::select('id_news')->orderBy('id_news', 'DESC')->first(); 
        $count = 1;
        while($count <= 5) {
            if($request['subTitle'. $count .''] && $request['subContent'. $count .''])
            {
                $subnews = new SubNews();

                $subnews['id_news'] = $id_news['id_news'];
                $subnews['sub_title'] = $request['subTitle'. $count .''];
                $subnews['sub_content'] = $request['subContent'. $count .''];
                $subnews->save();
            }
            $count = $count + 1;
        }
        $count = SubNews::where('id_news', $id_news['id_news'])->get();
        if(number_format(count($count)) == 0)
        {
            $delete_news = News::find($id_news['id_news']);
            $delete_news->delete();
            return Redirect()->back();
        }
        
        return Redirect('admin/news/add-news');
    }

    public function delete_newspaper(Request $request) {
        $id_news = $request->id_news;
        $res_Image_News = News::where('id_news', $id_news)->get(['news_image']);
        $path_Image = (json_decode($res_Image_News[0])->news_image);
        if (File::exists($path_Image)) {
            File::delete($path_Image);
        }
        $res_News = News::find($id_news)->delete();
        $collection = SubNews::where('id_news', $id_news)->get(['id_sub_news']);
        SubNews::destroy($collection->toArray());
        return Redirect()->back();
    }

    public function show_update_newspaper(Request $request) {
        $id_news = $request->id_news;
        $dataNewsPage = News::where('id_news', $id_news)->first();
        $count = SubNews::where('id_news', $id_news)->get();
        $newPage = array(
            'id_news'=>$dataNewsPage->id_news,
            'news_title'=>$dataNewsPage->news_title,
            'news_image'=>$dataNewsPage->news_image, 
            'created_at'=>$dataNewsPage->created_at,
            'count_sub_title'=> count($count)
        );
        return view('admin.News.update_news', ['newsPage'=>$newPage, 'subNewsPage'=>json_decode($count)]);
    }

    public function update_newspaper(Request $request) {
        $dataNews = $request->all(); /* request tất cả các yêu cầu */
        $news = new stdClass; /* Tạo object mới  */
        $news->id_news = $request['id_news'];

        $get_image = $request->file('news_image');
        $get_title = $request['news_title'];
        if($get_title) {
            $news->news_title = $dataNews['news_title'];
        }
        else 
        {
            $news_title_old = News::where('id_news', $news->id_news)->get('news_title');
            $news->news_title = $news_title_old;
        }
        if($get_image) {
            $res_Image_News = News::where('id_news', $news->id_news)->get(['news_image']);
            $path_Image = (json_decode($res_Image_News[0])->news_image);
            if (File::exists($path_Image)) {
                File::delete($path_Image);
            }

            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name .'.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public\fontend\assets\img\news', $new_image);
            $news_image = 'public\fontend\assets\img\news\\'. $new_image;
            $news->news_image = $news_image;
        } else {
            $news_image_old = News::where('id_news', $news->id_news)->get('news_image');
            $news->news_image = json_decode($news_image_old)[0]->news_image;
        }
        // update News
        $update_news = News::where('id_news', $news->id_news)->update([
        'news_title' => $news->news_title, 
        'news_image' => $news->news_image
        ]);
        // delete sub title old
        $collection = SubNews::where('id_news', $news->id_news)->get(['id_sub_news']);
        SubNews::destroy($collection->toArray());
        $count = 1;
        while($count <= 5) {
            if($request['subTitle'. $count .''] && $request['subContent'. $count .''])
            {
                $subnews = new SubNews();
                $subnews['id_news'] = $news->id_news;
                $subnews['sub_title'] = $request['subTitle'. $count .''];
                $subnews['sub_content'] = $request['subContent'. $count .''];
                $subnews->save();
            }
            $count = $count + 1;
        }
        $this->show_all_newspaper();
        return Redirect('./admin/news/all-news');
    }

    public function update_display_newspaper(Request $request) {
        $id_news = $request->id_news;
        $display = $request->display;
        $update_news = News::where('id_news', $id_news)->update([
            'display' => $display
        ]);
        
        return Redirect()->back();
    }


}
