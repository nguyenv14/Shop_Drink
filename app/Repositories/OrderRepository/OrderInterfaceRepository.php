<?php
namespace App\Repositories\OrderRepository;

use App\Repositories\RepositoryInterface;

interface OrderInterfaceRepository extends RepositoryInterface
{
    function getListOrderDesc();
    function filterOrder($order_status);
    function getOrderByCode($order_code);
    function getOrderByStatus($order_status);
    function getOrderById($order_id);
    function getOrderListByUser($customer_id);

    function getPaymentId($payment_id);
    function getCustomerId($customer_id);
    function getOrderDetail($order_code);
    function getShippingId($shipping_id);
}