<?php
session_start();
include('../adminfunction/adminfunction.php');
if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $product_image = $_POST['ProductImage'];

    if ($product_image != "") {
        $path = "../assets/products image/$product_image";
        $remove = unlink($path);
        if ($remove == false) {
            $_SESSION['productdeleted'] = [
                'type' => 'danger',
                'text' => 'Something went wrogn please try again'
            ];
            header("Location: manage-products.php");
            die();
        }
    }

    $result = DeleteTableRow($id, 'tbl_products');

    if ($result) {
        $_SESSION['productdeleted'] = [
            'type' => 'success',
            'text' => 'product deleted successfully!'
        ];
        echo "success";
    } else {
        $_SESSION['productdeleted'] = [
            'type' => 'danger',
            'text' => 'Failed to delete product. Please try again.'
        ];
        echo "Failed";
    }
} else {
    $_SESSION['productdeleted'] = [
        'type' => 'danger',
        'text' => 'Invalid Category ID'
    ];
    echo "invalid";
}
