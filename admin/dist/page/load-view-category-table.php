<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;
$categoryID = isset($_POST['categoryID']) ? (int)$_POST['categoryID'] : 0;
if ($categoryID <= 0) {
    echo json_encode(['error' => 'Invalid category ID']);
    exit;
}
$result = fetchtablebycategorywithlimit($limit, $offset, $categoryID, 'tbl_products');
if ($result === false) {
    echo json_encode(['error' => 'Query failed']);
    exit;
}

$output = '';

if (mysqli_num_rows($result) > 0) {
    $ctr = 1 + $offset;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $product_image = $row['ProductImage'];

        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ItemCode']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ItemName']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['Company']) . '</td>';

        if (!empty($row['category_id']) && $row['category_id'] !== "0") {
            $category_id = $row['category_id'];
            $data = getcategorybyid($category_id, 'tbl_category');
            $categoryrow = ($data) ? mysqli_fetch_assoc($data) : null;
            if ($categoryrow && !empty($categoryrow['category_title'])) {
                $output .= '<td>' . htmlspecialchars($categoryrow['category_title']) . '</td>';
            } else {
                $output .= '<td>Unknown Category</td>';
            }
        } else {
            $output .= '<td>No Category</td>';
        }

        $price = is_numeric($row['SPrice']) ? (float)$row['SPrice'] : 0;
        $output .= '<td>' . number_format($price, 2) . ' -Rs</td>';
        $output .= '<td>' . ($product_image != "" ? '<img class="tableimg img-fluid" src="../assets/products image/' . htmlspecialchars($product_image) . '" alt="Product image">' : 'No Image') . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ProductDiscription']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['featured']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['active']) . '</td>';
        $output .= '<td>
            <a href="update-products.php?id=' . $id . '&product_image=' . urlencode($product_image) . '&source_from=view-category.php&categoryid='.$category_id.'" class="btn btn-success m-md-2">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <button class="btn btn-danger remove-btn-js m-md-2" data-id="' . $id . '" data-image="' . htmlspecialchars($product_image) . '" data-url="delete-products.php" data-returnurl="manage-products.php">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </td>';
        $output .= '</tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}

// ✅ Get total records for pagination — safe fallback
$total_result = fetchtablebycategory('tbl_products', $categoryID);
$total_records = ($total_result) ? mysqli_num_rows($total_result) : 0;
$total_pages = ($total_records > 0) ? ceil($total_records / $limit) : 1;

header('Content-Type: application/json');
echo json_encode([
    'html' => $output,
    'total_pages' => $total_pages,
    'total_products' => $total_records,
    'current_page' => $page,
    'source_from' => "view-category.php",
]);
