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
        include('includes/sidenavbar.php'); ?>

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
                            <h3 class="mb-0">Manage Orders</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Orders</li>
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

                            <div class="ms-auto">
                                <input class="form-control form-control-sm" type="text" id="search" placeholder="Search..." />
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Custumer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Shipping Address</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordertabledata">
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
            let currentPage = 1;
            let limit = $("#myOrderDropdown").val();
            let isSearching = false;
            let currentSearchTerm = '';

            loadOrderstable(currentPage, limit);

            $("#myOrderDropdown").on("change", function() {
                limit = $(this).val();
                loadOrderstable(1, limit);
            });

            $("#search").on("keyup", function() {
                currentSearchTerm = $(this).val().trim();
                if (currentSearchTerm.length >= 2) {
                    isSearching = true;
                    $.post("search-order.php", {
                        search: currentSearchTerm
                    }, function(data) {
                        $("#ordertabledata").html(data);
                        $("#pagination-container").empty();
                    }).fail(function() {
                        $("#ordertabledata").html('<tr><td colspan="11">Error loading search results</td></tr>');
                    });
                } else {
                    isSearching = false;
                    loadOrderstable(1, limit);
                }
            });
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if (!isSearching) {
                    currentPage = $(this).data('page');
                    loadOrderstable(currentPage, limit);
                }
            });
        });
    </script>
</body>

</html>