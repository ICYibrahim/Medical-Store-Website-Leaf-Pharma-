<?php
ob_start();
include('includes/headtag.php'); ?>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include('includes/header.php');
    // Check if order was placed
    if (!isset($_SESSION['order_confirmation'])) {
        header('Location: index.php');
        exit();
    }

    $order = $_SESSION['order_confirmation'];
    ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="order-card shadow-lg border-0">
                    <div class="card-header bg-success text-white text-center">
                        <h2 class="mb-0 py-2">🎉 Order Placed Successfully!</h2>
                    </div>
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            <h3 class="text-success mt-3">Thank You for Your Order!</h3>
                            <p class="lead">Your order has been confirmed and will be processed shortly.</p>
                        </div>

                        <!-- Order Summary -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="order-details bg-light p-4 rounded mb-4 text-start">
                                    <h5 class="text-center mb-3">Order Information</h5>
                                    <p><strong>Order ID:</strong> #<?php echo $order['order_id']; ?></p>
                                    <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                                    <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                                    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="summary-info bg-light p-4 rounded mb-4 text-start">
                                    <h5 class="text-center mb-3">Order Summary</h5>
                                    <p><strong>Subtotal:</strong> Rs <?php echo number_format($order['subtotal_amount'], 2); ?></p>
                                    <p><strong>Delivery Charge:</strong> Rs <?php echo number_format($order['delivery_charge'], 2); ?></p>
                                    <p><strong class="fs-5">Total Amount:</strong> Rs <?php echo number_format($order['total_amount'], 2); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Purchased Items Table -->
                        <div class="purchased-items mt-4">
                            <h5 class="text-center mb-4">Purchased Items</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($order['purchased_items']) && !empty($order['purchased_items'])): ?>
                                            <?php foreach ($order['purchased_items'] as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                                    <td class="text-end">Rs <?php echo number_format($item['unit_price'], 2); ?></td>
                                                    <td class="text-end">Rs <?php echo number_format($item['item_total'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No items found in this order.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mt-4 text-center">
                            <p>You will receive a confirmation call shortly.</p>
                            <p>For any queries, contact us at: <strong>+92 XXX XXXXXXX</strong></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center mt-5">
                            <a href="index.php" class="btn btn-primary me-3">
                                <i class="fas fa-home me-2"></i>Continue Shopping
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="fas fa-print me-2"></i>Print Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Clear the confirmation after displaying
    unset($_SESSION['order_confirmation']);
    include('includes/footer.php');
    ob_end_flush();
    ?>
</body>

</html>