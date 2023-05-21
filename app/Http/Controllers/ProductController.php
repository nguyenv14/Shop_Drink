<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flashsale;
use App\Models\GalleryProduct;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Pagination\Paginator;

session_start();
class ProductController extends Controller
{
    public function all_product()
    {
        $all_product = Product::paginate(5);
        $data_category = Category::get();
        return view('admin.Product.all_product')->with(compact('all_product', 'data_category'));
    }

    public function product_detail(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::where('product_id', $product_id)->first();

        return view('admin.Product.productdetails')->with(compact('product'));
    }

    public function load_product()
    {
        $all_product = Product::orderby('product_id', "DESC")->paginate(5);
        $output = $this->print_list_product($all_product);
        echo $output;
    }

    public function print_list_product($list_product)
    {
        $output = '';
        foreach ($list_product as $key => $product) {
            $output .= '
            <tr>
            <td>' . $product->product_name . ' </td>
            <td>' . $product->category->category_name . '</td>
            ';

            $output .= '
            <td> ' . number_format($product->product_price, 0, ',', '.') . '</td>
            <td><img style="object-fit: cover" width="40px" height="20px"
                    src="' . URL('public/fontend/assets/img/product/' . $product->product_image) . '"
                    alt=""></td>
            <td>
            ';
            if ($product->product_status == 1) {
                $output .= '
                   
                    <i style="color: rgb(52, 211, 52); font-size: 30px" class="mdi mdi-toggle-switch btn-un-active" data-product_id="' . $product->product_id . '" data-status="0"></i>
                   
                    ';
            } else {
                $output .= '
                    
                    <i style="color: rgb(196, 203, 196); font-size: 30px" class="mdi mdi-toggle-switch-off btn-un-active" data-product_id="' . $product->product_id . '" data-status="1"></i>
                   
                    ';
            }
            $output .= '  
            </td>

            <td>
                <button type="button" class="btn btn-inverse-danger btn-icon"><a href="' . URL('admin/product/product-detail?product_id=' . $product->product_id) . '"><i style="font-size: 20px;padding-right: 5px; color: rgb(230, 168, 24)"
                        class=" mdi mdi-clipboard-outline"></i></a></button>

                <button type="button" class="btn btn-inverse-danger btn-icon">
                <a href="' . URL('admin/product/edit-product?product_id=' . $product->product_id) . '"><i style="font-size: 20px" class="mdi mdi-lead-pencil"></i></a>
                </button>  

                <button type="button" class="btn btn-inverse-danger btn-icon">
                <i style="font-size: 22px" class="mdi mdi-delete" data-product_id="' . $product->product_id . '"></i>
                </button>
                
            </td>
            </tr>
            ';
        }
        return $output;
    }

    public function add_product()
    {
        $data_category = Category::get();
        return view('admin.Product.add_product')->with(compact('data_category'));
    }

    public function save_product(Request $req)
    {
        $data = $req->all();
        $product_new = new Product();



        $product_new['product_name'] = $data['product_name'];
        $product_new['category_id'] = $data['product_category'];
        $product_new['product_desc'] = $data['product_desc'];
        $product_new['product_price'] = $data['product_price'];
        $product_new['product_status'] = $data['product_status'];
        $get_image = $req->file('product_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public\fontend\assets\img\product', $new_image);
            $data['product_image'] = $new_image;
            $product_new['product_image'] = $data['product_image'];
        } else {
            $this->message("error", "Ảnh không được thêm vào");
            // dd()
            return Redirect()->back();
        }
        $product_new->save();
        $this->message("success", "Đã Thêm Sản Phẩm Thành Công");
        return Redirect('admin/product/all-product');
    }

    public function edit_product(Request $request)
    {
        $product_id = $request->product_id;
        $product_old = Product::where('product_id', $product_id)->first();
        $data_category = Category::get();
        // dd($product_old);
        return view('admin.Product.edit_product')->with(compact('data_category', 'product_old'));
    }

    public function update_product(Request $request)
    {
        $data = $request->all();
        $product = Product::where('product_id', $data['product_id'])->first();
        $product['product_name'] = $data['product_name'];
        $product['category_id'] = $data['product_category'];
        $product['product_desc'] = $data['product_desc'];
        $product['product_price'] = $data['product_price'];
        unlink('public/fontend/assets/img/product/' . $product->product_image);
        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public\fontend\assets\img\product', $new_image);
            $data['product_image'] = $new_image;
            $product['product_image'] = $data['product_image'];
        }
        $product->save();
        $this->message("success", "Cập Nhật Sản Phẩm Thành Công!");
        return Redirect('admin/product/all-product');
    }

    public function un_active_product(Request $request)
    {
        $product_id = $request->product_id;
        $status = $request->status;

        $product = Product::where('product_id', $product_id)->first();

        $product->product_status = $status;
        $product->save();
    }



    /* Sort */
    public function sort_product_by_category(Request $request)
    {
        $category_id = $request->category_id;
        if ($category_id == 0) {
            $list_product = Product::get();
            $output = $this->print_list_product($list_product);
        } else {
            $list_product = Product::where('category_id', $category_id)->get();
            if (Product::where('category_id', $category_id)->first()) {
                $output = $this->print_list_product($list_product);
            } else {
                $output = '<tr>
                <th colspan="6" style="text-align: center;">Không có sản phẩm trong danh mục này</th> 
                </tr>';
            }
        }
        echo $output;
    }

    public function all_product_sreach(Request $request)
    {
        $searchbyname_format = '%' . $request->key_sreach . '%';
        $all_product = Product::where('product_name', 'like', $searchbyname_format)->get();
        $output = $this->print_list_product($all_product);
        echo $output;
    }

    public function sort_all(Request $request)
    {
        $type = $request->type;
        $check = $request->check;
        if ($check == 'false') {
            if ($type == 'product') {
                $all_product_z_a = Product::orderBy('product_name', 'DESC')->get();
                $output = $this->print_list_product($all_product_z_a);
            }
            if ($type == 'category') {
                $all_category_z_a = Product::join('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')->orderBy('tbl_category.category_name', 'DESC')->get();
                $output = $this->print_list_product($all_category_z_a);
            }
            if ($type == 'price') {
                $all_price_9_0 = Product::orderBy('product_price', 'DESC')->get();
                $output = $this->print_list_product($all_price_9_0);
            }
            if ($type == 'quantity') {
                $all_quantity_9_0 = Product::orderBy('product_unit_sold', 'DESC')->get();
                $output = $this->print_list_product($all_quantity_9_0);
            }
        } else if ($check == 'true') {
            if ($type == 'product') {
                $all_product_a_z = Product::orderBy('product_name', 'ASC')->get();
                $output = $this->print_list_product($all_product_a_z);
            }
            if ($type == 'category') {
                $all_category_a_z = Product::join('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')->orderBy('tbl_category.category_name', 'ASC')->get();
                $output = $this->print_list_product($all_category_a_z);
            }
            if ($type == 'price') {
                $all_price_0_9 = Product::orderBy('product_price', 'ASC')->get();
                $output = $this->print_list_product($all_price_0_9);
            }
            if ($type == 'quantity') {
                $all_quantity_0_9 = Product::orderBy('product_unit_sold', 'ASC')->get();
                $output = $this->print_list_product($all_quantity_0_9);
            }
        }
        echo $output;
    }

    // Xóa mềm/*  */

    public function delete_soft_product(Request $request)
    {
        $product_id = $request->product_id;
        $product_delete = Product::where('product_id', $product_id)->first();
        $product_delete->delete();
    }

    public function trash_product()
    {
        $all_product = Product::onlyTrashed()->get();
        $deleted_first = Product::onlyTrashed()->first();
        return view('admin.Product.list_delete_soft_product');
    }

    public function load_delete_soft_product()
    {
        $all_product = Product::onlyTrashed()->get();
        $deleted_first = Product::onlyTrashed()->first();

        $output = '';
        if ($deleted_first) {
            foreach ($all_product as $key => $product) {
                $output .= '
            <tr>
            <td>' . $product->product_name . ' </td>
            <td>' . $product->category->category_name . '</td>
    

            ';

                $output .= '
            <td> ' . number_format($product->product_price, 0, ',', '.') . '</td>
            <td><img style="object-fit: cover" width="40px" height="20px"
                    src="' . URL('public/fontend/assets/img/product/' . $product->product_image) . '"
                    alt=""></td>
            <td>
                ' . $product->deleted_at . '
            ';

                $output .= '  
            </td>

            <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $product->product_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $product->product_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>
            ';
            }
        } else {
            $output .= '<tr>
            <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="' . url('admin/product') . '">Quay lại danh sách sản phẩm</a></th>
        </tr>';
        }
        echo $output;
    }

    public function delete_restore_product(Request $request)
    {
        $product_id = $request->product_id;
        $type = $request->type;
        if ($type == -1) {
            $product = Product::withTrashed()->where('product_id', $product_id)->first(); // Có thể thay thế bằng find_product_byId
            // dd($product);
            $product->restore();
        } else {
            $product = Product::withTrashed()->where('product_id', $product_id)->first();
            unlink('public/fontend/assets/img/product/' . $product->product_image);
            $product->forceDelete();
        }
    }

    public function count_delete()
    {
        $products_trash = Product::onlyTrashed()->get();
        $countDelete = $products_trash->count();
        $output = '';
        if ($countDelete > 0) {
            $output .= '(' . $countDelete . ')';
        }
        echo $output;
    }



    /* Gallery */

    public function insert_gallery(Request $request)
    {
        /* Bên kia input name="file[]" nên gửi qua là 1 mảng chứa toàn bộ ảnh , sử dụng dd() để rõ hơn*/
        $product_id = $request->product_id;
        $get_images = $request->file('file');

        if ($get_images) {
            foreach ($get_images as $get_image) {
                $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $get_image->move('public\fontend\assets\img\product', $new_image);

                $gallery = new GalleryProduct();
                $gallery['product_id'] = $product_id;
                // $gallery['gallery_product_name'] = $image_name;
                $gallery['gallery_image_product'] = $new_image;
                // $gallery['gallery_product_content'] = "Ảnh này chưa có nội dung !";
                $gallery->save();
            }
        }
        return redirect()->back();
    }

    public function loading_gallery(Request $request)
    {
        $product_id = $request->product_id;

        $gallery_image = GalleryProduct::where('product_id', $product_id)->get();
        $output = '';
        $i = 0;
        if (GalleryProduct::where('product_id', $product_id)->first()) {
            foreach ($gallery_image as $key => $image) {
                $i++;
                $output .= ' <tr>
                <td>' . $i . '</td>
                <td contenteditable class="edit-content" data-type="Tên Ảnh" data-gallery_id="' . $image->gallery_id . '">' . $image->gallery_image_name . ' </td>
                <td>
                <form>
                ' . csrf_field() . '
                <input hidden id="up_load_file' . $image->gallery_id . '" class="up_load_file"  type="file" name="file_image" accept="image/*" data-gallery_id = "' . $image->gallery_id . '">
                <label class="up_load_file" for="up_load_file' . $image->gallery_id . '" > <img style="object-fit: cover" width="40px" height="20px"
                src="' . URL('public/fontend/assets/img/product/' . $image->gallery_image_product) . '" alt=""></label>
                </form> 
                </td>
                <td contenteditable class="edit-content" data-gallery_id="' . $image->gallery_id . '" data-type="Nội Dung Ảnh">' . $image->gallery_image_content . '</td>
                <td>    
                  
                    <button type="button" class="btn btn-inverse-danger btn-icon delete_gallery_product" data-gallery_id = "' . $image->gallery_id . '"><i style="font-size: 22px" class="mdi mdi-delete-sweep text-danger "></i></button>
                </td>
                </tr>';
            }
        } else {
            $output .= ' <tr>
                <td colspan="5">Không có ảnh minh họa cho sản phẩm này</td></tr>';
        }
        echo $output;
    }

    public function update_image_gallery(Request $request)
    {
        $gallery_id = $request->gallery_id;
        $get_image = $request->file('file');
        $image = GalleryProduct::where('gallery_id', $gallery_id)->first();
        unlink('public/fontend/assets/img/product/' . $image->gallery_image_product);
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/fontend/assets/img/product', $new_image);
            $gallery = GalleryProduct::where('gallery_id', $gallery_id)->first();
            // echo $gallery->gallery_product_image;
            //unlink('public/fontend/assets/img/product/', $gallery->gallery_product_image); /* Xóa ảnh ở trong thư mục */
            $gallery['gallery_image_product'] = $new_image;
            $gallery->save();
        }
    }

    public function update_content_gallery(Request $request)
    {
        $gallery_id = $request->gallery_id;
        $gallery_text = $request->gallery_content;
        $type = $request->type;
        $gallery_image = GalleryProduct::where('gallery_id', $gallery_id)->first();
        if ($type == "Tên Ảnh") {
            $gallery_image['gallery_image_name'] = $gallery_text;
        } else if ($type == "Nội Dung Ảnh") {
            $gallery_image['gallery_image_content'] = $gallery_text;
        }
        $gallery_image->save();
    }

    public function delete_gallery(Request $request)
    {
        $gallery_id = $request->gallery_id;
        $gallery_product = GalleryProduct::where('gallery_id', $gallery_id)->first();
        $gallery_product->delete();
    }





    /* Chi tiết sản phẩm */

    // Route::get('/san-pham-chi-tiet', [ProductController::class, 'san_pham_chi_tiet']);
    public function san_pham_chi_tiet(Request $request){
        $product_id = $request->product_id;
        // Lấy sản phẩm đó
        $product = Product::where('product_id', $product_id)->first();
        //check sản phẩm có nằm trong flashsale hay không
        $checkflashsale = $product->flashsale_status;
        if($checkflashsale == 1){
            $product_flashsale = Flashsale::where('product_id', $product_id)->first();

            return Redirect('/san-pham/san-pham-chi-tiet-flash-sale?flashsale_id='.$product_flashsale->flashsale_id.'');
        }

        // $flashsale_product = Flashsale::join('tbl_product', 'tbl_product.product_id', '=', )
        // Lấy sản phẩm flashsale của danh mục đó
        $flashsale_product = Product::with('flashsale')->where('flashsale_status', 1)->where('category_id', $product->category_id)->whereNotIn('product_id', [$product_id])->get();
        
        // Lấy size
        $sizes = ProductType::get();
        // Lấy ảnh của sản phẩm đó
        $gallery = GalleryProduct::where('product_id', $product_id)->get();
        // Lấy sản phẩm cùng danh mục 
        $product_category = Product::where('category_id', $product->category_id)->whereNotIn('product_id', [$product->product_id])->where('flashsale_status', 0)->get();
        
     
        
        $data = array();
        $data['product_id'] = $product_id;
        $data['product_name'] = $product->product_name;
        $data['product_image'] = $product->product_image;
        $data['category_name'] = $product->category->category_name;
        $this->Recentlyviewed($data);
        
        
        
        return view('pages.home.sanphamchitiet')->with(compact('product', 'sizes', 'gallery', 'product_category', 'flashsale_product'));
    }

    public function san_pham_chi_tiet_flash_sale(Request $request){
        $flashsale_id = $request->flashsale_id;

        //lấy sản phẩm của flashsale
        $flashsale = Flashsale::where('flashsale_id', $flashsale_id)->first();
        $product = Product::where('product_id', $flashsale->product_id)->first(); 

        // Lấy sản phẩm flashsale của danh mục đó
        $flashsale_product = Product::with('flashsale')->where('flashsale_status', 1)->where('category_id', $product->category_id)->whereNotIn('product_id', [$product->product_id])->get();
        
        //lấy ảnh của sản phẩm
        $gallery = GalleryProduct::where('product_id', $flashsale->product_id)->get();
        //lấy sản phẩm trong danh mục
        $product_category = Product::where('category_id', $product->category_id)->whereNotIn('product_id', [$product->product_id])->where('flashsale_status', 0)->get();
        //lấy size của sản phẩm
        $sizes = ProductType::get();

        $data = array();
        $data['product_id'] = $flashsale->product_id;
        $data['product_name'] = $product->product_name;
        $data['product_image'] = $product->product_image;
        $data['category_name'] = $product->category->category_name;
        $this->Recentlyviewed($data);

        return view('pages.home.sanphamchitiet')->with(compact('product', 'sizes', 'gallery', 'product_category', 'flashsale', 'flashsale_product'));
    }


    public function Recentlyviewed($data){

   // - Tạo Session_ID và Mỗi recentlyviewed Sẽ Chứa 1 Session_ID riêng
        // - Đầu Tiên Lấy Toàn Bộ Dữ Liệu Card Ở Session recentlyviewed
        // - Tồn Tại recentlyviewed Thì Kiểm Tra Dữ Liệu recentlyviewed(ID Product) Đưa Xem Có Trùng Với recentlyviewed Cũ(ID Product) Không
        // - Trùng Thì Không Thêm Dữ Liệu Vào Session recentlyviewed
        // - Không Trùng Thì Thêm Dô
        // -Trường Hợp Chưa Có recentlyviewed Thì Khởi Tạo recentlyviewed[] Rồi Thêm Vào


        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $recentlyviewed = session()->get('recentlyviewed');
        if ($recentlyviewed == true) {
            $is_avaiable = 0;
            foreach ($recentlyviewed as $key => $value) {
                if ($value['product_id'] == $data['product_id']) {
                    $is_avaiable++;
                }
            }
            if ($is_avaiable == 0) {
                $recentlyviewed[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['product_id'],
                    'product_name' => $data['product_name'],
                    'product_image' => $data['product_image'],
                    'category_name' => $data['category_name'],

                );
                session()->put('recentlyviewed', $recentlyviewed);
            }
        } else {
            $recentlyviewed[] = array(
                'session_id' => $session_id,
                'product_id' => $data['product_id'],
                'product_name' => $data['product_name'],
                'product_image' => $data['product_image'],
                'category_name' => $data['category_name'],
            );
        }
        session()->put('recentlyviewed', $recentlyviewed);
        session()->save();
    }



    public function message($type, $content)
    {
        $message = array(
            "type" => $type,
            "content" => $content,
        );
        session()->put('message', $message);
    }
}
