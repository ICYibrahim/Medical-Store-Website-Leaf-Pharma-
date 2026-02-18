<?php

include('userfunction/myfunction.php');
$output = "";
$result = fetchcartitemsbycartid('tbl_cart', $cartID);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<div class="checkout-cart-Product get-pcode-wrapper" data-pcode="' . $row['ProductCode'] . '">
                        <div class="row">
                            <div class="col-4">
                                <!-- Image -->
                                <img src="admin/dist/assets/products image/' . $row['ProductImage'] . '" alt="Product Image">
                            </div>
                            <div class="col-8">
                                    <h3>' . htmlspecialchars($row['ProductName']) . '</h3>
                                    <p>' . number_format(htmlspecialchars($row['ProductPrice']), 2) . '<span style="font-weight: 500; font-size: 14px;"> PKR</span></p>
                                    <div class="quantity-controls d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-success qty-btn minus">−</button>
                                        <input type="number" class="form-control qty-input mx-1" value="' . $row['Quantity'] . '" min="1">
                                        <button class="btn btn-sm btn-outline-success qty-btn plus">+</button>
                                    </div>
                            </div>
                        </div>

                        <!-- ✅ Correct: Cross icon OUTSIDE .row -->
                        <i class="fa-solid fa-xmark cross-remove remove-cart-item" data-productcode = ' . $row['ProductCode'] . '></i>
                        <i class="fa-solid fa-heart-circle-plus add-to-favorait"></i>
                    </div>';
    }
} else {
    $output = '<div class="text-center py-3 text-muted">No Item in the Cart.</div>';
}
echo $output;
