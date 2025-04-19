<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flashsale;
use App\Models\GalleryProduct;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slider;
use App\Repositories\CategoryRepository\CategoryInterfaceRepository;
use App\Repositories\FlashsaleRepository\FlashsaleInterfaceRepository;
use App\Repositories\GalleryProductRepository\GalleryProductInterfaceRepository;
use App\Repositories\ProductRepository\ProductInterfaceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Pagination\Paginator;

session_start();
class ProductController extends Controller
{
    

    protected $productRepository;
    protected $galleryRepository;
    protected $flashsaleRepository;

    public function __construct(ProductInterfaceRepository $productInterfaceRepository, GalleryProductInterfaceRepository $galleryProductInterfaceRepository, FlashsaleInterfaceRepository $flashsaleInterfaceRepository)
    {
        $this->productRepository = $productInterfaceRepository;
        $this->galleryRepository = $galleryProductInterfaceRepository;
        $this->flashsaleRepository = $flashsaleInterfaceRepository;
    }

    public function getProductId(Request $request){
        $product = $this->productRepository->getProductId($request->product_id);
    }

    public function all_product()
    {
        $all_product = $this->productRepository->getAllByPaginate();
        $data_category = Category::where("category_status", 1)->get();
        return view('admin.Product.all_product')->with(compact('all_product', 'data_category'));
    }

    public function product_detail(Request $request)
    {
        $product_id = $request->product_id;
        $product = $this->productRepository->getProductId($product_id);
        return view('admin.Product.productdetails')->with(compact('product'));
    }

    public function load_product()
    {
        $all_product = $this->productRepository->getAllByPaginate();
        $output = $this->print_list_product($all_product);
        echo $output;
    }

    public function print_list_product($list_product)
    {
        $output = '';
        if($list_product->count() > 0){
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
                        <i style="color: rgb(52, 211, 52); font-size: 30px" class="mdi mdi-toggle-switch btn-un-active" data-product_id="' . $product->product_id . '" data-status="0"></i>';
                } else {
                    $output .= '
                        <i style="color: rgb(196, 203, 196); font-size: 30px" class="mdi mdi-toggle-switch-off btn-un-active" data-product_id="' . $product->product_id . '" data-status="1"></i>';
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
                </tr>';
            }
        }else{
            $output = '<tr>
            <th colspan="6" style="text-align: center;">Không có sản phẩm nào</th> 
            </tr>';
        }
        return $output;
    }

    public function add_product()
    {
        $data_category = Category::get();
        return view('admin.Product.add_product')->with(compact('data_category'));
    }

    public function save_product(Request $request)
    {
        $result = $this->productRepository->insertProduct($request->all(), $request->file('product_image'));
        if($result == true){
            $this->message("success", "Tạo sản phẩm mới thành công!");
        }else{
            $this->message("error", "Lỗi sản phẩm trùng tên, vui lòng đặt tên khác!");
        }
        return Redirect('admin/product/all-product');
    }

    public function edit_product(Request $request)
    {
        $product_id = $request->product_id;
        $product_old = $this->productRepository->getProductId($product_id);
        $data_category = Category::get();
        return view('admin.Product.edit_product')->with(compact('data_category', 'product_old'));
    }

    public function update_product(Request $request)
    {
        $this->productRepository->updateProduct($request->all(), $request->file('product_image'));
        $this->message("success", "Cập Nhật Sản Phẩm Thành Công!");
        return Redirect('admin/product/all-product');
    }

    public function un_active_product(Request $request)
    {
        $product_id = $request->product_id;
        $status = $request->status;
        $this->productRepository->unActiveProduct($product_id, $status);
    }

    /* Sort */
    public function sort_product_by_category(Request $request)
    {
        $category_id = $request->category_id;
        $list_product = $this->productRepository->filterProductByCategory($category_id);
        if($list_product->count() > 0){
            $output = $this->print_list_product($list_product);
        }else{
            $output = '<tr>
            <th colspan="6" style="text-align: center;">Không có sản phẩm trong danh mục này</th> 
            </tr>';
        }
        return $output;
    }

    public function all_product_sreach(Request $request)
    {
        $searchbyname_format = '%' . $request->key_sreach . '%';
        $all_product = $this->productRepository->searchProduct($searchbyname_format);
        $output = $this->print_list_product($all_product);
        echo $output;
    }

    public function sort_all(Request $request)
    {
        $type = $request->type;
        $check = $request->check;
        $all_product = $this->productRepository->filterAll($type, $check);
        return $this->print_list_product($all_product);
    }

    // Xóa mềm/*  */

    public function delete_soft_product(Request $request)
    {
        $product_id = $request->product_id;
        $this->productRepository->deleteProduct($product_id);
    }

    public function trash_product()
    {
        return view('admin.Product.list_delete_soft_product');
    }

    public function load_delete_soft_product()
    {
        $all_product = $this->productRepository->getBinProduct();
        $output = '';
        if ($all_product->count() > 0) {
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
            <td>' . $product->deleted_at . '';
                $output .= '  
            </td>
            <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $product->product_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $product->product_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>';
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
        $this->productRepository->deleteAndRestore($product_id, $type);
    }

    public function count_delete()
    {
        $products_trash = $this->productRepository->getBinProduct();
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
        $this->galleryRepository->insertGallery($product_id, $get_images);
        return redirect()->back();
    }

    public function loading_gallery(Request $request)
    {
        $product_id = $request->product_id;

        $gallery_image = $this->galleryRepository->getGallery($product_id);
        $output = '';
        $i = 0;
        if ($gallery_image->count() > 0) {
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
        $this->galleryRepository->updateImageGallery($gallery_id, $get_image);
    }

    public function update_content_gallery(Request $request)
    {
        $this->galleryRepository->updateContentGallery($request->gallery_id, $request->gallery_content, $request->type);
    }

    public function delete_gallery(Request $request)
    {
        $this->galleryRepository->deleteGallery($request->gallery_id);
    }

    /* Chi tiết sản phẩm */
    public function san_pham_chi_tiet(Request $request){
        $product_id = $request->product_id;
        $product = $this->productRepository->getProductId($product_id);
        $checkflashsale = $product->flashsale_status;
        if($checkflashsale == 1){
            $product_flashsale = $this->flashsaleRepository->getFlashsaleByProduct($product_id);
            return Redirect('/san-pham/san-pham-chi-tiet-flash-sale?flashsale_id='.$product_flashsale->flashsale_id.'');
        }
        $sizes = ProductType::get();
        $gallery = $this->galleryRepository->getGallery($product_id);
        $product_category = Product::where('category_id', $product->category_id)->whereNotIn('product_id', [$product->product_id])->get();
        
        $data = array();
        $data['product_id'] = $product_id;
        $data['product_name'] = $product->product_name;
        $data['product_image'] = $product->product_image;
        $data['category_name'] = $product->category->category_name;
        $this->Recentlyviewed($data);
        
        return view('pages.home.sanphamchitiet')->with(compact('product', 'sizes', 'gallery', 'product_category'));
    }

    public function san_pham_chi_tiet_flash_sale(Request $request){
        $flashsale_id = $request->flashsale_id;
        $flashsale = $this->flashsaleRepository->getFlashsaleId($flashsale_id);
        $product = $this->productRepository->getProductId($flashsale->product_id);
        $gallery = $this->galleryRepository->getGallery($flashsale->product_id);
        $product_category = Product::where('category_id', $product->category_id)->whereNotIn('product_id', [$product->product_id])->get();
        $sizes = ProductType::get();
        $data = array();
        $data['product_id'] = $flashsale->product_id;
        $data['product_name'] = $product->product_name;
        $data['product_image'] = $product->product_image;
        $data['category_name'] = $product->category->category_name;
        $this->Recentlyviewed($data);

        return view('pages.home.sanphamchitiet')->with(compact('product', 'sizes', 'gallery', 'product_category', 'flashsale'));
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
