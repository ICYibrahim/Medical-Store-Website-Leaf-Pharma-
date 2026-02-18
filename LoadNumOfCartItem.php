<?php
include('userfunction/myfunction.php');
$output = "";
$counter = "";
$counter = mysqli_num_rows(fetchcartitemsbycartid('tbl_cart', $cartID));
if ($counter > 0) {
    $output .= '<span class="cartbadge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
        . $counter . '
                    <span class="visually-hidden">unread messages</span>
                </span>';
}
$respose = [
    'html' => $output,
    'total_cart_items' => $counter
];
header('Content-Type: application/json');
echo json_encode($respose);
