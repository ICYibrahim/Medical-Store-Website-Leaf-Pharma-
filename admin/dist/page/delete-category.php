<?php
session_start();
include('../adminfunction/adminfunction.php');
if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $category_image = $_POST['image'];

    if ($category_image != "") {
        $path = "../assets/category/$category_image";
        $remove = unlink($path);
        if ($remove == false) {
            $_SESSION['categorydeleted'] = [
                'type' => 'danger',
                'text' => 'Something went wrogn please try again'
            ];
            header("Location: manage-category.php");
            die();
        }
    }

    $result = DeleteCategoryRow($id, 'tbl_category');

    if ($result) {
        $_SESSION['categorydeleted'] = [
            'type' => 'success',
            'text' => 'Category deleted successfully!'
        ];
        echo "success";
    } else {
        $_SESSION['categorydeleted'] = [
            'type' => 'danger',
            'text' => 'Failed to delete Category. Please try again.'
        ];
        echo "Failed";
    }
} else {
    $_SESSION['categorydeleted'] = [
        'type' => 'danger',
        'text' => 'Invalid Category ID'
    ];
    echo "Invalid";
}
