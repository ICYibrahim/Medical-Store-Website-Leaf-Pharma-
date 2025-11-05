<?php
// included the connection 
include('includes/connection.php');

// Create SQL queries

// used in add-adminpage.php to add the new admin at the DB.
function addadmin($fullname, $username, $password, $table)
{
    global $conn;
    $sql = "INSERT INTO $table SET fullname = '$fullname', username='$username', password='$password'";
    return mysqli_query($conn, $sql);
}

// used in Add-category.php to add new category at the DB
function addcategory($title, $image, $feature, $active, $table)
{
    global $conn;
    $sql = "INSERT INTO $table SET category_title = '$title', category_image = '$image', featured='$feature', active='$active'";
    return mysqli_query($conn, $sql);
}

// used in Add-produts.php to add new products at the DB
function addproduct($productname, $ItemCode, $companyname, $productprice, $productcategory, $productimage_name, $productdisc, $featured, $active, $table)
{
    global $conn;
    $sql = "INSERT INTO $table SET ItemName = '$productname', ItemCode = '$ItemCode',Company = '$companyname', SPrice = '$productprice', category_id = '$productcategory', ProductImage = '$productimage_name' ,ProductDiscription = '$productdisc', featured ='$featured', active = '$active'";
    return mysqli_query($conn, $sql);
}

// fetch SQL Queries

// used to fetch the table with the concept of pagination

function fetchtablewithlimit($limit, $offset, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table LIMIT $offset,$limit";
    return mysqli_query($conn, $sql);
}
function fetchtablebycategorywithlimit($limit, $offset, $categoryid, $table)
{
    global $conn;
    $limit = (int)$limit;
    $offset = (int)$offset;
    $categoryid = (int)$categoryid;
    if ($categoryid <= 0) {
        return false;
    }
    $sql = "SELECT * FROM $table WHERE category_id = $categoryid LIMIT $offset,$limit";
    return mysqli_query($conn, $sql);
}
// used in manage-admin.php to show admin table
function fetchtable($table)
{
    global $conn;
    $sql = "SELECT * FROM $table";
    return mysqli_query($conn, $sql);
}

function fetchtablebycategory($table, $categoryid)
{
    global $conn;
    $categoryid = (int)$categoryid;
    if ($categoryid <= 0) {
        return false;
    }
    $sql = "SELECT * FROM $table WHERE category_id = $categoryid";
    return mysqli_query($conn, $sql);
}
// used in Add-products.php to show category list in field
function fetchcategorytablebyactive($table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE active = 'Yes'";
    return mysqli_query($conn, $sql);
}

// Update SQL Queries

//used in update-admin.php to update the admin.
function updateadmin($id, $fullname, $username, $table)
{
    global $conn;
    $sql = "UPDATE $table SET fullname = '$fullname', username='$username' WHERE id = $id";
    return mysqli_query($conn, $sql);
}

//used in update-category.php to update the category.
function updatecategory($categoryid, $categorytitle, $newcategoryimage, $featured, $active, $table)
{
    global $conn;
    $sql = "UPDATE $table SET category_title = '$categorytitle', category_image='$newcategoryimage', featured = '$featured', active='$active' WHERE category_id = $categoryid";
    return mysqli_query($conn, $sql);
}

// used in update-password.php to update the password of the admin
function updateadminpass($id, $password, $table)
{
    global $conn;
    $sql = "UPDATE $table SET password = '$password' WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}

//used in update-products.php to update the product
function updateproduct($id, $productname, $ItemCode, $companyname, $productprice, $productcategory, $productimage_name, $productdisc, $featured, $active, $table)
{
    global $conn;
    $sql = "UPDATE $table SET ItemName = '$productname', ItemCode = '$ItemCode',Company = '$companyname', SPrice = '$productprice', category_id = '$productcategory', ProductImage = '$productimage_name' ,ProductDiscription = '$productdisc', featured ='$featured', active = '$active' WHERE id = $id";
    return mysqli_query($conn, $sql);
}

// Delete queries

// used in delete-admin.php & delete-products.php to delete the admin $ products (respectively).
function DeleteTableRow($id, $table)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id); // Security fix
    $table = mysqli_real_escape_string($conn, $table); // Security fix
    $sql = "DELETE FROM $table WHERE id=$id"; // Fixed SQL syntax
    return mysqli_query($conn, $sql);
}

// used in delete-categoy.php to delete the category.
function DeleteCategoryRow($id, $table)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id); // Security fix
    $table = mysqli_real_escape_string($conn, $table); // Security fix
    $sql = "DELETE FROM $table WHERE category_id=$id"; // Fixed SQL syntax
    return mysqli_query($conn, $sql);
}

function gettablebyid($id, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE id=$id";
    return mysqli_query($conn, $sql);
}
function getcategorybyid($id, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE category_id=$id";
    return mysqli_query($conn, $sql);
}
function getadminbyuser($username, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE username='$username'";
    return mysqli_query($conn, $sql);
}

// live search SQL Queries

// admin page
function liveSearchAdmin($search_item, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE fullname LIKE '%{$search_item}%' OR username LIKE '%{$search_item}%'";
    return mysqli_query($conn, $sql);
}
// category page
function liveSearchCategory($search_item, $table)
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE category_title LIKE '%{$search_item}%'";
    return mysqli_query($conn, $sql);
}
// product page
function liveSearchProduct($search_item)
{
    global $conn;
    $sql = "SELECT p.* FROM tbl_products p LEFT JOIN tbl_category c ON p.category_id = c.category_id WHERE ( p.ItemName LIKE '%{$search_item}%' OR p.Company LIKE '%{$search_item}%' OR c.category_title LIKE '%{$search_item}%')";
    return mysqli_query($conn, $sql);
}
// product page in category
function liveSearchProductincategory($search_item,$categoryid)
{
    global $conn;
    $sql = "SELECT * FROM tbl_products  WHERE ( ItemName LIKE '%{$search_item}%' OR Company LIKE '%{$search_item}%') AND category_id = $categoryid ";
    return mysqli_query($conn, $sql);
}