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
    $sql = "SELECT * FROM $table WHERE ItemName='$product_slug' AND id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function LoadProductByCategory($categoryid, $limit)
{
    global $conn;

    // Validate and sanitize inputs
    $categoryid = (int)$categoryid;
    $limit = (int)$limit;

    // Using prepared statement to prevent SQL injection
    $sql = "SELECT p.*, c.category_title FROM tbl_products p INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE p.category_id = $categoryid AND p.featured = 'Yes' AND p.active = 'Yes' ORDER BY RAND() LIMIT $limit";
    return mysqli_query($conn, $sql);
}
function viewCategorypage($categoryid, $limit, $offset)
{
    global $conn;

    // Validate and sanitize inputs
    $offset = (int)$offset;
    $categoryid = (int)$categoryid;
    $limit = (int)$limit;

    // Using prepared statement to prevent SQL injection
    $sql = "SELECT p.*, c.category_title 
            FROM tbl_products p 
            INNER JOIN tbl_category c ON p.category_id = c.category_id 
            WHERE p.category_id = $categoryid AND p.active = 'Yes' 
            LIMIT  $offset,$limit";
    return mysqli_query($conn, $sql);
}
function fetchrelatedproduct($categoryid, $productid, $productname, $limit)
{
    global $conn;

    $categoryid = (int)$categoryid;
    $productid = (int)$productid;
    $limit = (int)$limit;

    // Escape the product name for safety
    $productname = mysqli_real_escape_string($conn, $productname);

    $sql = "SELECT p.* FROM tbl_products p  INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE p.category_id = $categoryid AND p.active = 'Yes'   AND p.id != $productid  AND ( p.ItemName LIKE '%$productname%' OR 1=1) ORDER BY CASE WHEN p.ItemName LIKE '%$productname%' THEN 0 ELSE 1 END, RAND() LIMIT $limit";
    return mysqli_query($conn, $sql);
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
    // Use correct column name 'Quantity' and escape values
    $code = mysqli_real_escape_string($conn, $code);
    $sql = "UPDATE $table SET Quantity = $qty WHERE cartID = '$cartID' AND ProductCode = '$code'";
    return mysqli_query($conn, $sql);
}

function uploaditemincart($code, $name, $price, $image, $pqty, $cartID, $table)
{
    global $conn;
    // Use correct column names and escape all string values
    $code = mysqli_real_escape_string($conn, $code);
    $name = mysqli_real_escape_string($conn, $name);
    $image = mysqli_real_escape_string($conn, $image);

    $sql = "INSERT INTO $table ( ProductCode, ProductName, ProductPrice, ProductImage, Quantity ,cartID) 
            VALUES ('$code', '$name', $price, '$image', $pqty,'$cartID')";
    return mysqli_query($conn, $sql);
}

function RemoveCartItem($pcode, $cartID, $table)
{
    $pcode = (int)$pcode;
    global $conn;
    $sql = "DELETE FROM $table WHERE cartID = '$cartID' AND ProductCode = $pcode";
    return mysqli_query($conn, $sql);
}

// For live Search 

function liveSearchProduct($searcheditem)
{
    global $conn;
    $sql = "SELECT p.*,c.category_id FROM tbl_products p INNER JOIN tbl_category c ON p.category_id = c.category_id WHERE (p.ItemName LIKE '%{$searcheditem}%' OR p.Company LIKE '%{$searcheditem}%' OR c.category_title LIKE '%{$searcheditem}%') AND p.active = 'Yes'";
    return mysqli_query($conn, $sql);
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
