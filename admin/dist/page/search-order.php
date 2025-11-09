<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$search = mysqli_real_escape_string($conn, $_POST['search'] ?? '');
$output = '';

$result = liveSearchOrders($search,'tbl_orders');


if (mysqli_num_rows($result) > 0) {
    $ctr = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['order_id'];
        //$product_image = $row['ProductImage'];

        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . $id . '</td>';
        $output .= '<td>' . htmlspecialchars($row['customer_name']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['shipping_address']) . '</td>';
        $price = is_numeric($row['grand_total_amount']) ? (float)$row['grand_total_amount'] : 0;
        $output .= '<td>' . number_format($price, 2) . ' -Rs</td>';
        
        $output .= '<td>' . htmlspecialchars($row['payment_method']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['order_date']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['status']) . '</td>';
        $output .= '<td>
            <a href="update-products.php?id=' . $id . '" class="btn btn-success m-md-2">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <button class="btn btn-danger remove-btn-js m-md-2" data-id="' . $id . '>
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>';
        $output .= '</tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}

echo $output;
