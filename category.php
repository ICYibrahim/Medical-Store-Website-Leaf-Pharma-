<?php include('includes/headtag.php'); ?>

<body>
    <?php
    include('includes/header.php');
    ?>
    <div class="all-category container mb-4">
        <div class="category-head">
            <div
                class="top-category d-flex justify-content-between align-items-center flex-wrap">
                <h1 class="mb-2 mb-sm-0 category-title">Shop By Category</h1>
            </div>
            <hr>
        </div>
        <div id="allcategorydata">

        </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/scripttag.php');
    ?>
</body>
<script>
    $(document).ready(function() {
        LoadAllCategories();

        // Use delegated events for dynamic content!
        $(document).on('click', '.scroll-btn.left', function() {
            const scrollContainer = $(this).closest('.scroll-wrapper').find('.scroll')[0];
            scrollContainer.scrollBy({
                left: -350,
                behavior: 'smooth'
            });
        });

        $(document).on('click', '.scroll-btn.right', function() {
            const scrollContainer = $(this).closest('.scroll-wrapper').find('.scroll')[0];
            scrollContainer.scrollBy({
                left: 350,
                behavior: 'smooth'
            });
        });
    });
</script>

</html>