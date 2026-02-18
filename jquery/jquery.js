$(document).ready(function () {

    let isSearching = false;
    const TopProductCategoryid = 17
    const TopProductLimit = 8
    const dailywellnesscategoryid = 16
    const dailywellnesslimit = 8
    let currentSearchTerm = '';

    LoadCategoryCard();
    //load top Product row from the DB using ajax
    LoadTopProduct(TopProductCategoryid, TopProductLimit);
    //load Daily Wellness Product row from the DB using ajax
    LoadDailyWellnessProduct(dailywellnesscategoryid, dailywellnesslimit);
    // cart function calling all three
    Loadcompletecart();
    loadcartiteminjs();

    //this javascript for scrolling 
    $('.scroll-wrapper').each(function () {
        const scrollContainer = $(this).find('.scroll')[0];

        $(this).find('.scroll-btn.left').click(function () {
            scrollContainer.scrollBy({ left: -250, behavior: 'smooth' });
        });

        $(this).find('.scroll-btn.right').click(function () {
            scrollContainer.scrollBy({ left: 250, behavior: 'smooth' });
        });
    });


    // Handle search
    $("#search").on("keyup", function () {
        let currentSearchTerm = $(this).val().trim();

        if (currentSearchTerm.length >= 2) {
            $(".search-result").show(); // 👈 Show result box

            $.ajax({
                url: "search-product.php",
                type: "POST",
                data: {
                    search: currentSearchTerm
                },
                success: function (data) {
                    $("#searchdata").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                    $("#searchdata").html('<div class="text-danger">Error loading searched results</div>');
                }
            });
        } else {
            $(".search-result").hide(); // 👈 Hide result box if input is empty or less than 2 chars
            $("#searchdata").html(""); // Also clear old results
        }
    });


    // ADD to cart button 
    $(document).on("click", ".AddToCartBtn", function () {
        var pid = $(this).data('pid');
        var pcode = $(this).data('pcode');
        var pname = $(this).data('pname');
        var pprice = $(this).data('pprice');
        var pimage = $(this).data('pimage');
        var pqty = $(this).closest('.product-detail-disc-wrapper').find('.qty-input').val();
        // Optional: AJAX call to add to cart PHP

        $.ajax({
            url: "add_to_cart.php",
            method: "POST",
            data: {
                pid: pid,
                pcode: pcode,
                pname: pname,
                pprice: pprice,
                pimage: pimage,
                pqty: pqty
            },
            success: function (data) {
                Loadcompletecart();
                loadcartiteminjs();

            setTimeout(function(){
            // 🔥 Open Bootstrap Offcanvas using jQuery
            var cartOffcanvas = new bootstrap.Offcanvas($('#cart')[0]);
            cartOffcanvas.show();
            }, 200);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                $("#cartfield").html('<div class="text-danger">Error Adding product To The Cart</div>');
            }
        })

    });
 


    // Increase quantity
    $(document).on("click", ".plus", function () {
        let $input = $(this).siblings(".qty-input");
        let currentVal = parseInt($input.val()) || 1;
        let newVal = currentVal + 1;
        $input.val(newVal);

        // Get product code (from parent container or hidden input)
        let pcode = $(this).closest(".get-pcode-wrapper").data("pcode");

        updateQuantityInDB(pcode, newVal);
    });

    // Decrease quantity
    $(document).on("click", ".minus", function () {
        let $input = $(this).siblings(".qty-input");
        let currentVal = parseInt($input.val()) || 1;
        if (currentVal > 1) {
            let newVal = currentVal - 1;
            $input.val(newVal);

            let pcode = $(this).closest(".get-pcode-wrapper").data("pcode");
            updateQuantityInDB(pcode, newVal);
        }
    });

    // remove cart item
    $(document).on("click", ".remove-cart-item", function () {
        var pcode = $(this).data('productcode'); // must match data-productcode in HTML
        if (confirm("Are you sure you want to remove this item?")) {

            $.ajax({
                url: "remove-cart-item.php",
                method: "POST",
                data: { pcode: pcode },
                success: function (data) {
                    Loadcompletecart();
                    loadcartiteminjs();
                },
                error: function () {
                    alert('Error Removing item');
                }
            });
        }
    });

    // this is sending checkout form data 
    $("#checkoutModal form").on("submit", function (e) {
    e.preventDefault();

    // Gather form data
    const formData = $(this).serializeArray();

    // Get cart items from JS
    const cartItems = getCartItemsFromJS();

    // Send both to PHP
    $.ajax({
        url: "place_order.php",
        method: "POST",
        data: {
            form: formData,
            cart: cartItems
        },
        success: function (response) {
            console.log(response);
            
            // ✅ Redirect to confirmation page instead of reload
            window.location.href = "order-confirmation.php";
        },
        error: function () {
            alert("Error placing order. Please try again.");
        }
    });
});


    // this will direct the user to the checkout.php when click on checkout btn in the side cart
    $(document).on("click", "#checkout", function () {
        window.location.href = "checkout.php"; // Change to your products page
    });
    $(document).on("click", "#continue_shopping", function () {
        window.location.href = "index.php"; // Change to your products page

    });
    $(document).on("click", "#all-category", function () {
        window.location.href = "category.php"; // Change to your products page

    });
    $(document).on("click", ".view-btn", function () {
        const categoryid = $(this).data("categoryid");
        const limit = $(this).data("limit") || 24;
        ViewCategory(categoryid, limit,);
    });
})
let cartItemsCache = [];
function getCartItemsFromJS() {
    return cartItemsCache;
}
function Loadcompletecart() {
    LoadCartProduct();      // Reload cart items
    LoadTotalPrice();       // Reload total price
    LoadNumOfCartItem();        // Reload cart count badge
    loadCheckoutProduct();  // Reload checkout page
}
function LoadCartProduct() {
    $.ajax({
        url: "loadcartProduct.php",
        method: "POST",
        success: function (data) {
            $('#cart-items').html(data);
        },
        error: function () {
            $('#cart-items').html('<div>no products found</div>');

        }
    })
}
function LoadNumOfCartItem() {
    $.ajax({
        url: "LoadNumOfCartItem.php",
        method: "POST",
        success: function (data) {
            $('#carticonebadge').html(data.html);
            $('.numofitems').html(data.total_cart_items + " " + "Items");

        },
        error: function () {
            $('#carticonebadge').hide();
            $('.numofitems').html(data.total_cart_items + " " + "Items");


        }
    })
}

function LoadTotalPrice() {
    $.ajax({
        url: "loadTotalPrice.php",
        method: "POST",
        dataType: 'json',
        success: function (data) {
            let totalPrice = parseFloat(data.total_price); // Always parse number Get_SubTotal_Price
            $(".Get_SubTotal_Price").text(
                totalPrice.toLocaleString('en-PK', { minimumFractionDigits: 2 }) + ' PKR'
            );
            if (totalPrice > 0) {
                $("#checkout-button").prop("disabled", false);
                $(".delivery_charge").text('250 PKR');

                totalPrice += 250; // Add delivery

                $(".Get_Total_Price").text(
                    totalPrice.toLocaleString('en-PK', { minimumFractionDigits: 2 }) + ' PKR'
                );
            } else {
                $("#checkout-button").prop("disabled", true);
                $(".delivery_charge").text('0 PKR');

                $(".Get_Total_Price").text(
                    '0.00 PKR'
                );
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


function loadCheckoutProduct() {
    $.ajax({
        url: "loadCheckoutProduct.php",
        method: "POST",
        success: function (data) {
            $("#cart-item-area").html(data);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
            $("#cart-item-area").html('<div class="text-danger">Error loading cart items. Please try again.</div>');
        }
    });
}
function loadcartiteminjs() {
    $.ajax({
        url: "loadcartiteminjs.php",
        method: "POST",
        dataType: "json",
        success: function (data) {
            cartItemsCache = data;
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
        }
    })
}


// Function to send AJAX to update quantity in DB
function updateQuantityInDB(pcode, qty) {
    $.ajax({
        url: "update_quantity.php",
        method: "POST",
        data: {
            pcode: pcode,
            qty: qty
        },
        success: function (response) {
            Loadcompletecart();
            getCartItemsFromJS()
        },
        error: function () {
            alert("Failed to update quantity.");
        }
    });
}
function ViewCategory(categoryid, limit) {
    $.ajax({
        url: "LoadViewCategory.php",
        method: "POST",
        dataType: "json",
        data: {
            categoryid: categoryid,
            limit: limit,
            page: 1
        },
        success: function (data) {
            // Use the new sessionStorage keys that match your view-category.php
            sessionStorage.setItem(`categoryProducts_${categoryid}`, data.product_Cards);
            sessionStorage.setItem(`categoryTitle_${categoryid}`, data.category_title);
            sessionStorage.setItem(`loadMoreHtml_${categoryid}`, data.load_more_html);
            let page = data.page;
            window.location.href = "view-category.php?categoryid=" + categoryid + "&page=" + page;
        },
        error: function () {
            sessionStorage.setItem(`categoryProducts_${categoryid}`, "<div>No products found</div>");
            window.location.href = "view-category.php?categoryid=" + categoryid;
        }
    });
}
function LoadAllCategories() {
    $.ajax({
        url: "LoadAllCategory.php",
        method: "POST",
        success: function (data) {
            $('#allcategorydata').html(data);
        },
        error: function () {
            $("#allcategorydata").html('<div>Something went wrong.</div>');

        }
    })
}
function LoadCategoryCard() {
    $.ajax({
        url: "LoadCategoryCard.php",
        method: "POST",
        success: function (data) {
            $("#CategoryCardData").html(data);
        },
        error: function () {
            $("#CategoryCardData").html('<div>no products found</div>');
        }

    })
}


// Home product calling by id
function LoadTopProduct(categoryid, limit) {
    $.ajax({
        url: "LoadProductByCategory.php",
        method: "POST",
        data: {
            categoryid: categoryid,
            limit: limit
        },
        success: function (data) {
            $("#topproductdata").html(data);
        },
        error: function () {
            $("#topproductdata").html('<div>no products found</div>');
        }

    })
}

function LoadDailyWellnessProduct(categoryid, limit) {
    $.ajax({
        url: "LoadProductByCategory.php",
        method: "POST",
        data: {
            categoryid: categoryid,
            limit: limit
        },
        success: function (data) {
            $("#dailywellnessproductdata").html(data);
        },
        error: function () {
            $("#dailywellnessproductdata").html('<div>no products found</div>');
        }

    })
}
function LoadRelatedProduct(categoryid, productid, productname, limit) {
    $.ajax({
        url: "LoadRelatedProduct.php",
        method: "POST",
        data: {
            categoryid: categoryid,
            limit: limit,
            productid: productid,
            productname: productname
        },
        success: function (data) {
            console.log('')
            $("#relatedproduct").html(data);
        },
        error: function () {
            $("#relatedproduct").html('<div>no products found</div>');
        }

    })
}
