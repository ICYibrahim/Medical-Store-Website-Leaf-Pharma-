<?php include('includes/headtag.php'); ?>

<body>
    <?php
    include('includes/header.php');
    ?>
    <div class="container main mt-4">
        <div class="main-top row">
            <h4 class="fw-bold">Cart</h4>
            <p class="fs-4 numofitems"></p>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="cart-detail-wrapper">
                    <div class="cart-detail-top">
                        <h5>For Best Experience, Please <a href="" class="fs-semi-bold">LOG-IN</a></h5>
                    </div>
                    <div class="cart-detail-body">
                        <div class="cart-body-top d-flex justify-content-between">
                            <p class="fs-4 numofitems"> </p>
                            <button class="btn btn-success" id="continue_shopping" style="max-width: 200px; width: 100%; min-width:150px;">continue Shopping</button>
                        </div>
                        <div id="cart-item-area" class="cart-product-area">
                            <!-- cart product will come here thorugh ajax -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="summary-box-container-wrapper">
                    <div class="summary-box-container">
                        <h5 class="fw-bold mb-3">Order Summary</h5>
                        <p>Subtotal: <span class="numofitems"></span><span class="float-end Get_SubTotal_Price"></span></p>
                        <p>Delivery: <span class="float-end delivery_charge"></span></p>
                        <hr>
                        <p class="fw-bold">Total: <span class="float-end Get_Total_Price"></span></p>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#checkoutModal" class="btn btn-success w-100 mt-3" id="checkout-button" disabled>Proceed to Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="checkoutModalLabel"> Place Your Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body checkout-model row">
                    <div class="col-sm-6 col-md-8 checkout-form-wrapper">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter Last Name (Optional)" id="lastname" name="lastname (optional)">
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Your Address" required>
                            </div>
                            <div class="col-6">
                                <label for="phonenumber" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="phonenumber" name="phonenumber" placeholder="Enter Your Phone Number" required>
                            </div>
                            <div class="col-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email Adress (Optional)">
                            </div>
                            <div class="col-12">
                                <label for="payment_method" class="form-label">Select Payment Method</label>
                                <select class="form-select" name="payment_method" id="payment_method" aria-label="Default select example" required>
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="CARD" disabled>Payment Via a card</option>
                                    <option value="COD">Cash on Dilevery</option>
                                    <option value="LOCAL" disabled>EasyPaisa / Jazz Cash</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6">
                                <label for="monument" class="form-label">Famous Monument</label>
                                <input type="text" class="form-control" id="monument" name="monument" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember Me For later
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Place Order</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="summary-box-container-wrapper">
                            <div class="summary-box-container">
                                <h5 class="fw-bold mb-3">Order Summary</h5>
                                <p>Subtotal: <span class="numofitems"></span><span class="float-end Get_SubTotal_Price"></span></p>
                                <p>Delivery: <span class="float-end delivery_charge">0</span></p>
                                <hr>
                                <p class="fw-bold">Total: <span class="float-end Get_Total_Price"></span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/scripttag.php');
    ?>
</body>

</html>