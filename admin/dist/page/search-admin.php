<?php
include("includes/connection.php");
include('../adminfunction/adminfunction.php');

$search = mysqli_real_escape_string($conn, $_POST['search'] ?? '');
$output = '';

$result = liveSearchAdmin($search, 'tbl_admin');

if ($result && mysqli_num_rows($result) > 0) {
    $ctr = 1;
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
                <a href="delete-admin.php?id=' . $id . '" class="btn btn-danger m-md-2"><i class="fa-regular fa-trash-can"></i></a>';
        $output .= '</td>
        </tr>';
    }
} else {
    $output = '<tr class="align-middle"><td colspan="11">No products found</td></tr>';
}

echo $output;