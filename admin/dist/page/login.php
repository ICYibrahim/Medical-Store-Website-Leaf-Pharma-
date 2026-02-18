<?php
// Absolute first line in file - no whitespace before!
ob_start();
session_start();

include('includes/headtag.php');
include('../adminfunction/adminfunction.php');

// If user is already logged in AND this is not a form submission
if (isset($_SESSION['user']) && !isset($_POST['submit'])) {
  header("Location: index.php");
  exit();
}

if (isset($_POST['submit'])) {
  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $result = getadminbyuser($username, 'tbl_admin');

    if ($result && $row = mysqli_fetch_assoc($result)) {
      $fullname = $row['fullname'];
      $dbpass = $row['password'];

      if (password_verify($_POST['password'], $dbpass)) {
        $_SESSION['user'] = $fullname;
        $_SESSION['usergranted'] = [
          'type' => 'success',
          'text' => 'Welcome! You are granted'
        ];
        header("Location: index.php");
        exit();
      }
    }

    // If we get here, login failed
    $_SESSION['usergranted'] = [
      'type' => 'danger',
      'text' => 'Invalid username or password'
    ];
  } else {
    $_SESSION['usergranted'] = [
      'type' => 'danger',
      'text' => 'Please fill all the fields'
    ];
  }
}
?>

<body class="login-page bg-body-secondary">
  <?php
  if (isset($_SESSION['usergranted'])) {
    $msg = $_SESSION['usergranted'];
    echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    unset($_SESSION['usergranted']); // Clear after showing
  }
  if (isset($_SESSION['no-user'])) {
    $msg = $_SESSION['no-user'];
    echo '<div class="alert alert-' . $msg['type'] . ' alert-dismissible fade show" role="alert">
                <strong>' . $msg['text'] . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    unset($_SESSION['no-user']); // Clear after showing
  }
  ?>
  <div class="login-box">
    <div class="login-logo">
      <a href="login.php"><b>Log-in</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required />
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required />
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
          </div>
          <!--begin::Row-->
          <div class="row">
            <div class="col-8">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!--end::Row-->
        </form>
        <div class="social-auth-links text-center mb-3 d-grid gap-2">
          <p>- OR -</p>
          <a href="#" class="btn btn-primary">
            <i class="bi bi-facebook me-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-danger">
            <i class="bi bi-google me-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->
        <p class="mb-1"><a href="forgot-password.html">I forgot my password</a></p>
        <p class="mb-0">
          <a href="register.html" class="text-center"> Register a new membership </a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <?php include('includes/scripts.php'); ?>
</body>
<!--end::Body-->

</html>