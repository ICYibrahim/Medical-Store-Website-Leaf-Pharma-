<?php
// this file has the connection to the database 
include('includes/connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['cart_id'])) {
    $_SESSION['cart_id'] = session_id(); // or generate a random ID
}
$cartID = $_SESSION['cart_id'];
// below funtion is for show single prodcut page 
function getslugactive($id, $product_slug, $table)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM $table WHERE ItemName=? AND id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "si", $product_slug, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function LoadProductByCategory($categoryid, $limit)
{
    global $conn;
    // Validate inputs
    $categoryid = (int)$categoryid;
    $limit = (int)$limit;

    $stmt = mysqli_prepare($conn, "SELECT p.*, c.category_title FROM tbl_products p INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE p.category_id = ? AND p.featured = 'Yes' AND p.active = 'Yes' ORDER BY RAND() LIMIT ?");
    mysqli_stmt_bind_param($stmt, "ii", $categoryid, $limit);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function viewCategorypage($categoryid, $limit, $offset)
{
    global $conn;

    // Validate inputs
    $offset = (int)$offset;
    $categoryid = (int)$categoryid;
    $limit = (int)$limit;

    $stmt = mysqli_prepare($conn, "SELECT p.*, c.category_title 
            FROM tbl_products p 
            INNER JOIN tbl_category c ON p.category_id = c.category_id 
            WHERE p.category_id = ? AND p.active = 'Yes' 
            LIMIT ?, ?");
    mysqli_stmt_bind_param($stmt, "iii", $categoryid, $offset, $limit);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function fetchrelatedproduct($categoryid, $productid, $productname, $limit)
{
    global $conn;

    $categoryid = (int)$categoryid;
    $productid = (int)$productid;
    $limit = (int)$limit;
    
    // For LIKE pattern matching
    $searchPattern = '%' . $productname . '%';

    $stmt = mysqli_prepare($conn, "SELECT p.* FROM tbl_products p INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE p.category_id = ? AND p.active = 'Yes' AND p.id != ? AND (p.ItemName LIKE ? OR 1=1) ORDER BY CASE WHEN p.ItemName LIKE ? THEN 0 ELSE 1 END, RAND() LIMIT ?");
    
    // Note: The original query had OR 1=1 which basically negates the LIKE check for filtering but keeps it for ordering. 
    // And binding the same parameter twice for the LIKE clause.
    mysqli_stmt_bind_param($stmt, "iissi", $categoryid, $productid, $searchPattern, $searchPattern, $limit);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// below function is for fetching the product 
function fetchproduct($table)
{
    global $conn;
    $table = mysqli_real_escape_string($conn, $table);
    $sql = "SELECT * FROM $table";
    return mysqli_query($conn, $sql);
}
function fetchcartitemsbycartid($table, $cartID)
{
    global $conn;
    $table = mysqli_real_escape_string($conn, $table);
    $sql = "SELECT * FROM $table WHERE cartID = '$cartID'";
    return mysqli_query($conn, $sql);
}
function fatchallcategory($table)
{
    global $conn;
    $table = mysqli_real_escape_string($conn, $table);
    $sql = "SELECT * FROM $table WHERE Orderby > 0 AND active = 'Yes' ORDER BY `Orderby` ASC";
    return mysqli_query($conn, $sql);
}
function fetchcategorycards($table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE featured = 'Yes' && active = 'Yes'";
    return mysqli_query($conn, $sql);
}
function countproductbycategoryid($categoryid)
{
    global $conn;
    $sql = "SELECT * FROM tbl_products WHERE category_id = $categoryid AND active = 'Yes'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result);
}

// fetch all cart items

function updatecartqty($qty, $code, $cartID, $table)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE $table SET Quantity = ? WHERE cartID = ? AND ProductCode = ?");
    mysqli_stmt_bind_param($stmt, "iss", $qty, $cartID, $code);
    mysqli_stmt_execute($stmt);
    return true; 
}

function uploaditemincart($code, $name, $price, $image, $pqty, $cartID, $table)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "INSERT INTO $table (ProductCode, ProductName, ProductPrice, ProductImage, Quantity, cartID) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdsis", $code, $name, $price, $image, $pqty, $cartID);
    mysqli_stmt_execute($stmt);
    return true;
}

function RemoveCartItem($pcode, $cartID, $table)
{
    global $conn;
    $pcode = (int)$pcode;
    $stmt = mysqli_prepare($conn, "DELETE FROM $table WHERE cartID = ? AND ProductCode = ?");
    mysqli_stmt_bind_param($stmt, "si", $cartID, $pcode);
    mysqli_stmt_execute($stmt);
    return true;
}

// For live Search 

function liveSearchProduct($searcheditem)
{
    global $conn;
    $searchPattern = '%' . $searcheditem . '%';
    $stmt = mysqli_prepare($conn, "SELECT p.*,c.category_id FROM tbl_products p INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE (p.ItemName LIKE ? OR p.Company LIKE ? OR c.category_title LIKE ?) AND p.active = 'Yes'");
    mysqli_stmt_bind_param($stmt, "sss", $searchPattern, $searchPattern, $searchPattern);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function fetchcartitemsforjs()
{
    global $conn;
}
function placeorder($grand_total_amount, $payment_method, $shipping_address, $phone, $email, $customer_name, $table)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO $table (customer_name, email, phone, shipping_address, payment_method, grand_total_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $customer_name, $email, $phone, $shipping_address, $payment_method, $grand_total_amount);
    $stmt->execute();

    return $stmt->insert_id;
}
function insertOrderItem($cartID, $order_id, $product_id, $product_name, $quantity, $unit_price, $S_product_total_price, $subtotal_price, $delivery_price, $grand_total, $table)
{
    global $conn;

    $stmt = $conn->prepare(
        "INSERT INTO $table (order_id, product_id, product_name, quantity, unit_price, S_product_total_price,subtotal_price,delivery_price,grand_total_price) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param("iisiddddd", $order_id, $product_id, $product_name, $quantity, $unit_price, $S_product_total_price, $subtotal_price, $delivery_price, $grand_total);
    $stmt->execute();
    $stmt->close();
}
