<?php
include('userfunction/myfunction.php');

$output = "";
$result = fatchallcategory('tbl_category');

if ($result && mysqli_num_rows($result) > 0) {
    while ($category = mysqli_fetch_assoc($result)) {
        $limit = 12;
        $categoryid = $category['category_id'];

        $output .= '
            <div class="Product-container-wrapper container mt-4 mb-4">
                <div class="Product-container-heading d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="mb-2 mb-sm-0 category-title">' . $category['category_title'] . '</h1>
                    <button class="view-more-btn view-btn" data-categoryid="' . $categoryid . '" data-limit="12">View more</button>
                </div>
                <div class="scroll-wrapper position-relative mt-4">
                    <!-- Left scroll button -->
                    <button class="scroll-btn left">&#8249;</button>

                    <!-- Scrollable container -->
                    <div class="scroll d-flex flex-nowrap overflow-auto mt-4">
        ';

        // ✅ Now load products for this category
        $product_data = LoadProductByCategory($categoryid, $limit);

        if ($product_data && mysqli_num_rows($product_data) > 0) {
            while ($row = mysqli_fetch_assoc($product_data)) {
                $output .= '
                    <div class="product-card">
                        <a class="text-decoration-none" style="color: black;" href="show_product_detail.php?id=' . $row['id'] . '&product=' . $row['ItemName'] . '&categoryid=' . $categoryid . '">
                            <div class="product-card-img">
                                <img src="admin/dist/assets/products image/' . $row['ProductImage'] . '">
                            </div>
                            <div class="product-card-body m-2">
                                <h4 class="product-card-title">' . $row['ItemName'] . '</h4>
                            </div>
                        </a>
                        <div class="product-card-body-bottom m-2 mt-4">
                            <h4 class="product-card-price">Rs ' . number_format($row['SPrice'], 2) . '</h4>
                            <button class="AddToCartBtn card-btn"
                                style="width: 100%; font-weight: 600;"
                                data-pid="' . $row['id'] . '"
                                data-pcode="' . $row['ItemCode'] . '"
                                data-pname="' . $row['ItemName'] . '"
                                data-pprice="' . $row['SPrice'] . '"
                                data-pimage="' . $row['ProductImage'] . '">Add to cart</button>
                        </div>
                    </div>
                ';
            }
        } else {
            $output .= '<p>No products found in this category.</p>';
        }

        $output .= '
                    </div> <!-- End scroll container -->

                    <!-- Right scroll button -->
                    <button class="scroll-btn right">&#8250;</button>
                </div>
            </div>
        ';
    }
}

echo $output;
?>
