<?php
ob_start();
session_start();
include('includes/headtag.php');
include('../adminfunction//adminfunction.php');
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- this is the header(Navbar) -->
        <?php
        include('includes/topnavbar.php');
        include('includes/sidenavbar.php');
        ?>

        <!-- the body star here -->
        <main class="app-main">
            <?php foreach (['categoryadded', 'categorydeleted', 'categoryupdated'] as $key) :
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
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Manage Categor</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Category</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                    <a href="Add-category.php" class="btn btn-primary mb-4">Add New Category</a>
                </div>
                <!--end::Container-->
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
                                            <th style="width: 10px">#</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th style="width: 50px">Featured</th>
                                            <th style="width: 40px">Active</th>
                                            <th style="width: 350px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabledata">
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

    <?php include('includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {

            // jQuery
            limit = $("#myDropdown").val();
            $("#myDropdown").on("change", function() {
                limit = $(this).val();
                loadcateogrytable(currentPage, limit);
            });
            let currentPage = 1;
            let isSearching = false;
            let currentSearchTerm = '';
            const itemsPerPage = limit; // Set this as a constant since you're using 25 items per page

            loadcateogrytable(currentPage, limit);

            // Handle search
            $("#search").on("keyup", function() {
                currentSearchTerm = $(this).val();
                if (currentSearchTerm.length >= 2 || currentSearchTerm.length == 0) {
                    isSearching = currentSearchTerm.length >= 2;
                    if (isSearching) {
                        $.ajax({
                            url: "search-category.php",
                            type: "POST",
                            data: {
                                search: currentSearchTerm
                            },
                            success: function(data) {
                                $("#tabledata").html(data);
                                $("#pagination-container").empty(); // Hide pagination during search
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error: " + status + " - " + error);
                                $("#tabledata").html('<tr><td colspan="11">Error loading search results</td></tr>');
                            }
                        });
                    } else {
                        // If search is cleared, reload normal paginated data
                        currentPage = 1;
                        loadcateogrytable(currentPage, limit);
                    }
                }
            });

            // Handle pagination clicks
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if (!isSearching) {
                    currentPage = $(this).data('page');
                    loadcateogrytable(currentPage, limit);
                }
            });
        });
    </script>
</body>

</html>