<?php
ob_start();
session_reset();
include('includes/headtag.php');
include('../adminfunction//adminfunction.php');
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- this is the header(Navbar) -->
        <?php
        include('includes/topnavbar.php');
        include('includes/sidenavbar.php');
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $order_id = $_GET['id'];
            $customer = $_GET['customer'];
            $orderdate = $_GET['orderdate'];
            $status = $_GET['status'];
            $paymentMethod = $_GET['paymentMethod'];
            $shippingAddress = $_GET['shippingAddress'];
            $contact = $_GET['contact'];
            $paymentstatus = $_GET['paymentstatus'];

            $shippingmethod =  isset($_GET['shippingmethod']) ? $_GET['shippingmethod'] : "";
        } else {
            header('Location: manage-orders.php');
            exit();
        }
        ?>

        <!-- the body star here -->
        <main class="app-main">
            <!-- Alerts -->
            <?php foreach (['orderupdated'] as $key) :
                if (isset($_SESSION[$key])) :
                    $msg = $_SESSION[$key]; ?>
                    <div class="alert alert-<?= htmlspecialchars($msg['type']) ?> alert-dismissible fade show" role="alert">
                        <strong><?= htmlspecialchars($msg['text']) ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php unset($_SESSION[$key]);
                endif;
            endforeach; ?>
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Order #<?php echo $order_id; ?> Details</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="manage-orders.php">Manage Orders</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Order Items</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">

                    <!-- Order Summary Card -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                                            <p><strong>Order Date:</strong> <?php echo $orderdate; ?></p>
                                            <p><strong>Customer Name:</strong> <?php echo $customer ?></p>
                                            <p><strong>Contact:</strong> <?php echo $contact ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong>
                                                <span class="badge bg-warning text-dark"><?php echo $status ?></span>
                                            </p>
                                            <p><strong>Payment Method:</strong> <?php echo $paymentMethod ?></p>
                                            <p><strong>Shipping Address:</strong> <?php echo $shippingAddress ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div id="order-items-summary" class="card shadow-sm">
                                <!-- ajax will give summary -->
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <label for="myDropdown" class="me-2 mb-0">Rows:</label>
                                <select id="myOrderDropdown" class="form-select form-select-sm w-auto">
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Product x Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderitemstabledata">
                                        <!-- AJAX Loads rows here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 justify-content-center" id="pagination-container">

                            </ul>
                        </div>
                    </div>
                    <!-- Order Actions Card -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fas fa-cogs me-2"></i>Order Actions</h5>
                        </div>
                        <div class="card-body">
                            <form action="update-order.php" method="POST" id="orderStatusForm">
                                <!-- Add a hidden field for order ID -->
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="orderStatus" class="form-label">Order Status</label>
                                        <select class="form-select" id="orderStatus" name="order_status">
                                            <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo $status == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="processing" <?php echo $status == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="shipped" <?php echo $status == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                            <option value="delivered" <?php echo $status == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="paymentStatus" class="form-label">Payment Status</label>
                                        <select class="form-select" id="paymentStatus" name="payment_status">
                                            <option value="pending" <?php echo $paymentstatus == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="paid" <?php echo $paymentstatus == 'paid' ? 'selected' : ''; ?>>Paid</option>
                                            <option value="failed" <?php echo $paymentstatus == 'failed' ? 'selected' : ''; ?>>Failed</option>
                                            <option value="refunded" <?php echo $paymentstatus == 'refunded' ? 'selected' : ''; ?>>Refunded</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="shippingMethod" class="form-label">Shipping Method</label>
                                        <select class="form-select" id="shippingMethod" name="shipping_method">
                                            <option value="standard" <?php echo $shippingmethod == 'standard' ? 'selected' : ''; ?>>Standard Shipping</option>
                                            <option value="express" <?php echo $shippingmethod == 'express' ? 'selected' : ''; ?>>Express Shipping</option>
                                            <option value="pickup" <?php echo $shippingmethod == 'pickup' ? 'selected' : ''; ?>>Store Pickup</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-1"></i>Update Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- the body star here -->
        </main>
        <!-- this is the footer -->
        <?php include('includes/footer.php'); ?>
    </div>
    <!-- Bootstrap JavaScript CDN Link -->
    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            let currentPage = 1;
            let limit = $("#myOrderDropdown").val();
            let isSearching = false;
            let currentSearchTerm = '';

            loadOrderitemstable(currentPage, limit, id);

            $("#myOrderDropdown").on("change", function() {
                limit = $(this).val();
                loadOrderitemstable(1, limit, id);
            });
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if (!isSearching) {
                    currentPage = $(this).data('page');
                    loadOrderitemstable(currentPage, limit, id);
                }
            });
        });
    </script>
</body>

</html>