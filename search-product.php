<?php
include('userfunction/myfunction.php');

$search = mysqli_real_escape_string($conn, $_POST['search'] ?? '');
$output = '';

$result = liveSearchProduct($search);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryid = $row['category_id'];
        $productName = htmlspecialchars($row['ItemName']);
        $productPrice = htmlspecialchars($row['SPrice']);
        $productImage = $row['ProductImage'];
        $imagePath = !empty($productImage) ? 'admin/dist/assets/products image/' . $productImage : '';
        // search product image 
        $output .= '<a class="text-decoration-none " style="color: black;" href="show_product_detail.php?id=' . $row['id'] . '&product=' . $row['ItemName'] . '&categoryid=' . $categoryid . '">';
        $output .= '<div class="search-product-wrapper">';

        // Product Image
        $output .= '<div class="result-product-image">';
        $output .=     (!empty($imagePath) ? '<img src="' . $imagePath . '" alt="Product Image">' : '<span>No Image</span>');
        $output .= '</div>';

        // Product Details
        $output .= '<div class="result-product-detail">';
        $output .= '    <h4>' . $productName . '</h4>';
        $output .= '    <p>Rs-' . number_format($productPrice, 2) . '</p>';
        $output .= '</div>';

        $output .= '</div>'; // close .search-product-wrapper
        $output .= '</a>';
    }
} else {
    $output = '<div class="text-center py-3 text-muted">No products found matching your search.</div>';
}

echo $output;
