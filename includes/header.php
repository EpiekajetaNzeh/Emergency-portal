<style>
/* CRITICAL MOBILE UI OVERRIDES */
@media (max-width: 991px) {
    /* Enforce Readable Font Sizes */
    body, p, li, label, .form-control, .form-select, .form-label {
        font-size: 16px !important;
        line-height: 1.6 !important;
    }
    h2, .h2 { font-size: 24px !important; font-weight: 700 !important; }
    
    /* Make the Back Button "Unmissable" */
    .back-nav {
        display: flex !important;
        justify-content: flex-start !important;
        margin: 15px 0 25px 0 !important;
        padding-left: 10px;
    }
    .back-btn {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 12px 20px !important;
        background: #3fbbc0 !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 16px !important;
        box-shadow: 0 4px 15px rgba(63, 187, 192, 0.4) !important;
        border: 2px solid #3fbbc0 !important;
    }
    .back-btn i {
        font-size: 18px !important;
    }
    
    /* Form Optimization */
    .form-control {
        padding: 12px !important;
        height: auto !important;
    /* Fix content being hidden under fixed header on mobile */
    body {
        padding-top: 130px !important;
    }
    
    @media (max-width: 991px) {
        body { padding-top: 160px !important; }
        
        .mobile-back-arrow {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background: #f4f4f4;
            border-radius: 5px;
            margin-right: 12px;
            color: #3fbbc0 !important;
            font-size: 18px !important;
            border: 1px solid #ddd;
        }
        
        .mobile-nav-toggle {
            position: absolute !important;
            right: 15px !important;
            top: 15px !important;
            z-index: 10000 !important;
            display: block !important;
            color: #3fbbc0 !important;
            font-size: 32px !important;
            padding: 5px;
            cursor: pointer;
        }

        .navbar-mobile ul {
            top: 75px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        }

        .appointment-btn {
            display: none !important;
        }

        .logo { 
            font-size: 20px !important;
            margin-right: auto !important;
            margin-left: 0 !important;
        }
    }
}
</style>
 <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
       <?php 
 $query=mysqli_query($con,"select * from  tblpage where PageType='contactus'");
 while ($row=mysqli_fetch_array($query)) {


 ?>
      <div class="align-items-center d-none d-md-flex">
        <i class="bx bx-envelope"></i> Email:  <?php  echo $row['Email'];?>
      </div>
      <div class="d-flex align-items-center">
        <i class="bi bi-phone"></i> Call us now +<?php  echo $row['MobileNumber'];?>
      </div><?php } ?>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">



      <a href="index.php" class="logo me-auto"><img src="assets/img/logo.png" alt="">KAJEV</a>
    
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto " href="index.php#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
           <li><a class="nav-link scrollto" href="index.php#contact">Contact</a></li>
          <li><a class="nav-link scrollto" href="admin/login.php">Admin</a></li>
          <li><a class="nav-link scrollto" style="color: red;" href="ambulance-tracking.php">Ambulance Tracking</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="register-ambulance.php" class="appointment-btn"><span class="d-none d-md-inline">Register Your</span> Ambulance</a>

    </div>
  </header><!-- End Header -->