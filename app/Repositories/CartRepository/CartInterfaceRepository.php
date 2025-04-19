<?php
namespace App\Repositories\CartRepository;

use App\Repositories\RepositoryInterface;

interface CartInterfaceRepository extends RepositoryInterface
{
    function showCart();
    function saveCart($product_id, $product_qty, $product_type);
    function deleteCart($id);
    function deleteAllCart();
    function getListCart();
    function updateQuantityCart($id, $quantity);
    function updateSizeCart($row_id, $size_id, $product_id, $quantity);
    function calculateFee($data);
    function confirmCart($shipping_name, $shipping_phone, $shipping_email, $shipping_home_number);
}