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
            $dbresult = getcategorybyid($id, 'tbl_category');
            if ($row = mysqli_fetch_assoc($dbresult)) {
                $dbid = $row['category_id'];
                $category_title = $row['category_title'];
                $previouscategoryimage = $row['category_image'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                $_SESSION['categoryupdated'] = [
                    'type' => 'danger',
                    'text' => 'Database Error! No such ID available'
                ];
                header('Location: manage-category.php');
                exit();
            }
        } else {
            $_SESSION['categoryupdated'] = [
                'type' => 'danger',
                'text' => 'Invalid ID provided'
            ];
            header('Location: manage-category.php');
            exit();
        }

        //check if the submit button is pressed and Title is given
        if (isset($_POST['submit'])) {
            if (!empty($_POST['categorytitle'])) {

                $categoryid = $_POST['categoryid'];
                $categorytitle = $_POST['categorytitle'];
                $featured = $_POST['feature'];
                $active = $_POST['active'];

                //remove the file if the radio button is selected
                if (!empty($_POST['removeimage'])) {
                    if ($previouscategoryimage != "" && file_exists("../assets/category/" . $previouscategoryimage)) {
                        unlink("../assets/category/" . $previouscategoryimage);
                    }
                    $previouscategoryimage = "";
                }
                //check if upload file field is not empty then delete the previousimage 
                if (!empty($_FILES['newcategoryimage']['name'])) {

                    if ($previouscategoryimage != "" && file_exists("../assets/category/" . $previouscategoryimage)) {
                        unlink("../assets/category/" . $previouscategoryimage);
                    }
                    $newcategoryimage_name = $_FILES['newcategoryimage']['name'];
                    $newcategoryimage_source = $_FILES['newcategoryimage']['tmp_name'];
                    $newcategoryimage_destination = "../assets/category/" . $newcategoryimage_name;
                    $upload = move_uploaded_file($_FILES['newcategoryimage']['tmp_name'], $newcategoryimage_destination);
                    if (!$upload) {
                        $_SESSION['categoryupdated'] = [
                            'type' => 'danger',
                            'text' => 'Failed to upload new image'
                        ];
                        header("Location: update-category.php?id=" . $id);
                        exit();
                    }
                } else {
                    $newcategoryimage_name = $previouscategoryimage;
                }

                $result = updatecategory($categoryid, $categorytitle, $newcategoryimage_name, $featured, $active, 'tbl_category');
                if ($result) {
                    $_SESSION['categoryupdated'] = [
                        'type' => 'success',
                        'text' => 'Category has been Updated Successfully'
                    ];
                    header('Location: manage-category.php');
                    exit();
                } else {
                    $_SESSION['categoryupdated'] = [
                        'type' => 'danger',
                        'text' => 'Category has not been Updated. Please try again'
                    ];
                    header('Location: update-category.php?id=' . $id);
                    exit();
                }
            } else {
                $_SESSION['categoryupdated'] = [
                    'type' => 'danger',
                    'text' => 'Please Enter Category Title'
                ];
                header('Location: update-category.php?id=' . $id);
                exit();
            }
        }

        ?>

        <!-- the body star here -->
        <main class="app-main">
            <?php
            if (isset($_SESSION['categoryupdated'])) {
                $msg = $_SESSION['categoryupdated'];
                echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

                unset($_SESSION['categoryupdated']); // Clear after showing

            }
            ?>
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Update Category</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="manage-category.php">Manage Category</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Category</li>
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
                                        <input type="hidden" class="form-control" name="categoryid" id="title" value="<?php echo $dbid ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="categorytitle" id="title" value="<?php echo $category_title ?>" />
                                    </div>
                                    <?php if ($previouscategoryimage != "") { ?>
                                        <div class="mb-3">
                                            <!-- Display current filename and option to keep/remove it -->
                                            <div class="form-text mb-2">Current image: <?php echo htmlspecialchars($previouscategoryimage) ?></div>

                                            <!-- Hidden field to keep track of existing image -->
                                            <input type="hidden" name="previouscategoryimage" value="<?php echo htmlspecialchars($previouscategoryimage) ?>">
                                            <!-- Option to remove the current image -->

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="removeimage" id="remove_image" value="1">
                                                <label class="form-check-label" for="remove_image">Remove current image</label>
                                            </div>

                                            <!-- File input for replacement -->
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="newcategoryimage" id="categoryimage">
                                                <label class="input-group-text" for="categoryimage">Upload</label>
                                            </div>


                                        </div>
                                    <?php } else { ?>
                                        <div class="form-text mb-2">Current image: No file exist </div>
                                        <!-- No existing image - just show upload field -->
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" name="newcategoryimage" id="categoryimage">
                                            <label class="input-group-text" for="categoryimage">Upload</label>
                                        </div>
                                        <input type="hidden" name="previouscategoryimage" value="<?php echo htmlspecialchars($previouscategoryimage) ?>">
                                    <?php } ?>

                                    <br>
                                    <label class="form-label me-3">Feature: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" <?php if ($featured == "Yes") {
                                                                            echo 'checked';
                                                                        } ?> type="radio" name="feature" id="feature1" value="Yes">
                                        <label class="form-check-label" for="feature1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="feature" id="feature2" value="No" <?php if ($featured == "No") {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                        <label class="form-check-label" for="feature2">no</label>
                                    </div>
                                    <br>
                                    <label class="form-label me-3">Active: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="active" id="active1" value="Yes" <?php if ($active == "Yes") {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                        <label class="form-check-label" for="active1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="active" id="active2" value="No" <?php if ($active == "No") {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
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