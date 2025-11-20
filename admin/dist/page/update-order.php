<?php
session_start();
include('../adminfunction/adminfunction.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['order_id']) && is_numeric($_POST['order_id'])) {
        // Get form data
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];
        $payment_status = $_POST['payment_status'];
        $shipping_method = $_POST['shipping_method'];

        // Validate required fields
        if (empty($order_status) || empty($payment_status)) {
            $_SESSION['orderupdated'] = [
                'type' => 'danger',
                'text' => 'Order status and payment status are required!'
            ];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Update order status
        $result = updateOrder($order_id, $order_status, 'tbl_orders');

        if ($result) {
            $_SESSION['orderupdated'] = [
                'type' => 'success',
                'text' => 'Order updated successfully!'
            ];
        } else {
            $_SESSION['orderupdated'] = [
                'type' => 'danger',
                'text' => 'Failed to update order status!'
            ];
        }
    } else {
        $_SESSION['orderupdated'] = [
            'type' => 'danger',
            'text' => 'Invalid order ID!'
        ];
        $_SESSION['error'] = "";
    }

    // Redirect back to the previous page
    header("Location: manage-orders.php");
    exit();
} else {
    $_SESSION['orderupdated'] = [
        'type' => 'danger',
        'text' => 'Invalid request method!'
    ];
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
