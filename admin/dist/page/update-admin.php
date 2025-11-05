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
            <?php
            if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
                //getting the id.
                $id = $_GET['id'];
                $result = gettablebyid($id, 'tbl_admin');
                if ($result) {
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $id = $row['id'];
                        $fullname = $row['fullname'];
                        $username = $row['username'];
                    } else {
                        $_SESSION['updatemsg'] = [
                            'type' => 'danger',
                            'text' => 'Admin not found'
                        ];
                        header("Location: manage-admin.php");
                        die();
                    }
                }
            } else {
                $_SESSION['updatemsg'] = [
                    'type' => 'danger',
                    'text' => 'Invalid Id Provided'
                ];
                header("Location: manage-admin.php");
                exit();
            }

            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $fullname = $_POST['fullname'];
                $username = $_POST['username'];
                if (!empty($fullname) && !empty($username)) {

                    $result = updateadmin($id, $fullname, $username, 'tbl_admin');

                    if ($result) {
                        $_SESSION['updatemsg'] = [
                            'type' => 'success',
                            'text' => 'Admin updated successfully!'
                        ];
                    } else {
                        $_SESSION['updatemsg'] = [
                            'type' => 'danger',
                            'text' => 'Failed to update admin. Please try again.'
                        ];
                    }
                    header("Location: update-admin.php");
                    exit();
                } else {
                    $_SESSION['updatemsg'] = [
                        'type' => 'danger',
                        'text' => 'Please Fill out All the Fields'
                    ];
                    header("Location: update-admin.php");
                    exit();
                }
            }
            ?>
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Update Admin</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="manage-admin.php">Manage Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Admin</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">
                <!-- the body star here -->
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-8 col-lg-6"> <!-- Adjust column size as needed -->
                            <div class="card p-4">
                                <h2 class="mt-4 fs-2 fw-bold text-center">Update Admin</h2>
                                <form action="" method="post">
                                    <!-- Keep all your existing form fields exactly as they are -->
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" name="id" value="<?php echo $id ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Fullname</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $fullname; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>">
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="manage-admin.php" class="btn btn-secondary me-md-2">Go Back</a>
                                        <button type="submit" name="submit" class="btn btn-primary">Update Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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