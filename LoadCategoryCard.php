<?php
include('userfunction/myfunction.php');
$output = "";
$result = fetchcategorycards("tbl_category");
if ($result && mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '  <div class="category-card" data-categoryID = "' . $row['category_id'] . '">
                    <img src="admin/dist/assets/category/' . $row['category_image'] . '">
                    <div class="category-card-body">
                        <div class="card-body-content">
                            <h3 class="category-card-title">' . $row['category_title'] . '</h3>
                            <h6 class="category-card-sub-title">Category</h6>
                            <p class="category-card-info">Lorem ipsum dolor sit amet consectetur. this is just a sdemo typing to check if the text is begin under each otehr </p>
                        </div>
                        <div class="card-btn-wrapper">
                            <button class="card-btn view-btn" data-categoryid = "' . $row['category_id'] . '" data-limit = "12">View</button>
                        </div>
                    </div>
                </div>';
    }
}
echo $output;
