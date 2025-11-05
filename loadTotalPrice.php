<?php
include('userfunction/myfunction.php');

$total_price = 0;

$result = fetchcartitemsbycartid('tbl_cart', $cartID);

if ($result && mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_price += $row['ProductPrice'] * $row['Quantity'];
    }
}

$response = [
    'total_price' => $total_price // RAW number, NOT formatted!
];

header('Content-Type: application/json');
echo json_encode($response);
exit;
