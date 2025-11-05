        <nav class="navbar navbar-expand-md sticky-top">
            <div class="container">
                <div class="logo">
                    <i class="fas fa-leaf"></i>
                    <h1 class="offcanvas-title" id="offcanvasNavbarLabel">Leaf <span>Pharma</span></h1>
                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1"
                    id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header navbar-brand">
                        <div class="logo">
                            <i class="fas fa-leaf"></i>
                            <h1 class="offcanvas-title" id="offcanvasNavbarLabel">Leaf <span>Pharma</span></h1>
                        </div>
                        <!-- <h5 >Leaf Pharma</h5> -->
                        <button type="button" class="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="offcanvas-body">
                        <ul
                            class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2 active"
                                    aria-current="page"
                                    href="index.php">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link mx-lg-2 dropdown-toggle"
                                    href="#" role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Medicines
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="#">Acidity Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Anemia Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Allergies Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Cold, Fever, Flu and
                                            Cough Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Bacteria, Viral and
                                            Infections Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Diabetes Care</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Pain
                                            management</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="#">Something else
                                            here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link mx-lg-2 dropdown-toggle"
                                    href="#" role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Category
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="#">Page
                                            1</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Page
                                            2</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Page
                                            3</a></li>
                                    <li><a class="dropdown-item"
                                            href="#">Page
                                            4</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="#">Something else
                                            here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2"
                                    href="about.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2"
                                    href="#">services</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cart, Favorites & Toggler Button in One Line -->
                <div class="d-flex align-items-center">
                    <div class="murge-cartandfavorait me-3">
                        <a data-bs-toggle="offcanvas"
                            data-bs-target="#favorait"
                            aria-controls="favorait" class="favorait"
                            data-count="2"><i
                                class='bx bx-heart'></i></a>
                        <a data-bs-toggle="offcanvas"
                            data-bs-target="#cart"
                            aria-controls="cart" class="cart" data-count="3"><i
                                class='bx bx-cart-alt'></i>
                            <div id="carticonebadge"></div>
                        </a>
                    </div>

                    <!-- navbar togglar button appear when in small screan -->
                    <button class="navbar-toggler" type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar"
                        aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- cart side bar html -->

        <!-- Side Cart (Offcanvas) -->
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="cart" aria-labelledby="cartLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="cartLabel" style="color: var(--primary-color);">My Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <hr>

            <div class="offcanvas-body d-flex flex-column">

                <!-- Cart Items Container with Flex Grow -->
                <div id="cart-items" class="cart-main flex-grow-1 overflow-auto">

                    <!-- items added to the card will be shown here  -->

                </div>

                <!-- Cart Footer (Stays at Bottom) -->
                <div class="cart-footer-wrapper mt-auto">
                    <div class="cart-footer border-top pt-3">
                        <div class="row cart-total align-items-center mb-3">
                            <div class="col">
                                <h4>Total:</h4>
                            </div>
                            <div class="col text-end">
                                <p id="cart-total"><strong class="Get_SubTotal_Price"> </strong></p>
                            </div>
                        </div>

                        <div class="row cart-checkout-btn">
                            <div class="col">
                                <button id="checkout" class="btn btn-success w-100">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- favorait side bar html -->

        <div class="offcanvas offcanvas-end" data-bs-scroll="true"
            tabindex="-1" id="favorait"
            aria-labelledby="favoraitLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="favoraitLabel">Favorait</h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="offcanvas" aria-label="Close">
                </button>
            </div>
            <hr>
            <div class="offcanvas-body">
                <p>Try scrolling the rest of the page to see this option in
                    action.</p>
            </div>
        </div>