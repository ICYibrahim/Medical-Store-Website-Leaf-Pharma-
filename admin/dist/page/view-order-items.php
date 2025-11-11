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
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">View Order items</h3>
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

            loadOrderitemstable(currentPage, limit,id);

            $("#myOrderDropdown").on("change", function() {
                limit = $(this).val();
                loadOrderitemstable(1, limit,id);
            });
            // $("#search").on("keyup", function() {
            //     currentSearchTerm = $(this).val().trim();
            //     if (currentSearchTerm.length >= 2) {
            //         isSearching = true;
            //         $.post("search-order.php", {
            //             search: currentSearchTerm
            //         }, function(data) {
            //             $("#orderitemstabledata").html(data);
            //             $("#pagination-container").empty();
            //         }).fail(function() {
            //             $("#orderitemstabledata").html('<tr><td colspan="11">Error loading search results</td></tr>');
            //         });
            //     } else {
            //         isSearching = false;
            //         loadOrderitemstable(1, limit);
            //     }
            // });
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if (!isSearching) {
                    currentPage = $(this).data('page');
                    loadOrderitemstable(currentPage, limit,id);
                }
            });
        });
    </script>
</body>

</html>