<?php
namespace App\Repositories\CategoryRepository;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository\CategoryInterfaceRepository;

class CategoryRepository extends BaseRepository implements CategoryInterfaceRepository
{
    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function getAllByPaginate($value)
    {
        return $this->model->paginate($value);
    }

    public function insertCategory($data)
    {
        $category_old = $this->model->where('category_name', 'like', '%'.$data["category_name"].'%')->first();
        if($category_old){
            return false;
        }else{
            $this->create($data);
            return true;
        }
    }

    public function updateCategory($data)
    {
        $category = $this->model->find($data['category_id']);

        $category->category_id = $data['category_id'];
        $category->category_name = $data['category_name'];
        $category->category_desc = $data['category_desc'];
        // $category->category_status = $data['category_status'];
        $category->save();
    }

    public function deleteCategory($id)
    {
        $product = Product::where("category_id", $id)->first();
        if($product){
            return false;
        }else{
            $this->delete($id);
            return true;
        }
    }

    public function findCategoryId($id)
    {
        $category = $this->find($id);
        return $category;
    }

    public function un_active_category($id, $status)
    {
        $product = Product::where("category_id", $id)->first();
        if($product){
            return false;
        }else{
            $category = $this->find($id);
            $category->category_status = $status;
            $category->save();
            return true;
        }
    }

    public function getBin()
    {
        $all_category = $this->model->onlyTrashed()->get();
        return $all_category;
    }

    public function deleteAndRestore($id, $type)
    {
        $category = $this->model->onlyTrashed()->find($id);
        if($type == -1){
            $category->restore();
        }else{
            $category->forceDelete();
        }
    }
}