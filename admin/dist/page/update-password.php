<?php
// MUST be the very first thing in the file - no spaces/empty lines before!
ob_start(); // Start output buffering to capture any early output
session_start();


include('../adminfunction/adminfunction.php');
$id = null;
// Check admin ID first - before any HTML output
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $result = gettablebyid($id, 'tbl_admin');

    if ($result === false) {
        $_SESSION['passupdate'] = [
            'type' => 'danger',
            'text' => 'Database error'
        ];
        header("Location: manage-admin.php");
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        $_SESSION['passupdate'] = [
            'type' => 'danger',
            'text' => 'Admin not found'
        ];
        header("Location: manage-admin.php");
        exit();
    }

    if ($id != $row['id']) {
        $_SESSION['passupdate'] = [
            'type' => 'danger',
            'text' => 'Admin ID mismatch'
        ];

        header("Location: manage-admin.php");
        exit();
    }
} else {
    $_SESSION['passupdate'] = [
        'type' => 'danger',
        'text' => 'Invalid ID provided'
    ];

    header("Location: manage-admin.php");
    exit();
}

// Now include HTML files AFTER all possible redirects
include('includes/headtag.php');

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
            if (isset($_SESSION['passupdate'])) {
                echo '<div class="alert alert-'.$_SESSION['passupdate']['type'].' alert-dismissible fade show" role="alert">
                    <strong>'.$_SESSION['passupdate']['text'].'</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['passupdate']);
            }
            if (isset($_POST['submit'])) {
                // Get ID from form submission if available
                $id = $_POST['id'] ?? $id;

                if (!empty($id) && is_numeric($id)) {
                    $currentpass = $_POST['currentpassword'];
                    $newpass = $_POST['newpassword'];
                    $confirmpass = $_POST['confirmpassword'];

                    if (!empty($currentpass) && !empty($newpass) && !empty($confirmpass)) {
                        $result = gettablebyid($id, 'tbl_admin');
                        $row = mysqli_fetch_assoc($result);

                        if ($row && password_verify($currentpass, $row['password'])) {
                            if ($newpass == $confirmpass) {
                                $hashedpass = password_hash($newpass, PASSWORD_DEFAULT);
                                $rslt = updateadminpass($id, $hashedpass, 'tbl_admin');

                                if ($rslt) {
                                    $_SESSION['passupdate'] = [
                                        'type' => 'success',
                                        'text' => 'Password changed successfully'
                                    ];
                                    header("Location: manage-admin.php");
                                    exit();
                                } else {
                                    $_SESSION['passupdate'] = [
                                        'type' => 'danger',
                                        'text' => 'Error updating password'
                                    ];
                                }
                            } else {
                                $_SESSION['passupdate'] = [
                                    'type' => 'danger',
                                    'text' => 'New passwords do not match'
                                ];
                            }
                        } else {
                            $_SESSION['passupdate'] = [
                                'type' => 'danger',
                                'text' => 'Invalid current password'
                            ];
                        }
                    } else {
                        $_SESSION['passupdate'] = [
                            'type' => 'danger',
                            'text' => 'Please fill all fields'
                        ];
                    }
                } else {
                    $_SESSION['passupdate'] = [
                        'type' => 'danger',
                        'text' => 'Invalid admin ID'
                    ];
                }
                // Redirect back to form with ID
                header("Location: update-password.php?id=$id");
                exit();
            }
            ?>

            <!-- the body star here -->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Change Password</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="manage-admin.php">Manage Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">

                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-8 col-lg-6"> <!-- Adjust column size as needed -->
                            <div class="card p-4">
                                <h2 class="mt-4 fs-2 fw-bold text-center">Change Password</h2>
                                <form action="" method="post">
                                    <!-- Keep all your existing form fields exactly as they are -->
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($id) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="currentpassword" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="Enter your Current Password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newpassword" class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Enter your New Password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmpassword" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter your Confirm Password">
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="manage-admin.php" class="btn btn-secondary me-md-2">Go Back</a>
                                        <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
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