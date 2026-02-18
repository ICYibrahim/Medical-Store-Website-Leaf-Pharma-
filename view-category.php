<?php include('includes/headtag.php'); ?>

<body>
    <?php
    include('includes/header.php');
    ?>
    <div class="all-category container-fluid mb-4 px-5">
        <div class="category-head">
            <div
                class="top-category d-flex justify-content-between align-items-center flex-wrap">
                <h1 class="mb-2 mb-sm-0 category-title">Shop By Category</h1>
            </div>
            <hr>
        </div>
        <div class="category-main mt-3 mb-3">
            <div
                class="top-category d-flex justify-content-between align-items-center flex-wrap">
                <h1 class="mb-2 mb-sm-0 category-title " id="category-title"></h1>
            </div>
            <div id="viewcategorydata" class="list-side-scroll d-flex flex-wrap justify-content-center mt-4 row-gap-3 gap-1">
                <!-- view category data will be shown here -->
            </div>
        </div>
        <div class="category-footer d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="llpagination">
                    <!-- Will be replaced by AJAX -->
                </ul>
            </nav>
        </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/scripttag.php');
    ?>
</body>

<script>
    $(document).ready(function() {
        let limit = 12;
        let currentPage = 1;
        let isLoading = false;
        let allLoadedProducts = '';

        const urlParams = new URLSearchParams(window.location.search);
        const categoryid = urlParams.get('categoryid');
        currentPage = parseInt(urlParams.get('page')) || 1;

        // Check if we have stored products in sessionStorage
        const storedProducts = sessionStorage.getItem(`categoryProducts_${categoryid}`);
        const storedCategoryTitle = sessionStorage.getItem(`categoryTitle_${categoryid}`);
        const storedLoadMoreHtml = sessionStorage.getItem(`loadMoreHtml_${categoryid}`);
        
        if (storedProducts && storedCategoryTitle && storedLoadMoreHtml) {
            $("#viewcategorydata").html(storedProducts);
            $("#category-title").html(storedCategoryTitle);
            $(".llpagination").html(storedLoadMoreHtml);
            allLoadedProducts = storedProducts;
        } else if (categoryid) {
            // Initial load - start from page 1
            loadCategoryProducts(categoryid, 1, true, false);
        }

        // Load More functionality
        $(document).on("click", ".load-more-btn", function(e) {
            e.preventDefault();
            if (isLoading) return;

            const nextPage = $(this).data("page");

            if (categoryid && nextPage) {
                loadCategoryProducts(categoryid, nextPage, false, false);
            }
        });

        function loadCategoryProducts(categoryid, page, clearExisting, isFromStorage) {
            isLoading = true;

            // Show loading state
            if (clearExisting && !isFromStorage) {
                $("#viewcategorydata").html('<div class="text-center">Loading...</div>');
                allLoadedProducts = ''; // Reset stored products
            } else if (!isFromStorage) {
                $(".load-more-btn").prop('disabled', true).text('Loading...');
            }

            $.ajax({
                url: "LoadViewCategory.php",
                method: "POST",
                dataType: "json",
                data: {
                    categoryid: categoryid,
                    limit: limit,
                    page: page,
                    append: !clearExisting
                },
                success: function(data) {
                    if (clearExisting && !isFromStorage) {
                        // Initial load - replace content
                        $("#viewcategorydata").html(data.product_Cards);
                        allLoadedProducts = data.product_Cards;
                        $("#category-title").html(data.category_title);
                    } else if (!isFromStorage) {
                        // Append new products
                        $("#viewcategorydata").append(data.product_Cards);
                        allLoadedProducts += data.product_Cards;
                    }

                    $(".llpagination").html(data.load_more_html);
                    currentPage = data.page;

                    // Store products in sessionStorage for page refresh
                    if (allLoadedProducts) {
                        sessionStorage.setItem(`categoryProducts_${categoryid}`, allLoadedProducts);
                        sessionStorage.setItem(`categoryTitle_${categoryid}`, $("#category-title").text());
                        sessionStorage.setItem(`loadMoreHtml_${categoryid}`, data.load_more_html);
                    }

                    // Update URL without page reload
                    const newUrl = `view-category.php?categoryid=${categoryid}&page=${currentPage}`;
                    window.history.replaceState({}, '', newUrl);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading products:", error);
                    if (clearExisting && !isFromStorage) {
                        $("#viewcategorydata").html("<div class='text-center text-danger'>Error loading products</div>");
                    }
                    $(".llpagination").html('<div class="text-danger">Error loading more products</div>');
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }

        // Clear storage when leaving the page
        $(window).on('beforeunload', function() {
            // Keep storage for better user experience
        });
    });
</script>

</html>