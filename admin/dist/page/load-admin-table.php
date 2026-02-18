<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;
$result = fetchtablewithlimit($limit, $offset, 'tbl_admin');
$output = '';
if ($result && mysqli_num_rows($result) > 0) {
    $ctr = 1 + $offset; // Continue numbering from offset
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];


        $output .= '<tr class="align-middle">';
        $output .= '<td>' . $ctr++ . '</td>';
        $output .= '<td>' . $row['fullname'] . '</td>';
        $output .= '<td>' . $row['username'] . '</td>';
        $output .= '<td>';
        $output .= '
                <a href="update-password.php?id=' . $id . '" class="btn btn-info m-md-2"><i class="fa-solid fa-user-pen"></i></a>
                <a href="update-admin.php?id=' . $id . '" class="btn btn-success m-md-2"><i class="fa-regular fa-pen-to-square"></i></a>
                <button class="btn btn-danger m-md-2 remove-btn-js" data-id="' . $id . '" data-url="delete-admin.php" data-returnurl="manage-admin.php"><i class="fa-regular fa-trash-can"></i></button>';
        $output .= '</td>
        </tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}
// Get total records for pagination
$total_records = mysqli_num_rows(fetchtable('tbl_admin'));
$total_pages = ceil($total_records / $limit);

// Return both HTML and pagination data
echo json_encode([
    'html' => $output,
    'total_pages' => $total_pages,
    'total_products' => $total_records,
    'current_page' => $page
]);
