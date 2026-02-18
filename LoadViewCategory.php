<?php
include('userfunction/myfunction.php');

if (!isset($_POST['categoryid']) || !isset($_POST['limit'])) {
    die(json_encode(['error' => 'Invalid request']));
}

$categoryid = (int)$_POST['categoryid'];
$limit = (int)$_POST['limit'];
if ($limit > 12) $limit = 12;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

// Check if this is an "append" request or "initial" load
$append = isset($_POST['append']) ? (bool)$_POST['append'] : false;

// Count total rows for pagination
$total = countproductbycategoryid($categoryid);
$total_pages = ceil($total / $limit);

$product_data = viewCategorypage($categoryid, $limit, $offset);

$output = "";
$category_title = "";

if ($product_data && mysqli_num_rows($product_data) > 0) {
    while ($row = mysqli_fetch_assoc($product_data)) {
        $category_title = $row['category_title'];
        $output .= '  
            <div class="product-card">
                <a class="text-decoration-none" style="color: black;" href="show_product_detail.php?id=' . $row['id'] . '&product=' . urlencode($row['ItemName']) . '&categoryid=' . $categoryid . '">
                    <div class="product-card-img">
                        <img src="admin/dist/assets/products image/' . htmlspecialchars($row['ProductImage']) . '">
                    </div>
                    <div class="product-card-body m-2">
                        <h4 class="product-card-title">' .  htmlspecialchars($row['ItemName']) . '</h4>
                    </div>
                </a>
                <div class="product-card-body-bottom m-2 mt-4">
                    <h4 class="product-card-price">Rs ' . number_format($row['SPrice'], 2) . '</h4>
                    <button class="AddToCartBtn card-btn" style="width: 100%; font-weight: 600;" 
                            data-pid="' . $row['id'] . '" 
                            data-pcode="' . htmlspecialchars($row['ItemCode']) . '" 
                            data-pname="' . htmlspecialchars($row['ItemName']) . '" 
                            data-pprice="' . $row['SPrice'] . '" 
                            data-pimage="' . htmlspecialchars($row['ProductImage']) . '">Add to cart</button>
                </div>
            </div>';
    }
    
    mysqli_free_result($product_data);
} else {
    if ($page == 1 && !$append) {
        $output = "<div class='text-center'>No products found in this category</div>";
    } else {
        $output = ""; // Return empty for Load More when no more products
    }
}

// Generate Load More button HTML
$load_more_html = "";
if ($page < $total_pages) {
    $load_more_html = '<button class="btn btn-success load-more-btn" data-page="' . ($page + 1) . '">Load More</button>';
} else if ($page > 1) {
    $load_more_html = '<div class="text-muted">No more products to load</div>';
}

$response = [
    'product_Cards' => $output,
    'category_title' => $category_title ?: 'Category Products',
    'load_more_html' => $load_more_html,
    'page' => $page,
    'has_more' => ($page < $total_pages),
    'total' => $total,
    'append' => $append
];

header('Content-Type: application/json');
echo json_encode($response);
?>