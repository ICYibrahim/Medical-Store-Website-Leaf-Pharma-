<?php
include('userfunction/myfunction.php');
if (isset($_POST['pid']) && is_numeric($_POST['pid'])) {
    // Sanitize inputs (don't cast product code to int if it's a barcode)
    $id = (int)$_POST['pid'];
    $pcode = $_POST['pcode']; // Keep as string for barcode
    $pname = $_POST['pname'];
    $pprice = (float)$_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pqty = isset($_POST['pqty']) ? (int)$_POST['pqty'] : 1;

    $cartrst = fetchcartitemsbycartid('tbl_cart', $cartID);
    $product_exists = false;

    if ($cartrst && mysqli_num_rows($cartrst) > 0) {
        while ($cartrow = mysqli_fetch_assoc($cartrst)) {
            // Compare as strings since it's a barcode
            if ($pcode === $cartrow['ProductCode']) {
                $dbqty = $cartrow['Quantity']; // Corrected spelling
                $newqty = $dbqty + $pqty;
                updatecartqty($newqty, $pcode, $cartID, 'tbl_cart');
                $product_exists = true;
                break;
            }
        }
    }

    if (!$product_exists) {
        uploaditemincart($pcode, $pname, $pprice, $pimage, $pqty, $cartID, 'tbl_cart');
    }
}
