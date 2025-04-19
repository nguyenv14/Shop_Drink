<?php
namespace App\Repositories\FlashsaleRepository;

use App\Repositories\RepositoryInterface;

interface FlashsaleInterfaceRepository extends RepositoryInterface
{
    function getAllByPaginate();
    function saveProductToFlashsale($data);
    function getFlashsaleId($id);
    function getFlashsaleByProduct($productId);
    function updateFlashsale($data);
    function unActiveFlashsale($id, $status);
    function deleteFlashsale($id);
}