<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository\CategoryInterfaceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;



// use App\Repositories\CategoryRepository\CategoryRepositoryInterface;

// use Session;

session_start();
class CategoryController extends Controller
{

    /**
     * @var PostRepositoryInterface|\App\Repositories\Repository
     */
    protected $categoryRepository;
    public function __construct(CategoryInterfaceRepository $categoryInterfaceRepository)
    {
        $this->categoryRepository = $categoryInterfaceRepository;
    }

    public function all_category(){
        $all_category = $this->categoryRepository->getAllByPaginate(5);
        return view('admin.Category.all_category')->with('all_category', $all_category);
    }

    public function add_category(){
        return view('admin.Category.add_category'); 
    }

    public function save_category(Request $request){
        $result = $this->categoryRepository->insertCategory($request->all());
        if($result == true){
            $this->message("success", "Thêm danh mục mới thành công!");
            return Redirect('admin/category/all-category');
        }else{
            $this->message("warning", "Tên của danh mục bị trùng, vui lòng đổi tên khác!");
            return Redirect('admin/category/all-category');
        }
    }

    public function edit_category(Request $request){
        $category_old = $this->categoryRepository->findCategoryId($request->category_id);
        return view('admin.Category.edit_category')->with('category_old', $category_old);
    }

    public function update_category(Request $request){
        $this->categoryRepository->updateCategory($request->all());
        return Redirect('admin/category/all-category');
    }

    public function load_category(){
        $all_category = Category::paginate(5);
        $output = '';
        foreach($all_category as $key => $category){
            $output .= '<tr>
                <td>'. $category->category_id .'</td>
                <td>'. $category->category_name .'</td>
                <td>'. $category->category_desc .'</td>
                <td>';
                if ($category->category_status == 1){       
                    $output .='  <i style="color: rgb(52, 211, 52); font-size: 30px" class="mdi mdi-toggle-switch btn-un-active" data-category_id="'.$category->category_id.'" data-status="0"></i>';
                }else{
                    $output .=' <i style="color: rgb(196, 203, 196);font-size: 30px" class="mdi mdi-toggle-switch-off btn-un-active" data-category_id="'.$category->category_id.'" data-status="1"></i>';
                }
                    $output .=' </td>
                <td>'.$category->created_at.'</td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-category" data-delete_id="' . $category->category_id . '"><i class="mdi mdi-delete" ></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon"><a href="'.url('admin/category/edit-category?category_id=' . $category->category_id) . '"><i class="mdi mdi-lead-pencil"></i></a></button>  
            </td> </tr>';
        }
        echo $output;
    }

    public function un_active_category(Request $request){
        $category_id = $request->category_id;
        $status = $request->status;
        $result = $this->categoryRepository->un_active_category($category_id, $status);
        return $result;
    }


    /* Xóa mềm */

    public function trash_category(){
        return view('admin.Category.list_delete_soft_category');
    }


    public function delete_soft_category(Request $request){
        $result = $this->categoryRepository->deleteCategory($request->category_id);
        return $result;
    }

    public function load_delete_soft_category(){
        $all_categorys_delete = $this->categoryRepository->getBin();
        // Category::onlyTrashed()->get();
        $output = '';
        if($all_categorys_delete->count() > 0){
            // dd($all_category_delete_soft);
            foreach ($all_categorys_delete as $key => $category) {
                $output .= '<tr>
                <td>' . $category->category_id . '</label>
                </td>
                <td>' . $category->category_name . '</td>
                <td>' . $category->category_desc . '</td>
                <td>';
                
                $output .= ' '.$category->deleted_at.' </td>

                <td>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-restore" data-restore_id="' . $category->category_id . '" data-delete_id="-1"><i class="mdi mdi-keyboard-return"></i></button>
                <button type="button" class="btn btn-inverse-danger btn-icon btn-delete-force" data-delete_id="' . $category->category_id . '" data-restore_id="0"><i class="mdi mdi-delete-forever" ></i></button>
                </td>
            </tr>';
            }
        }else{
            // dd('hii');
            $output .= '<tr>
                <th colspan="6" style="text-align: center;">Thùng rác trống.<a href="'.url('admin/category').'">Quay lại danh sách category</a></th>
            </tr>';
        }
        echo $output;
    }

    public function delete_restore_category(Request $request){
        $category_id = $request->category_id;
        $type = $request->type;

        $this->categoryRepository->deleteAndRestore($category_id, $type);
    }

    public function count_delete(){
        $categorys_trash = Category::onlyTrashed()->get();
        $countDelete = $categorys_trash->count();
        // dd($countDelete);
        $output = '';
        if($countDelete > 0){
            $output .= '('.$countDelete.')';
        }
        echo $output;
    }

    public function message($type,$content){
        $message = array(
            "type" => $type,
            "content" => $content,
        ); 
        session()->put('message', $message);
    }

}
