<?php
namespace App\Repositories\ProductRepository;

use App\Models\Flashsale;
use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\ProductRepository\ProductInterfaceRepository;

class ProductRepository extends BaseRepository implements ProductInterfaceRepository
{
    public function getModel()
    {
        return \App\Models\Product::class;
    }
    
    public function getAllByPaginate()
    {
        $all_products = $this->model->paginate(5);
        return $all_products;
    }

    public function getProductId($id)
    {
        $product = $this->find($id);
        return $product;
    }

    public function getProduct()
    {
        $all_product = $this->model->get();
        return $all_product;
    }

    public function insertProduct($data, $get_image)
    {
        $product = $this->model->where('product_name', 'like', '%'.$data['product_name'].'%')->first();
        if($product){
            return false;
        }else{
            unset($data['_token']);
            if ($get_image != null) {
                $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $get_image->move('public\fontend\assets\img\product', $new_image);
                $data['product_image'] = $new_image;
            } 
            $this->create($data);
            return true;
        }
    }

    public function updateProduct($data, $get_image)
    {
        unset($data['_token']);
        if ($get_image != null) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */ 
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public\fontend\assets\img\product', $new_image);
            $data['product_image'] = $new_image; 
        }
        $this->update($data['product_id'] , $data);
    }

    public function deleteProduct($id)
    {
        $flashsale = Flashsale::where("product_id", $id)->first();
        if($flashsale){
            $flashsale->deleted_at = 1;
            $flashsale->save();
        }
        $this->delete($id);
    }

    public function unActiveProduct($id, $status)
    {
        $product = $this->find($id);
        $product->product_status = $status;
        $product->save();
        // return $status;
    }

    public function getBinProduct()
    {
        $all_product_delete = $this->model->onlyTrashed()->get();
        return $all_product_delete;
    }

    public function deleteAndRestore($id, $type)
    {
        $product_deleted = $this->model->onlyTrashed()->find($id);
        $flashsale = Flashsale::where("product_id", $id)->first();
        if($type == -1){
            if($flashsale){
                $flashsale->deleted_at = 0;
                $flashsale->save();
            }
            $product_deleted->restore();
        }else{
            if($flashsale){
                $flashsale->delete();
            }
            unlink('public/fontend/assets/img/product/' . $product_deleted->product_image);
            $product_deleted->forceDelete();
        }
    }

    public function searchProduct($searchText)
    {
        $all_product = $this->model->where("product_name", "like", $searchText)->get();
        return $all_product;
    }

    public function filterProductByCategory($category_id)
    {
        // $list_product = 
        if($category_id == 0){
            $list_product = $this->model->get();
        }else{
            $list_product = $this->model->where("category_id", $category_id)->get();
        }
        return $list_product;
    }

    public function filterAll($type, $check)
    {
        if ($check == 'false') {
            if ($type == 'product') {
                $all_product = Product::orderBy('product_name', 'DESC')->get();
            }
            if ($type == 'category') {
                $all_product = Product::join('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')->orderBy('tbl_category.category_name', 'DESC')->get();
            }
            if ($type == 'price') {
                $all_product = Product::orderBy('product_price', 'DESC')->get();
            }
            if ($type == 'quantity') {
                $all_product = Product::orderBy('product_unit_sold', 'DESC')->get();
            }
        } else if ($check == 'true') {
            if ($type == 'product') {
                $all_product = Product::orderBy('product_name', 'ASC')->get();
            }
            if ($type == 'category') {
                $all_product = Product::join('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')->orderBy('tbl_category.category_name', 'ASC')->get();
            }
            if ($type == 'price') {
                $all_product = Product::orderBy('product_price', 'ASC')->get();
            }
            if ($type == 'quantity') {
                $all_product = Product::orderBy('product_unit_sold', 'ASC')->get();
            }
        }
        return $all_product;
    }

    

}   
