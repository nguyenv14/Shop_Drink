<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đơn Hàng Của Bạn !</title>
</head>
<body>
   BonoDrinks Xin Chào {{  $order->shipping->shipping_name }}! <br>
   <b style="color:#57ccff;"> {{ $type }}  </b>  <br>

   @if ($order->order_status == 1)
    <h3>Mặt hàng</h3>
    <table border="2" style="border-collapse: collapse;">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành Tiền</th>
        </tr>
        <?php $total_price = 0 ?>
        @foreach ($orderdetails as $order_product)
           <tr>
            <td>{{ $order_product->product_name }}</td>
            <td>{{ $order_product->product_sales_quantity }}</td>
            <td>{{ number_format($order_product->product_price, 0, ',','.') }}đ</td>
            <td>{{ number_format($order_product->product_sales_quantity * $order_product->product_price, 0, ',','.') }}đ</td>
            <?php $total_price = $total_price + $order_product->product_price * $order_product->product_sales_quantity; ?>
           </tr>
        @endforeach
    </table>
    <?php
    $fee_ship = $order->product_fee;
                    $coupon_sale = 0;
                    if($coupon){
                        if($coupon->coupon_condition == 1){
                            $coupon_sale = ($total_price / 100) * $coupon->coupon_price_sale;
                        }else{
                            if($coupon->coupon_price_sale > $total_price){
                                $coupon_sale = $total_price;
                            }else{
                                $coupon_sale = $coupon->coupon_price_sale;
                            }
                        }
                    }else{
                        $coupon_sale = 0;
                    }
    ?>
    <h3>Phí ship: {{ number_format($order->product_fee, 0, ',', '.') }}đ</h3>
    <h3>Mã giảm giá: {{ $order->product_coupon }} <?php if($coupon){ echo ' - '.number_format($coupon_sale, 0,',','.').'đ'; } ?></h3>  
    <h3>Tổng tiền: {{ number_format($total_price + $fee_ship - $coupon_sale, 0, ',','.') }}đ </h3>
   @endif
   Xin Cảm Ơn !
</body>
</html>