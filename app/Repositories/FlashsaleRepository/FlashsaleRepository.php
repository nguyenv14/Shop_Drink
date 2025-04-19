<?php
namespace App\Repositories\FlashsaleRepository;

use App\Models\Flashsale;
use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\FlashsaleRepository\FlashsaleInterfaceRepository;

class FlashsaleRepository extends BaseRepository implements FlashsaleInterfaceRepository
{
    public function getModel()
    {
        return \App\Models\Flashsale::class;
    }

    function getAllByPaginate()
    {
        $flashsales = $this->model->where("deleted_at", 0)->paginate(4);
        return $flashsales;
    }

    function saveProductToFlashsale($data)
    {
        $product = Product::where('product_id', $data['product_id'])->first();
        $product_price = $product['product_price']; // Số tiền gốc
        
        $product_flashsale = new Flashsale();
        $product_flashsale['product_id'] = $data['product_id'];
        $product_flashsale['flashsale_condition'] = $data['flashsale_condition']; // loại giảm giá
        $product_flashsale['flashsale_percent'] = $data['flashsale_percent']; // mức giảm
        $product_flashsale['flashsale_status'] = $data['flashsale_status'];
        if($data['flashsale_condition'] == 0){
            $product_flashsale['flashsale_price_sale'] =  $product_price - ( $product_price / 100 ) *  $data['flashsale_percent'];
        }else{
            $product_flashsale['flashsale_price_sale'] = $product_price - $data['flashsale_percent'];
        }

        $product['flashsale_status'] = 1;
        $product_flashsale['deleted_at'] = 0;

        $product->save();
        $product_flashsale->save();
    }

    function getFlashsaleId($id)
    {
        $flashsale = $this->find($id);
        return $flashsale;
    }

    function getFlashsaleByProduct($productId){
        $flashsale = $this->model->where("product_id", $productId)->first();
        return $flashsale;
    }

    function updateFlashsale($data)
    {
        $product = Product::where('product_id', $data['product_id'])->first();
        $product_price = $product['product_price']; // Số tiền gốc
        $flashsale =  Flashsale::where('flashsale_id', $data['flashsale_id'])->first();
        $flashsale['flashsale_condition'] =  $data['flashsale_condition'];
        $flashsale['flashsale_percent'] =  $data['flashsale_percent'];
        
        if($data['flashsale_condition'] == 0){
            $flashsale['flashsale_price_sale'] =  $product_price - ( $product_price / 100 ) *  $data['flashsale_percent'];
        }else{
            $flashsale['flashsale_price_sale'] = $product_price - $data['flashsale_percent'];
        }
        $flashsale->save();
    }

    function unActiveFlashsale($id, $status)
    {
        $flashsale = $this->find($id);
        $product = Product::where('product_id', $flashsale['product_id'])->first();

        $product->flashsale_status = $status;
        $flashsale->flashsale_status = $status;
        $product->save();
        $flashsale->save();
    }

    function deleteFlashsale($id)
    {
        $flashsale = $this->find($id);
        $product = Product::where('product_id', $flashsale['product_id'])->first();
        
        $this->delete($id);
        $product['flashsale_status'] = 0;
        $product->save();
    }
}