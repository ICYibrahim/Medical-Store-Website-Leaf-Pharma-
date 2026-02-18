<?php
include("userfunction/myfunction.php");
$result = fetchcartitemsbycartid('tbl_cart', $cartID);
$cartItems = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = [
        'ProductCode' => $row['ProductCode'],
        'ProductName' => $row['ProductName'],
        'Quantity' => $row['Quantity'],
        'ProductPrice' => $row['ProductPrice'],
        'ProductImage' => $row['ProductImage'],
    ];
}

echo json_encode($cartItems);
