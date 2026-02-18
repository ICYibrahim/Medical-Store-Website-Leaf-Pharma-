<?php include('includes/headtag.php'); ?>

<body>
    <?php
    include('includes/header.php');
    ?>
    <div class="search-box-wrapper container text-center mb-3">
        <h1 class="mb-3">What are you looking for?</h1>
        <div class="search-box position-relative d-inline-block w-100">
            <input id="search" class="form-control form-control-lg ps-5" type="text"
                placeholder="Search The Medicines & More"
                aria-label="Search box">
            <i class='bx bx-search search-icon'></i>
            <div class="search-result mt-1 " >
                <div class="row w-100 m-0">
                    <!-- Left: Searched Results -->
                    <div id="searchdata" class="col-8 search-side-wrapper">
                        <!-- Searched results will be shown here -->
                    </div>
                    <!-- Right: Top Searched Suggestions -->
                    <div class="col-4 top-search-side-wrapper">
                        <div class="top-searched-product-wrapper">
                            <div class="top-serched-product d-flex justify-content-between align-items-center">
                                <h4>Trending Project</h4>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                        <div class="top-searched-product-wrapper">
                            <div class="top-serched-product d-flex justify-content-between align-items-center">
                                <h4>Hot Selling Project</h4>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                        <div class="top-searched-product-wrapper">
                            <div class="top-serched-product d-flex justify-content-between align-items-center">
                                <h4>Daily Wellness Project</h4>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                        <div class="top-searched-product-wrapper">
                            <div class="top-serched-product d-flex justify-content-between align-items-center">
                                <h4>Daily Wellness Project</h4>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- demo -->
    <div class="search-result mt-1" style="max-width: 850px;">





    </div>
    <!--Hero section starts here-->
    <div class="heroaa  container">
        <div class="row">
            <div class="col-12 col-md-6 my-1 my-sm-3 hero-img">
                <img class="img-fluid"
                    src="image/half-potion1-banner_exclusive_medicine_featured.png">
            </div>
            <div class="col-12 col-md-6 my-1 my-sm-3 hero-img">
                <img class="img-fluid"
                    src="image/hero2-getz-pharma-web.webp">
            </div>
        </div>
    </div>
    <!--category section starts here-->
    <div class="category-container-wrapper container mt-md-4">
        <!--category section heading-->
        <div
            class="category-container-top d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="category-container-title mb-2 mb-sm-0">Shop By Category</h1>
            <button id="all-category" class="view-more-btn">View more</button>
        </div>

        <!--category section main body-->
        <!-- Scrollable category section -->
        <div class="scroll-wrapper position-relative mt-4">
            <!-- Left scroll button -->
            <button class="scroll-btn left">&#8249;</button>

            <!-- Scrollable container -->
            <div id="CategoryCardData" class="scroll d-flex flex-nowrap overflow-auto">
                <!--category card starts-->

            </div>

            <!-- Right scroll button -->
            <button class="scroll-btn right">&#8250;</button>
        </div>
    </div>

    <!-- getz banner html starts here  -->

    <section class="banner1 container mt-4 mb-4">
        <img src="image/hero2-getz-pharma-web.webp" alt>
    </section>

    <!-- top product section styling starts here  -->

    <div class="Product-container-wrapper container mt-4 mb-4">
        <div
            class="Product-container-heading d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="mb-2 mb-sm-0 category-title">Top Product</h1>
            <button class="view-more-btn view-btn" data-categoryid="17" data-limit="12">View more</button>
        </div>
        <div class="scroll-wrapper position-relative mt-4">
            <!-- Left scroll button -->
            <button class="scroll-btn left">&#8249;</button>

            <!-- Scrollable container -->
            <div id="topproductdata" class="scroll d-flex flex-nowrap overflow-auto mt-4">

            </div>

            <!-- Right scroll button -->
            <button class="scroll-btn right">&#8250;</button>
        </div>
    </div>
    <div class="Product-container-wrapper container mt-4 mb-4">
        <div
            class="Product-container-heading d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="mb-2 mb-sm-0 category-title">Daily Wellness</h1>
            <button class="view-more-btn view-btn" data-categoryid="16" data-limit="12">View more</button>
        </div>
        <div class="scroll-wrapper position-relative mt-4">
            <!-- Left scroll button -->
            <button class="scroll-btn left">&#8249;</button>
            <!-- Scrollable container -->
            <div id="dailywellnessproductdata" class="scroll d-flex flex-nowrap overflow-auto mt-4">

                <!-- daily wellness product will appear here through ajax -->

            </div>
            <!-- Right scroll button -->
            <button class="scroll-btn right">&#8250;</button>
        </div>
    </div>
    <div class="trusted-brand container">
        <div class="trusted-brand-top d-flex justify-content-center">
            <h6 class="category-title mb-2 mb-sm-0 mt-3">Our Trusted Brand</h6>
        </div>
        <div class="trusted-brand-body">
            <div class="logos">
                <?php for ($i = 1; $i <= 2; $i++) { ?>
                    <div class="logos-slide">
                        <img src="image/logo/images-removebg-preview.png" />
                        <img src="image/logo/abbott-logo.png" />
                        <img src="image/logo/gsk.png" />
                        <img src="image/logo/getz_pharma-removebg-preview.png" />
                        <img src="image/logo/pharmevo-logo-for-web.png" />
                        <img src="image/logo/ferozsons-removebg-preview.png" />
                        <img src="image/logo/hilton_pharma-removebg-preview.png" />
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="about-section">
        <div class="container about-text">
            <h1 class="category-title">Our Mission</h1>
            <p>We are a trusted neighborhood pharmacy committed to providing only genuine medicines and reliable healthcare products. With a dedicated team and a focus on your well-being, we work every day to build lasting trust and relationships with our customers. Your health and your family’s care are always our top priority</p>
            <a href="about.php"><button class=" about-btn" href>More About us</button></a>
        </div>
        <div class="container trust-box-wrapper">
            <div class="row trust-box-row">
                <div class="col-md-4 col-12 box">
                    <h1>50K+</h1>
                    <div class="d-flex justify-content-center">
                        <p>Products</p>
                        <i class="fa-solid fa-truck-fast m-2"></i>
                    </div>
                </div>
                <div class="col-md-4 col-12 box">
                    <h1>5,000+</h1>
                    <div class="d-flex justify-content-center">
                        <p>Buyers</p>
                        <i class="fa-solid fa-bag-shopping m-2"></i>
                    </div>
                </div>
                <div class="col-md-4 col-12 box">
                    <h1>10,000+</h1>
                    <div class="d-flex justify-content-center">
                        <p>Positive Reviews</p>
                        <i class="fa-solid fa-thumbs-up m-2"></i>
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