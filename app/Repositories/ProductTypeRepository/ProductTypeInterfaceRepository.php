<?php
namespace App\Repositories\ProductTypeRepository;

use App\Repositories\RepositoryInterface;

interface ProductTypeInterfaceRepository extends RepositoryInterface
{
    function getAllProductType();
    function getProductTypeId($id);
    function getProductTypeList();
    function saveProductType($data);
    function updateProductType($data);
    function unActiveProductType($id, $status);
    function deleteProductType($id);
    function deleteOrRestoreProductType($id, $type);
    function getTrashProductType();
}