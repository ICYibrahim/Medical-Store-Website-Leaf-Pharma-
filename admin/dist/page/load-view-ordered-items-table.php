<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');
// Check ID and return JSON error if invalid
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $order_id_js = (int)$_POST['id'];
} else {
    echo json_encode(['error' => 'Invalid order ID']);
    exit;
}
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;

$result = fetchtablebyorderidwithlimit($limit, $offset, $order_id_js,'tbl_order_items');
if ($result === false) {
    echo json_encode(['error' => 'Query failed']);
    exit;
}

$output = '';

if (mysqli_num_rows($result) > 0) {
    $ctr = 1 + $offset;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['order_id'];
        $quantity = (int)$row['quantity'];
        
        // Professional quantity display with styling
        $quantity_badge = '';
        if ($quantity == 0) {
            $quantity_badge = '<span class="badge bg-secondary">0</span>';
        } elseif ($quantity <= 5) {
            $quantity_badge = '<span class="badge bg-warning text-dark">' . $quantity . '</span>';
        } elseif ($quantity <= 20) {
            $quantity_badge = '<span class="badge bg-info">' . $quantity . '</span>';
        } else {
            $quantity_badge = '<span class="badge bg-success">' . $quantity . '</span>';
        }

        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . $id . '</td>';
        $output .= '<td>' . htmlspecialchars($row['product_name']) . '</td>';
        $output .= '<td class="text-center">';
        $output .= '<div class="d-flex align-items-center justify-content-center gap-2">';
        $output .= $quantity_badge;
        $output .= '<small class="text-muted">units</small>';
        $output .= '</div>';
        $output .= '</td>';
        $output .= '<td class="text-end">' . number_format($row['unit_price'], 2) . '</td>';
        $output .= '<td class="text-end fw-bold">' . number_format($row['S_product_total_price'], 2) . '</td>';
        $output .= '</tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="6" class="text-center text-muted py-4">No products found in this order</td></tr>';
}

// ✅ FIXED: Get total records for THIS SPECIFIC ORDER only
$total_result = fetchorderitemtable('tbl_order_items',$order_id_js); // You'll need this function
$total_records = ($total_result) ? mysqli_num_rows($total_result) : 0;
$total_pages = ($total_records > 0) ? ceil($total_records / $limit) : 1;

header('Content-Type: application/json');
echo json_encode([
    'html' => $output,
    'total_pages' => $total_pages,
    'total_products' => $total_records,
    'current_page' => $page
]);
?>