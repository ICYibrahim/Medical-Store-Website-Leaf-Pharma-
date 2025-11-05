<!--begin::Sidebar-->
<?php
include('includes/login-check.php');
?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="index.php" class="brand-link">
      <img
        src="../../dist/assets/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow" />
      <span class="brand-text fw-light">Admin Panel</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Manage Section -->
        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-gear"></i>
            <p>
              Manage
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- Manage Category -->
            <li class="nav-item">
              <a href="manage-category.php" class="nav-link">
                <i class="nav-icon bi bi-tags"></i>
                <p>Manage Category</p>
              </a>
            </li>

            <!-- Manage Products -->
            <li class="nav-item">
              <a href="manage-products.php" class="nav-link">
                <i class="nav-icon bi bi-box-seam"></i>
                <p>Manage Products</p>
              </a>
            </li>

            <!-- Manage Admin -->
            <li class="nav-item">
              <a href="manage-admin.php" class="nav-link">
                <i class="nav-icon bi bi-people"></i>
                <p>Manage Admin</p>
              </a>
            </li>

            <!-- Manage Order -->
            <li class="nav-item">
              <a href="manage-orders.php" class="nav-link">
                <i class="nav-icon bi bi-cart-check"></i>
                <p>Manage Orders</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>