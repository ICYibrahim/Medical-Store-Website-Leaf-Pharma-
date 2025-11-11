$(document).ready(function () {
    $(document).on("click", ".view-order-items-btn",function(){
        let id = $(this).data("id");
        window.location.href = "view-order-items.php?id=" + id;
    });
    // for remove button to remove the item in the table 
    $(document).on("click", ".remove-btn-js", function () {
        if (confirm("Are Your Sure you want to remove it?")) {
            let id = $(this).data("id");
            let image = $(this).data("image");
            let url = $(this).data("url");
            let returnurl = $(this).data("returnurl");
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    id: id,
                    image: image
                },
                success: function (data) {
                    window.location.href = returnurl;
                },
                error: function () {
                    window.location.href = returnurl;
                    alert('Error Removing item');
                }
            });
        }
    });
    $(document).on("click", ".view-by-category", function () {
        let categoryID = $(this).data("id");
        window.location.href = "view-category.php?categoryid=" + categoryID;
    })
})

// load admin table
function loadadmintable(page, limit) {
    $.ajax({
        url: "load-admin-table.php",
        type: "POST",
        data: {
            page: page,
            limit: limit
        },
        dataType: 'json',
        success: function (response) {
            $("#tabledata").html(response.html);
            updatePagination(
                response.current_page,
                response.total_pages,
                response.total_products, // Make sure your API returns this
                limit // Items per page
            );
        },
        error: function () {
            $("#tabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
        }
    });
}

// this is to load the order tabel 
function loadOrderitemstable(page, limit,id) {
    $.post("load-view-ordered-items-table.php", {
        page: page,
        limit: limit,
        id: id
    }, function (response) {
        $("#orderitemstabledata").html(response.html);
        updatePagination(
            response.current_page,
            response.total_pages,
            response.total_products,
            limit);
    },
        'json').fail(function () {
            $("#orderitemstabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
            window.location.href = "manage-orders.php";
        });
}

// this is to load the order tabel 
function loadOrderstable(page, limit) {
    $.post("load-order-table.php", {
        page: page,
        limit: limit
    }, function (response) {
        $("#ordertabledata").html(response.html);
        updatePagination(
            response.current_page,
            response.total_pages,
            response.total_products,
            limit);
    },
        'json').fail(function () {
            $("#ordertabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
        });
}
// load cateogry table 
function loadcateogrytable(page, limit) {
    $.ajax({
        url: "load-category-table.php",
        type: "POST",
        data: {
            page: page,
            limit: limit
        },
        dataType: 'json',
        success: function (response) {
            $("#tabledata").html(response.html);
            updatePagination(
                response.current_page,
                response.total_pages,
                response.total_products, // Make sure your API returns this
                limit // Items per page
            );
        },
        error: function () {
            $("#tabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
        }
    });
}

// this is to load the product tabel 
function loadProductstable(page, limit) {
    $.post("load-product-table.php", {
        page: page,
        limit: limit
    }, function (response) {
        $("#producttabledata").html(response.html);
        updatePagination(
            response.current_page,
            response.total_pages,
            response.total_products,
            limit);
    },
        'json').fail(function () {
            $("#producttabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
        });
}
function viewproductbycategory(page, limit, categoryID) {
    $.ajax({
        url: "load-view-category-table.php",
        method: "post",
        dataType: "json",
        data: {
            limit: limit,
            page: page,
            categoryID: categoryID
        },
        success: function (response) {
            $("#producttabledata").html(response.html);
            updatePagination(response.current_page, response.total_pages, response.total_products, limit);
        },
        error: function () {
            $("#producttabledata").html('<tr><td colspan="11">Error loading products</td></tr>');
        }
    })
}

// this is for the pagination
function updatePagination(currentPage, totalPages, totalProducts, itemsPerPage = limit) {
    const paginationContainer = $("#pagination-container");
    const windowSize = 4; // Show 4 pages at a time
    let startPage, endPage;

    // Calculate current item range
    const fromItem = ((currentPage - 1) * itemsPerPage) + 1;
    const toItem = Math.min(currentPage * itemsPerPage, totalProducts);

    // Create item count text
    const itemCountText = `
                    <li class="page-item disabled d-none d-md-block">
                        <span class="page-link text-dark bg-transparent border-0">
                            Showing ${fromItem}-${toItem} of ${totalProducts} products
                        </span>
                    </li>`;

    if (totalPages <= 1) {
        paginationContainer.html(itemCountText);
        return;
    }

    // Calculate page range
    if (totalPages <= windowSize) {
        startPage = 1;
        endPage = totalPages;
    } else {
        startPage = Math.max(1, currentPage - Math.floor(windowSize / 2));
        endPage = startPage + windowSize - 1;
        if (endPage > totalPages) {
            endPage = totalPages;
            startPage = endPage - windowSize + 1;
        }
    }

    // Build pagination HTML
    let paginationHtml = itemCountText; // Add item count first

    // Previous button
    paginationHtml += `
                <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                </li>`;

    // First page + ellipsis
    if (startPage > 1) {
        paginationHtml += `
                    <li class="page-item ${1 == currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="1">1</a>
                    </li>`;
        if (startPage > 2) {
            paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>`;
        }
    }

    // Page numbers
    for (let p = startPage; p <= endPage; p++) {
        paginationHtml += `
                <li class="page-item ${p == currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${p}">${p}</a>
                </li>`;
    }

    // Last page + ellipsis
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            paginationHtml += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>`;
        }
        paginationHtml += `
                <li class="page-item ${totalPages == currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                </li>`;
    }

    // Next button
    paginationHtml += `
                <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                </li>`;

    paginationContainer.html(paginationHtml);
}