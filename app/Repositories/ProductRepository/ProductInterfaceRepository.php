<?php
namespace App\Repositories\ProductRepository;

use App\Repositories\RepositoryInterface;

interface ProductInterfaceRepository extends RepositoryInterface
{
    public function getAllByPaginate();
    public function getProductId($id);
    public function getProduct();
    public function insertProduct($data, $get_image);
    public function updateProduct($data, $get_image);
    public function deleteProduct($id);
    public function unActiveProduct($id, $status);
    public function searchProduct($searchText);
    public function filterProductByCategory($category_id);
    public function filterAll($type, $check);

    public function getBinProduct();
    public function deleteAndRestore($id, $type);

}