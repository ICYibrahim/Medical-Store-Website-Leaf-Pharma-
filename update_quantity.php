<?php
include('userfunction/myfunction.php');

if (isset($_POST['pcode']) && isset($_POST['qty'])) {
    $pcode = $_POST['pcode'];
    $qty = (int)$_POST['qty'];

    // You already have this function, reusing it
    updatecartqty($qty, $pcode, $cartID, 'tbl_cart');

    echo 'success';
} else {
    echo 'invalid';
}
