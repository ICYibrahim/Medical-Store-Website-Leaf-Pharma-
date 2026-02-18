<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$search = mysqli_real_escape_string($conn, $_POST['search'] ?? '');
$output = '';

$result = liveSearchProduct($search);

if ($result && mysqli_num_rows($result) > 0) {
    $ctr = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id']; // Product ID
        $product_image = $row['ProductImage']; // Define this properly

        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ItemCode']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ItemName']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['Company']) . '</td>';

        if (!empty($row['category_id']) && $row['category_id'] !== "0") {
            $category_id = $row['category_id'];
            $data = getcategorybyid($category_id, 'tbl_category');
            $categoryrow = mysqli_fetch_assoc($data);
            if ($categoryrow) {
                $output .= '<td>' . htmlspecialchars($categoryrow['category_title']) . '</td>';
            } else {
                $output .= '<td>No Category</td>';
            }
        } else {
            $output .= '<td>No Category</td>';
        }


        $output .= '<td>' . htmlspecialchars($row['SPrice']) . ' -Rs</td>';
        $output .= '<td>' . ($row['ProductImage'] != "" ? '<img class="tableimg img-fluid" src="../assets/products image/' . $row['ProductImage'] . '" alt="Category image">' : 'No Image') . '</td>';
        $output .= '<td>' . htmlspecialchars($row['ProductDiscription']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['featured']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['active']) . '</td>';
        $output .= '<td>
            <a href="update-products.php?id=' . $id . '&product_image=' . $product_image . '" class="btn btn-success m-md-2"><i class="fa-regular fa-pen-to-square"></i></a>
            <a href="delete-products.php?id=' . $id . '&product_image=' . $product_image . '" class="btn btn-danger m-md-2"><i class="fa-regular fa-trash-can"></i></a>
        </td>';
        $output .= '</tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found matching your search</td></tr>';
}

echo $output;
