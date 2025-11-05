<?php
include('userfunction/myfunction.php');

if (isset($_POST['pcode']) && is_numeric($_POST['pcode'])) {
    $pcode = intval($_POST['pcode']); // sanitize to integer
    $result = RemoveCartItem($pcode, $cartID, 'tbl_cart');
    echo $result ? 'success' : 'error';
} else {
    echo 'invalid';
}
