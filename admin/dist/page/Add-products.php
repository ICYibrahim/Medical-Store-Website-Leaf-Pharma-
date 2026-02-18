<?php
ob_start();
session_reset();
include('includes/headtag.php');
include('../adminfunction/adminfunction.php');
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- this is the header(Navbar) -->
        <?php
        include('includes/topnavbar.php');
        include('includes/sidenavbar.php');
        if (isset($_POST['submit'])) {
            $productname = $_POST['productname'];
            $ItemCode = $_POST['barcode'];
            $company = $_POST['companyname'];
            $price = $_POST['productprice'];
            $disc = $_POST['productdiscription'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];
            $category = $_POST['category'] !== "" ? $_POST['category'] : NULL;

            //check if image is given if yes then upload if not set emptyname
            if (isset($_FILES['productimage']['name']) && $_FILES['productimage']['name'] !== '') {
                $productimage_name = $_FILES['productimage']['name'];
                $productimage_source = $_FILES['productimage']['tmp_name'];
                $productimage_destination = "../assets/products image/" . $productimage_name;
                $upload = move_uploaded_file($productimage_source, $productimage_destination);
                if ($upload == false) {
                    $_SESSION['productadded'] = [
                        'type' => 'danger',
                        'text' => 'Faild to upload image file'
                    ];
                    header("Location: Add-products.php");
                    die();
                }
            } else {
                $productimage_name = "";
            }

            $result = addproduct($productname, $ItemCode, $company, $price, $category, $productimage_name, $disc, $featured, $active, 'tbl_products');
            if ($result) {
                $_SESSION['productadded'] = [
                    'type' => 'success',
                    'text' => 'Product has Been Addeed'
                ];
                header('Location: manage-products.php');
                exit();
            } else {
                $_SESSION['productadded'] = [
                    'type' => 'danger',
                    'text' => 'Error! Product did not Added'
                ];
                header('Location: Add-product.php');
            }
        }
        ?>

        <!-- the body star here -->
        <main class="app-main">
            <?php
            if (isset($_SESSION['productadded'])) {
                $msg = $_SESSION['productadded'];
                echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

                unset($_SESSION['productadded']); // Clear after showing
            } ?>
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Add Products</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Products</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-8 col-lg-6 card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">Add Products</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="" method="post" enctype="multipart/form-data">
                                <!--begin::Body-->
                                <div class="row g-3 card-body">
                                    <div class="col-md-6">
                                        <label for="productname" class="form-label">Product Name</label>
                                        <input type="text" name="productname" class="form-control" id="productname" placeholder="Enter Product Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="companyname" class="form-label">Company</label>
                                        <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Enter Product's company Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="barcode" class="form-label">Bar Code</label>
                                        <input type="number" min="0" name="barcode" class="form-control" id="barcode" placeholder="Enter Product Bar Code" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="productprice" class="form-label">Price</label>
                                        <input type="number" min="0" name="productprice" class="form-control" id="productprice" placeholder="Enter Product Price" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" aria-label="Default select example" name="category">
                                            <option value="" selected>Select Category</option>
                                            <?php
                                            $rst = fetchcategorytablebyactive('tbl_category');
                                            if ($rst && mysqli_num_rows($rst) > 0) {
                                                while ($row = mysqli_fetch_assoc($rst)) {
                                                    echo '<option value="' . htmlspecialchars($row['category_id']) . '">'
                                                        . htmlspecialchars($row['category_title']) . '</option>';
                                                }
                                                mysqli_free_result($rst);
                                            } else {
                                                echo '<option value="">No Category</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div id="imageuploadHelpBlock" class="form-text">
                                        Enter the Image of the Product
                                    </div>
                                    <div class="input-group col-12 ">
                                        <input type="file" class="form-control" name="productimage" aria-describedby="imageuploadHelpBlock" id="productimage" />
                                        <label class="input-group-text" for="productimage">Upload</label>
                                    </div>

                                    <div class="input-group mt-3">
                                        <span class="input-group-text" for="productdiscription">Discription</span>
                                        <textarea class="form-control" name="productdiscription" id="productdiscription" aria-label="With textarea" style="align-content: center;" placeholder="Enter Product's Discription" required></textarea>
                                    </div>
                                    <div class="input-group col-12 mt-3">
                                        <label class="form-label me-3">Feature: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="featured" id="feature1" value="Yes">
                                            <label class="form-check-label" for="feature1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="featured" id="feature2" value="No" checked>
                                            <label class="form-check-label" for="feature2">no</label>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 mt-3">
                                        <label class="form-label me-3">Active: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="active" id="active1" value="Yes">
                                            <label class="form-check-label" for="active1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="active" id="active2" value="No" checked>
                                            <label class="form-check-label" for="active2">no</label>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Quick Example-->
                    </div>
                </div>
            </div>
            <!-- the body star here -->
        </main>
        <!-- this is the footer -->
        <?php include('includes/footer.php'); ?>
    </div>
    <!-- Bootstrap JavaScript CDN Link -->
    <?php include('includes/scripts.php'); ?>
</body>

</html>