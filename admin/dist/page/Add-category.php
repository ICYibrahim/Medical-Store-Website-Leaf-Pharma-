<?php
ob_start(); // Start output buffering to capture any early output
session_start();
include('includes/headtag.php');
include('../adminfunction/adminfunction.php');
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- this is the header(Navbar) -->
        <?php

        include('includes/topnavbar.php');
        include('includes/sidenavbar.php');
        ?>


        <!-- the body star here -->
        <main class="app-main">
            <!-- this is the header(Navbar) -->
            <?php
            if (isset($_SESSION['categoryadded'])) {
                $msg = $_SESSION['categoryadded'];
                echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

                unset($_SESSION['categoryadded']); // Clear after showing
            }
            // if (isset($_POST['submit'])) {
            //     $image_name = $_FILES['categoryimage']['name'];
            //     $tmp_name = $_FILES['categoryimage']['tmp_name'];
            //     $image_destination = "../assets/category/".$image_name;

            //     if (move_uploaded_file($tmp_name, $image_destination)) {
            //         echo "File uploaded!";
            //     } else {
            //         echo "Upload failed. Check permissions/errors.";
            //     }
            //     die();
            // }
            if (isset($_POST['submit'])) {
                $categorytitle = $_POST['categorytitle'];
                $feature = $_POST['feature'];
                $active = $_POST['active'];

                if (!empty($categorytitle)) {
                    $image_name = ""; // Default empty value

                    // Check if file was actually uploaded (not just form submitted)
                    if (!empty($_FILES['categoryimage']['name']) && $_FILES['categoryimage']['error'] == UPLOAD_ERR_OK) {
                        $image_name = $_FILES['categoryimage']['name'];
                        $image_source = $_FILES['categoryimage']['tmp_name'];
                        $image_destination = "../assets/category/" . $image_name;
                        $upload = move_uploaded_file($image_source, $image_destination);

                        if ($upload == false) {
                            $_SESSION['categoryadded'] = [
                                'type' => 'danger',
                                'text' => 'Failed to upload image file'
                            ];
                            header("Location: Add-category.php");
                            die();
                        }
                    }

                    $result = addcategory($categorytitle, $image_name, $feature, $active, 'tbl_category');

                    if ($result) {
                        $_SESSION['categoryadded'] = [
                            'type' => 'success',
                            'text' => 'Category Has Been added Successfully'
                        ];
                        header("Location: manage-category.php");
                        exit();
                    } else {
                        $_SESSION['categoryadded'] = [
                            'type' => 'danger',
                            'text' => 'Failed! Something went wrong Please try again.'
                        ];
                        header("Location: Add-category.php");
                        exit();
                    }
                } else {
                    $_SESSION['categoryadded'] = [
                        'type' => 'danger',
                        'text' => 'Please fill all the fields'
                    ];
                    header("Location: Add-category.php");
                    exit();
                }
            }
            ?>
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Add Category</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="manage-category.php">Manage Category</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">

                <!--begin::Quick Example-->
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-8 col-lg-6 card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">Quick Example</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form action="" method="post" enctype="multipart/form-data">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="categorytitle" id="title" placeholder="Enter Category Name" />
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="categoryimage" id="categoryimage" />
                                        <label class="input-group-text" for="categoryimage">Upload</label>
                                    </div>
                                    <br>
                                    <label class="form-label me-3">Feature: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="feature" id="feature1" value="Yes">
                                        <label class="form-check-label" for="feature1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="feature" id="feature2" value="No" checked>
                                        <label class="form-check-label" for="feature2">no</label>
                                    </div>
                                    <br>
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
        </main>
        <!-- this is the footer -->
        <?php include('includes/footer.php'); ?>
    </div>
    <?php include('includes/scripts.php'); ?>
</body>

</html>