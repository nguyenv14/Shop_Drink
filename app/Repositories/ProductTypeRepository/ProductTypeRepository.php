<?php
namespace App\Repositories\ProductTypeRepository;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductType;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ProductTypeRepository extends BaseRepository implements ProductTypeInterfaceRepository{
    function getModel()
    {
        return \App\Models\ProductType::class;
    }

    function getAllProductType()
    {
        $allItem = $this->model->get();
        return $allItem;
    }

    function getProductTypeList()
    {
        $allItem = $this->model->get();
        return $allItem;
    }

    function getProductTypeId($id)
    {
        $product_type = $this->find($id);
        return $product_type;
    }

    function saveProductType($data)
    {
        $this->create($data);
    }

    function updateProductType($data)
    {
        $id = $data['product_type_id'];
        $this->update($id, $data);
    }

    function unActiveProductType($id, $status)
    {
        $product_type = ProductType::where('product_type_id', $id)->first();

        $product_type->product_type_status = $status;
        $product_type->save();
    }

    function getTrashProductType()
    {
        $all_product_types_delete = ProductType::onlyTrashed()->get();
        return $all_product_types_delete;
    }

    function deleteProductType($id)
    {
        $this->delete($id);
    }

    function deleteOrRestoreProductType($id, $type)
    {
        $product_type = ProductType::withTrashed()->where('product_type_id', $id)->first();
        if($type == -1){
            $product_type->restore();
        }else{
            $product_type->forceDelete();
        }
    }
}
