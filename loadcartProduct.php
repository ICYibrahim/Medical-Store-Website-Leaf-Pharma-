<?php
include('userfunction/myfunction.php');

$output = "";
$result = fetchcartitemsbycartid('tbl_cart', $cartID);

if ($result && mysqli_num_rows($result) > 0) {
    while ($cartitem = mysqli_fetch_assoc($result)) {
        $output .= '
        <div class="container-fluid">
            <div class="row cart-item align-items-center mb-3 p-2 border rounded get-pcode-wrapper" data-pcode="' . $cartitem['ProductCode'] . '">
                <!-- Product Image -->
                <div class="col-4 item-img">
                    <img src="admin/dist/assets/products image/' . $cartitem['ProductImage'] . '" alt="Product Image" class="img-fluid rounded">
                </div>

                <!-- Product Details & Buttons -->
                <div class="col-8 item-detail-wrapper d-flex flex-column justify-content-between">
                    <div class="item-detail">
                        <h6 class="mb-1">' . $cartitem['ProductName'] . '</h6>
                        <p class="mb-2 text-muted">Rs: ' . number_format($cartitem['ProductPrice'], 2) . '</p>
                    </div>

                    <!-- Quantity Controls -->
                    <div class="item-detail-btns d-flex align-items-center justify-content-between">
                        <div class="quantity-controls d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-success qty-btn minus">−</button>
                            <input type="number" class="form-control qty-input mx-1" value="' . $cartitem['Quantity'] . '" min="1">
                            <button class="btn btn-sm btn-outline-success qty-btn plus">+</button>
                        </div>

                        <!-- Remove Button -->
                        <div  class=" ms-2 remove-cart-item" data-productcode = ' . $cartitem['ProductCode'] . ' title="Remove">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
}

echo $output;
