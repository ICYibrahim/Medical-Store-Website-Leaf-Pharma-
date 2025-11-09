<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;

$result = fetchtablewithlimit($limit, $offset, 'tbl_orders');
if ($result === false) {
    echo json_encode(['error' => 'Query failed']);
    exit;
}

$output = '';

if (mysqli_num_rows($result) > 0) {
    $ctr = 1 + $offset;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['order_id'];

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

// ✅ Get total records for pagination — safe fallback
$total_result = fetchtable('tbl_orders');
$total_records = ($total_result) ? mysqli_num_rows($total_result) : 0;
$total_pages = ($total_records > 0) ? ceil($total_records / $limit) : 1;

header('Content-Type: application/json');
echo json_encode([
    'html' => $output,
    'total_pages' => $total_pages,
    'total_products' => $total_records,
    'current_page' => $page
]);
