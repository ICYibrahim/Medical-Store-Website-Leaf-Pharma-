<?php
session_start();
include('../adminfunction/adminfunction.php');
if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $result = DeleteTableRow($id, 'tbl_admin');

    if ($result) {
        $_SESSION['deletemsg'] = [
            'type' => 'success',
            'text' => 'Admin deleted successfully!'
        ];
        echo "success";
    } else {
        $_SESSION['deletemsg'] = [
            'type' => 'danger',
            'text' => 'Failed to delete admin. Please try again.'
        ];
        echo "Failed";
    }
} else {
    $_SESSION['deletemsg'] = [
        'type' => 'danger',
        'text' => 'Invalid admin ID'
    ];
    echo "invalid";
}
