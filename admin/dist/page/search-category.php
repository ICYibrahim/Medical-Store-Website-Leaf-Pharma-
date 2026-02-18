<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$search = mysqli_real_escape_string($conn, $_POST['search'] ?? '');
$output = '';

$result = liveSearchCategory($search, 'tbl_category');

if ($result && mysqli_num_rows($result) > 0) {
    $ctr = 1;
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
                <button class="btn btn-success m-md-2 view-by-category" data-id="' . $id . '"><i class="fa-solid fa-arrow-right"></i></a>';
        $output .= '</td>
                    </tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}
echo $output;