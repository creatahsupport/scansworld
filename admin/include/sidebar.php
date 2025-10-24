
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="dashboard.php" class="b-brand text-primary">
        <img src="<?php echo $website_logo; ?>" style="width:200px;" alt="logo image" class="logo-lg" />
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">  
        <?php 
        $username = $_SESSION['user_name'];
        $user_role = $_SESSION['role'];

        if (hasPermission($username, 'dashboard')) { ?>
        <li class="pc-item pc-hasmenu">
          <a href="dashboard.php" class="pc-link">
            <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <?php }

        if (hasPermission($username, 'settings')) { ?>
        <li class="pc-item pc-hasmenu">
          <a href="settings.php" class="pc-link">
            <span class="pc-micon"><i class="ph-duotone ph-gear-six"></i></span>
            <span class="pc-mtext">Settings</span>
          </a>
        </li>
        <?php }

        if (hasPermission($username, 'general')) { ?>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-package"></i></span>
            <span class="pc-mtext">General</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="user.php">User</a></li>
            <!-- <li class="pc-item"><a class="pc-link" href="branch.php">Branch</a></li> -->
            <?php if($user_role =="admin") { ?>
            <li class="pc-item"><a class="pc-link" href="service.php">Service</a></li>
            <?php }?>
            <li class="pc-item"><a class="pc-link" href="doctor.php">Doctor</a></li>
            <!-- <li class="pc-item"><a class="pc-link" href="holiday.php">Holiday</a></li> -->
            <!-- <li class="pc-item"><a class="pc-link" href="enquiry.php">Enquiry</a></li> -->
            <li class="pc-item"><a class="pc-link" href="banner.php">Banner</a></li>
          </ul>
        </li>
        <?php }
        if (hasPermission($username, 'seo_management')) { ?>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-package"></i></span>
            <span class="pc-mtext">Seo Management</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="blog_category.php">Blog Category</a></li>
            <li class="pc-item"><a class="pc-link" href="blog.php">Blogs</a></li>
            <li class="pc-item"><a class="pc-link" href="seo.php">Seo</a></li>
            <li class="pc-item"><a class="pc-link" href="gallery.php">Gallery</a></li>
            <li class="pc-item"><a class="pc-link" href="testimonial.php">Testimonial</a></li>
            <li class="pc-item"><a class="pc-link" href="news_events.php">News & Events</a></li>
            <li class="pc-item"><a class="pc-link" href="site_map.php">Site Map</a></li>
            <li class="pc-item"><a class="pc-link" href="robots.php">Robots</a></li>
            <li class="pc-item"><a class="pc-link" href="html_sitemap.php">HTML Sitemap</a></li>
          </ul>
        </li>
        <?php }

        if (hasPermission($username, 'reports')) { ?>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ph-duotone ph-layout"></i></span>
            <span class="pc-mtext">Report</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="book_appointment_report.php">Book Appointment</a></li>
            <!-- <li class="pc-item"><a class="pc-link" href="follow_up_report.php">Followup Report</a></li> -->
          </ul>
        </li>
        <?php } ?>
      </ul>
      <div>
        <br />
        <center>
          <h5><span class="ti-comments"></span> TECH SUPPORT</h5>
          <p><i class="fas fa-mail-bulk"></i> <?php echo $support_mail; ?></p>
          <p><span class="fas fa-phone-volume"></span> <?php echo $support_number; ?></p>
          <img src="<?php echo $sidebar_logo; ?>" style="width:200px;" alt="logo image" class="logo-lg" />
        </center>
      </div>
    </div>
  </div>
</nav>
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph-duotone ph-magnifying-glass"></i>
      </a>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    
    
    
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
      <i class="ph-duotone ph-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        
        <a href="settings.php" class="dropdown-item">
          <i class="ph-duotone ph-gear"></i>
          <span>Settings</span>
        </a>
        <a href="logout.php" class="dropdown-item">
          <i class="ph-duotone ph-power"></i>
          <span>Logout</span>
        </a>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>

