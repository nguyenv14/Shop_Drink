<?php
namespace App\Repositories\CouponRepository;

use App\Repositories\RepositoryInterface;

interface CouponInterfaceRepository extends RepositoryInterface
{
    function getAllByPaginate();
    function saveCoupon($data);
    function searchCoupon($search);
    function getPriceCoupon($coupon, $total_price);
    function getCouponId($id);
    function updateCoupon($id, $data);
    function deleteSoft($id);
    

    function getCouponTrash();
    function deleteOrRestore($id, $type);
    function checkCoupon($code_sale);
}