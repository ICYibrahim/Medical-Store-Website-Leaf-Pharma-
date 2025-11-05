<?php
include('includes/headtag.php');
include('../adminfunction/adminfunction.php');
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header + Navbar + Sidebar -->
        <?php include('includes/topnavbar.php'); ?>
        <?php include('includes/sidenavbar.php'); ?>

        <!-- Main Content -->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Category Name</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="manage-category.php">Manage Category</a></li>
                                <li class="breadcrumb-item active">View Category Product</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <label for="myDropdown" class="me-2 mb-0">Rows:</label>
                                <select id="myDropdown" class="form-select form-select-sm w-auto">
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
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Company</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Product Image</th>
                                            <th>Description</th>
                                            <th>Featured</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="producttabledata">
                                        <!-- AJAX Loads rows here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 justify-content-center" id="pagination-container"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content-->
        </main>

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>
    </div>

    <!-- Scripts -->
    <?php include('includes/scripts.php'); ?>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const categoryid = urlParams.get('categoryid');
            let currentPage = 1;
            let limit = $("#myDropdown").val();
            let isSearching = false;
            let currentSearchTerm = '';
            viewproductbycategory(currentPage, limit, categoryid);

            $("#myDropdown").on("change", function() {
                limit = $(this).val();
                viewproductbycategory(1, limit, categoryid);
            });

            $("#search").on("keyup", function() {
                currentSearchTerm = $(this).val().trim();
                if (currentSearchTerm.length >= 2) {
                    isSearching = true;
                    $.post("search-product-in-category.php", {
                        search: currentSearchTerm,
                        category_id: categoryid
                    }, function(data) {
                        $("#producttabledata").html(data);
                        $("#pagination-container").empty();
                    }).fail(function() {
                        $("#producttabledata").html('<tr><td colspan="11">Error loading search results</td></tr>');
                    });
                } else {
                    isSearching = false;
                    viewproductbycategory(1, limit, categoryid);
                }
            });
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if (!isSearching) {
                    currentPage = $(this).data('page');
                    viewproductbycategory(currentPage, limit, categoryid);
                }
            });
        });
    </script>
</body>

</html>