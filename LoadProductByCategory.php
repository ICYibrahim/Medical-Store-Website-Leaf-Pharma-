<?php
include('userfunction/myfunction.php');
if (!isset($_POST['categoryid']) || !isset($_POST['limit'])) {
    die("Invalid request");
}

$categoryid = (int)$_POST['categoryid'];
$limit = (int)$_POST['limit'];

if ($limit > 20) $limit = 20;
$product_data = LoadProductByCategory($categoryid, $limit);
$output = "";
if ($product_data && mysqli_num_rows($product_data)) {
    while ($row = mysqli_fetch_assoc($product_data)) {
        $output .= '  
                    <div class="product-card">
                        <a class="text-decoration-none " style="color: black;" href="show_product_detail.php?id=' . $row['id'] . '&product=' . $row['ItemName'] . '&categoryid=' . $categoryid . '">
                            <div class="product-card-img">
                                <img src="admin/dist/assets/products image/' . $row['ProductImage'] . '">
                            </div>
                            <div class="product-card-body m-2">
                                <h4 class="product-card-title">' .  $row['ItemName'] . '</h4>
                            </div>
                        </a>
                        <div class="product-card-body-bottom m-2 mt-4">
                            <h4 class="product-card-price">Rs ' . number_format($row['SPrice'], 2) . '</h4>
                            <button class="AddToCartBtn card-btn" style="width: 100%; font-weight: 600;" data-pid="' . $row['id'] . '" data-pcode="' . $row['ItemCode'] . '" data-pname="' . $row['ItemName'] . '" data-pprice="' . $row['SPrice'] . '" data-pimage="' . $row['ProductImage'] . '">Add to cart</button>
                        </div>
                    </div>';
    }
}
echo $output;
