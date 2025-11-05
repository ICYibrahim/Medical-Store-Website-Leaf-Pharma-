<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only redirect to login if:
// 1. Not already on login page
// 2. Not submitting login form
// 3. User not logged in
$current_page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user']) && $current_page !== 'login.php' && !isset($_POST['submit'])) {
    $_SESSION['no-user'] = [
        'type' => 'danger',
        'text' => 'Please login first'
    ];
    header('Location: login.php');
    exit();
}
?>