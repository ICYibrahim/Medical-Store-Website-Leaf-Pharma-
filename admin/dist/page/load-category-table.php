<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;

$result = fetchtablewithlimit($limit, $offset, 'tbl_category');
$output = '';
if ($result && mysqli_num_rows($result) > 0) {
    $ctr = 1 + $offset; // Continue numbering from offset
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['category_id'];
        $category_image = $row['category_image'];


        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . $row['category_title'] . '</td>';
        $output .= '<td>' . ($row['category_image'] != "" ? '<img class="tableimg img-fluid" src="../assets/category/' . $row['category_image'] . '" alt="Category image">' : 'No Image') . '</td>';
        $output .= '<td>' . $row['featured'] . '</td>';
        $output .= '<td>' . $row['active'] . '</td>';
        $output .= '<td>
                <a href="update-category.php?id=' . $id . '&category_image=' . $category_image . '" class="btn btn-success m-md-2"><i class="fa-regular fa-pen-to-square"></i></a>
                <button class="btn btn-danger m-md-2 remove-btn-js" data-id ="' . $id . '" data-image="' . $category_image . '" data-url="delete-category.php" data-returnurl="manage-category.php"><i class="fa-regular fa-trash-can"></i></button>
                <button class="btn btn-success m-md-2 view-by-category" data-id="' . $id . '" data-url="view-category.php"><i class="fa-solid fa-arrow-right"></i></a>';
        $output .= '</td>
                    </tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}
// Get total records for pagination
$total_records = mysqli_num_rows(fetchtable('tbl_category'));
$total_pages = ceil($total_records / $limit);

// Return both HTML and pagination data
echo json_encode([
    'html' => $output,
    'total_pages' => $total_pages,
    'total_products' => $total_records,
    'current_page' => $page
]);
