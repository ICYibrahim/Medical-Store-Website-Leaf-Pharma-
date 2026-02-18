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
        include('includes/sidenavbar.php'); ?>

        <!-- the body star here -->
        <main class="app-main">
            <?php
            if (isset($_SESSION['addadmin'])) {
                $msg = $_SESSION['addadmin'];
                echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

                unset($_SESSION['addadmin']); // Clear after showing
            }

            if (isset($_POST['submit'])) {
                $fullname = $_POST['fullname'];
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if (!empty($fullname) && !empty($username) && !empty(($_POST['password']))) {
                    $result = addadmin($fullname, $username, $password, 'tbl_admin');
                    if ($result) {
                        $_SESSION['addadmin'] = [
                            'type' => 'success',
                            'text' => 'Success! New Admin added successfully.'
                        ];
                    } else {
                        $_SESSION['addadmin'] = [
                            'type' => 'danger',
                            'text' => 'Error! Something went wrong. Admin was not added'
                        ];
                    }
                    header("Location: manage-admin.php");
                    exit();
                } else {
                    $_SESSION['addadmin'] = [
                        'type' => 'danger',
                        'text' => 'Error! Please fill all the fields.'
                    ];
                    header("Location: add-admin.php");
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
                            <h3 class="mb-0">Add Admin</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="manage-admin.php">Manage Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!-- process to enter the form data into the database -->
            <div class="app-content">
                <!-- the body star here -->
                <div class="container">
                    <div class="row justify-content-center ">
                        <div class="col-md-8 col-lg-6"> <!-- Adjust column size as needed -->
                            <div class="card p-4">
                                <h2 class="mt-4 fs-2 fw-bold text-center">Add New Admin</h2>
                                <form action="" method="post">
                                    <!-- Keep all your existing form fields exactly as they are -->
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Fullname</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter your Fullname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password">
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="manage-admin.php" class="btn btn-secondary me-md-2">Go Back</a>
                                        <button type="submit" name="submit" class="btn btn-primary">Add Admin</button>
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