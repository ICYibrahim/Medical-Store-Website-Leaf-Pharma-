<?php include('includes/headtag.php'); ?>

<body>
    <?php
    include('userfunction/myfunction.php');
    include('includes/header.php');
    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $product_slug = $_GET['product'];
        $categoryid = $_GET['categoryid'];
        $product_data = getslugactive($id, $product_slug, "tbl_products");
        $product = mysqli_fetch_array($product_data);
        $productImage = $product['ProductImage'];
        $imagePath = !empty($productImage) ? 'admin/dist/assets/products image/' . $productImage : '';

        if ($product) {
    ?>
            <div class="show-product-wrapper container px-5 ">
                <input type="hidden" id="categoryidhidden" data-categoryid="<?php echo $categoryid ?>">
                <input type="hidden" id="productidhidden" data-productid="<?php echo $id ?>">
                <input type="hidden" id="productnamehidden" data-productname="<?php echo $product_slug ?>">
                <div class="row gy-3">
                    <div class="col-12 col-md-6 col-lg-4 show-product-detail-img-wrapper d-flex justify-content-center align-items-center">
                        <div class="product-detail-img-wrapper w-100">
                            <?php
                            if (!empty($imagePath)) {
                            ?>
                                <img src="<?php echo $imagePath ?>" class="img-fluid w-100" alt="Product Image">
                            <?php
                            } else {
                            ?>
                                <div class="text-align-center justify-content-center">
                                    <p>No Image</p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 product-detail-disc-wrapper">
                        <h4 class="product-detail-title"><?php echo $product['ItemName']; ?></h4>
                        <span class="stock-badge">in-stock</span>
                        <hr>
                        <h5 class="product-detail-sub-title"><span class="sub-title-heading"><i class='bx bx-tag-alt'></i> Category </span>Syrup</h5>
                        <h5 class="product-detail-sub-title"><span class="sub-title-heading"><i class='bx bx-buildings'></i> Company </span> <?php echo $product['Company']; ?></h5>
                        <hr>
                        <h5 class="product-dicrp-heading">Product Discription</h5>
                        <p class="product-dicrp"><?php echo $product['ProductDiscription']; ?></p>
                        <h3 class="product-detail-price"><?php echo number_format($product['SPrice'], 2); ?><span style="font-weight: 500; font-size: 14px;">PKR</span></h3>
                        <div class="quantity-controls d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-success qty-btn minus">−</button>
                            <input type="number" class="form-control qty-input mx-1" name="quantity" value="1" min="1">
                            <button class="btn btn-sm btn-outline-success qty-btn plus">+</button>
                        </div>
                        <hr>
                        <button
                            class="AddToCartBtn card-btn" style="font-weight: 600; font-size:0.8rem;"
                            data-pid="<?php echo $product['id']; ?>"
                            data-pcode="<?php echo $product['ItemCode']; ?>"
                            data-pname="<?php echo $product['ItemName']; ?>"
                            data-pprice="<?php echo $product['SPrice']; ?>"
                            data-pimage="<?php echo $product['ProductImage']; ?>">
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
            <div class="top-Product-container-wrapper container mt-4 mb-4">
                <div
                    class="top-Product-container-heading d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="mb-2 mb-sm-0 category-title">Related Product</h1>
                </div>
                <div class="scroll-wrapper position-relative mt-4">
                    <!-- Left scroll button -->
                    <button class="scroll-btn left">&#8249;</button>

                    <!-- Scrollable container -->
                    <div id="relatedproduct" class="scroll d-flex flex-nowrap overflow-auto mt-4">

                    </div>

                    <!-- Right scroll button -->
                    <button class="scroll-btn right">&#8250;</button>
                </div>
            </div>
    <?php

        } else {
            echo "product not found";
        }
    } else {
        echo "something went wrong ";
    }
    ?>
    <?php
    include('includes/footer.php');
    include('includes/scripttag.php');
    mysqli_close($conn);
    ?>
</body>
<script>
    $(document).ready(function() {

        var categoryidno = $('#categoryidhidden').data('categoryid');
        var productidno = $('#productidhidden').data('productid');
        var productname = $('#productnamehidden').data('productname');
        var limit = 20;
        LoadRelatedProduct(categoryidno, productidno, productname, limit);

    });
</script>

</html>