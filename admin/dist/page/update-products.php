<?php
ob_start(); // Start output buffering to capture any early output
session_start();
include('../adminfunction/adminfunction.php');
include('includes/headtag.php');

?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- this is the header(Navbar) -->
        <?php
        include('includes/topnavbar.php');
        include('includes/sidenavbar.php');

        // check if the id is numeric and available in the Database
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $isviewcategory = false;
            $source_from = $_GET['source_from'];
            if ($source_from == "view-category.php") {
                $categoryid = $_GET['categoryid'];
                $isviewcategory = true;
            }
            $dbresult = gettablebyid($id, 'tbl_products');
            if ($row = mysqli_fetch_assoc($dbresult)) {
                $dbid = $row['id'];
                $dbcategory_id = $row['category_id'];
                $dbitemcode = $row['ItemCode'];
                $dbconpany = $row['Company'];
                $dbitemname = $row['ItemName'];
                $dbprice = $row['SPrice'];
                $dbproductdisc = $row['ProductDiscription'];
                $dbfeatured = $row['featured'];
                $dbactive = $row['active'];
                $previousproductimage = $row['ProductImage'];
            } else {
                $_SESSION['productupdated'] = [
                    'type' => 'danger',
                    'text' => 'Database Error! No such ID available'
                ];
                header('Location: manage-products.php');
                exit();
            }
        } else {
            $_SESSION['productupdated'] = [
                'type' => 'danger',
                'text' => 'Invalid ID provided'
            ];
            header('Location: manage-products.php');
            exit();
        }

        // updating the product when clicked submit

        if (isset($_POST['submit'])) {
            $productname = $_POST['productname'];
            $ItemCode = $_POST['barcode'];
            $company = $_POST['companyname'];
            $price = $_POST['productprice'];
            $disc = $_POST['productdiscription'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];
            $previousproductimage = $_POST['previousproductimage'];
            $category = $_POST['category'] !== "" ? $_POST['category'] : NULL;
            //remove the file if the radio button is selected
            if (!empty($_POST['removeimage'])) {
                if ($previousproductimage != "" && file_exists("../assets/products image/" . $previousproductimage)) {
                    unlink("../assets/products image/" . $previousproductimage);
                }
                $previousproductimage = "";
            }
            //check if upload file field is not empty then delete the previousimage 
            if (!empty($_FILES['newproductimage']['name'])) {

                if ($previousproductimage != "" && file_exists("../assets/products image/" . $previousproductimage)) {
                    unlink("../assets/products image/" . $previousproductimage);
                }
                $newproductimage_name = $_FILES['newproductimage']['name'];
                $newproductimage_source = $_FILES['newproductimage']['tmp_name'];
                $newproductimage_destination = "../assets/products image/" . $newproductimage_name;
                $upload = move_uploaded_file($newproductimage_source, $newproductimage_destination);
                if (!$upload) {
                    $_SESSION['productupdated'] = [
                        'type' => 'danger',
                        'text' => 'Failed to upload new image'
                    ];
                    header("Location: update-products.php?id=" . $id);
                    exit();
                }
            } else {
                $newproductimage_name = $previousproductimage;
            }

            $result = updateproduct($id, $productname, $ItemCode, $company, $price, $category, $newproductimage_name, $disc, $featured, $active, 'tbl_products');
            if ($result) {
                if ($isviewcategory) {
                    $_SESSION['productupdated'] = [
                        'type' => 'success',
                        'text' => 'product has been Updated Successfully'
                    ];
                    header('Location: view-category.php?categoryid='.$categoryid);
                    exit();
                } else {
                    $_SESSION['productupdated'] = [
                        'type' => 'success',
                        'text' => 'product has been Updated Successfully'
                    ];
                    header('Location: manage-products.php');
                    exit();
                }
            } else {
                $_SESSION['productupdated'] = [
                    'type' => 'danger',
                    'text' => 'product has not been Updated. Please try again'
                ];
                header('Location: update-products.php?id=' . $id);
                exit();
            }
        }
        ?>
        <main class="app-main">
            <?php
            if (isset($_SESSION['productupdated'])) {
                $msg = $_SESSION['productupdated'];
                echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

                unset($_SESSION['productupdated']); // Clear after showing
            }
            ?>
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Update Products</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="manage-products.php">Manage Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Products</li>
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
                                <div class="card-title">Update Products</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="" method="post" enctype="multipart/form-data">
                                <!--begin::Body-->
                                <div class="row g-3 card-body">
                                    <input type="hidden" name="id" class="form-control" value="<?php echo $dbid ?>" required>
                                    <div class="col-md-6">
                                        <label for="productname" class="form-label">Product Name</label>
                                        <input type="text" name="productname" class="form-control" id="productname" value="<?php echo $dbitemname ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="companyname" class="form-label">Company</label>
                                        <input type="text" class="form-control" name="companyname" id="companyname" value="<?php echo $dbconpany ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="barcode" class="form-label">Bar Code</label>
                                        <input type="number" min="0" name="barcode" class="form-control" id="barcode" value="<?php echo $dbitemcode ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="productprice" class="form-label">Price</label>
                                        <input type="number" step="0.01" min="0" name="productprice" class="form-control" id="productprice" value="<?php echo $dbprice ?>" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" aria-label="Default select example" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            // First show the current category if it exists
                                            if ($dbcategory_id != "" && $dbcategory_id != "0") {
                                                $data = getcategorybyid($dbcategory_id, 'tbl_category');
                                                if ($data && mysqli_num_rows($data) > 0) {
                                                    $dbrow = mysqli_fetch_assoc($data);
                                                    echo '<option value="' . htmlspecialchars($dbrow['category_id']) . '" selected>'
                                                        . htmlspecialchars($dbrow['category_title']) . '</option>';
                                                }
                                            }

                                            // Then show all other categories
                                            $rst = fetchcategorytablebyactive('tbl_category');
                                            if ($rst && mysqli_num_rows($rst) > 0) {
                                                while ($row = mysqli_fetch_assoc($rst)) {
                                                    // Skip if this is the current category (already shown)
                                                    if ($row['category_id'] == $dbcategory_id) continue;

                                                    echo '<option value="' . htmlspecialchars($row['category_id']) . '">'
                                                        . htmlspecialchars($row['category_title']) . '</option>';
                                                }
                                                mysqli_free_result($rst);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php if ($previousproductimage != "") { ?>
                                        <div class="mb-3">
                                            <div class="form-text mb-2">Current image: <?php echo htmlspecialchars($previousproductimage) ?></div>
                                            <input type="hidden" name="previousproductimage" value="<?php echo htmlspecialchars($previousproductimage) ?>">

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="removeimage" id="remove_image" value="1">
                                                <label class="form-check-label" for="remove_image">Remove current image</label>
                                            </div>

                                            <div class="input-group">
                                                <input type="file" class="form-control" name="newproductimage" id="productimage">
                                                <label class="input-group-text" for="productimage">Upload</label>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="mb-3">
                                            <div class="form-text mb-2">Current image: No file exists</div>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="newproductimage" id="productimage">
                                                <label class="input-group-text" for="productimage">Upload</label>
                                            </div>
                                            <input type="hidden" name="previousproductimage" value="<?php echo htmlspecialchars($previousproductimage) ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="input-group mt-3">
                                        <span class="input-group-text" for="productdiscription">Discription</span>
                                        <textarea class="form-control" name="productdiscription" id="productdiscription" aria-label="With textarea" style="align-content: center;" required><?php echo $dbproductdisc ?></textarea>
                                    </div>
                                    <div class="input-group col-12 mt-3">
                                        <label class="form-label me-3">Feature: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="featured" id="feature1" value="Yes" <?php if ($dbfeatured == "Yes") {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                            <label class="form-check-label" for="feature1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="featured" id="feature2" value="No" <?php if ($dbfeatured == "No") {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                            <label class="form-check-label" for="feature2">no</label>
                                        </div>
                                    </div>
                                    <div class="input-group col-12 mt-3">
                                        <label class="form-label me-3">Active: </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="active" id="active1" value="Yes" <?php if ($dbactive == "Yes") {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                            <label class="form-check-label" for="active1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="active" id="active2" value="No" <?php if ($dbactive == "No") {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                            <label class="form-check-label" for="active2">no</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-text mb-2"><b>Note: </b>Featured products must also be Active to appear.</div>
                                        <div class="form-text mb-2">&nbsp;Active but non-featured products show only in categories or search, not on the homepage</div>
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