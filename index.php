<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $bookingnum = mt_rand(100000000, 999999999);
    $pname = $_POST['pname'];
    $rname = $_POST['rname'];
    $phone = $_POST['phone'];
    $hdate = $_POST['hdate'];
    $htime = $_POST['htime'];
    $ambulancetype = $_POST['ambulancetype'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $message = $_POST['message'];
    $transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : '';
    $payment_status = $transaction_id ? 'Paid' : 'Pending';

    $query = mysqli_query($con, "INSERT INTO tblambulancehiring (BookingNumber, PatientName, RelativeName, RelativeConNum, HiringDate, HiringTime, AmbulanceType, Address, City, State, Message, PaymentStatus, TransactionID) VALUES ('$bookingnum', '$pname', '$rname', '$phone', '$hdate', '$htime', '$ambulancetype', '$address', '$city', '$state', '$message', '$payment_status', '$transaction_id')");

    if ($query) {
        echo "<script>alert('Your request has been sent successfully. Your Booking Number is: $bookingnum');</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <title>Emergancy Ambulance Hiring Portal</title>
 
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Medicio
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/medicio-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

 <?php include_once('includes/header.php');?>

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(assets/img/slide/Ambulance2.jpeg)">
          <div class="container">
            <h2>Welcome to <span>Emergency Ambulance Hiring Portal</span></h2>
            <a href="#ambulance-availability" class="btn-get-started scrollto">View Ambulances</a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/Doctor%20ambu.jpeg)">
          <div class="container">
            <h2>Fast, Reliable, Professional</h2>
            <a href="#about" class="btn-get-started scrollto">Read More</a>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/Doctor.jpeg)">
          <div class="container">
            <h2>Expert Medical Team Onboard</h2>
            <a href="#about" class="btn-get-started scrollto">Read More</a>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/Ambulance3.jpeg)">
          <div class="container">
            <h2>24/7 Emergency Support</h2>
            <a href="#contact" class="btn-get-started scrollto">Contact Us</a>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- Registration link removed as requested -->
    <!-- ======= Ambulance Availability Section ======= -->
    <section id="ambulance-availability" class="ambulance-availability">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>EMERGENCY AMBULANCES</h2>
        </div>
        <div class="row">
          <?php
          $query = mysqli_query($con, "SELECT * FROM tblambulance");
          $ambu_images = ['Ambu 1.jpg', 'Ambu 2.jpg', 'Ambu 3.jpg', 'Ambu 4.jpg', 'Ambu 5.jpeg', 'Ambu 6.jpg', 'Ambu 7.jpg', 'Ambu 8.jpg', 'Ambu 9.jpg', 'Ambu 10.jpg'];
          $img_idx = 0;
          $total_imgs = count($ambu_images);
          while ($row = mysqli_fetch_array($query)) {
            $status = strtolower(trim($row['Status']));
            $isAvailable = ($status == '' || $status == 'available' || $status == 'reached');
            $selected_img = "assets/img/Ambulances/" . $ambu_images[$img_idx % $total_imgs];
            $img_idx++;
          ?>
          <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
            <div class="card shadow border-0 w-100" style="border-radius: 8px; overflow: hidden; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
              <img src="<?php echo $selected_img; ?>" class="card-img-top" alt="Ambulance Images" style="height: 220px; object-fit: cover;">
              <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title mb-0" style="color: #2c4964; font-weight: 700; font-size: 1.1rem;">Reg No: <?php echo $row['AmbRegNum']; ?></h5>
                  <span class="badge <?php echo $isAvailable ? 'bg-primary' : 'bg-danger'; ?>" style="<?php echo $isAvailable ? 'background-color: #3fbbc0 !important; font-size: 0.85rem; padding: 6px 10px;' : 'font-size: 0.85rem; padding: 6px 10px;'; ?>">
                    <?php echo ($status == '' || $status == 'available') ? "Available" : ucfirst($status); ?>
                  </span>
                </div>
                <hr class="mt-0 mb-3" style="border-top: 1px solid #eee;">
                <p class="card-text mb-2"><i class="fas fa-ambulance me-2" style="color: #3fbbc0;"></i> <strong>Type:</strong> <?php echo $row['AmbulanceType']; ?></p>
                <p class="card-text mb-4"><i class="fas fa-user-md me-2" style="color: #3fbbc0;"></i> <strong>Driver:</strong> <?php echo $row['DriverName']; ?> <br><span class="text-muted" style="margin-left: 24px; font-size: 0.9em;">(<?php echo $row['DriverContactNumber']; ?>)</span></p>
                
                <div class="mt-auto">
                  <?php if ($isAvailable) { ?>
                    <a href="hire-ambulance.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary w-100" style="border-radius: 5px; font-weight: 600; padding: 10px;">Hire This Ambulance</a>
                  <?php } else { ?>
                    <button class="btn btn-secondary w-100" style="border-radius: 5px; font-weight: 600; padding: 10px;" disabled>Currently Unavailable</button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </section>
    <!-- End Ambulance Availability Section -->
    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-6 col-md-6 col-lg-3 d-flex align-items-stretch mb-4">
            <div class="icon-box w-100" data-aos="fade-up" data-aos-delay="100">
              <div class="icon"><i class="fas fa-heartbeat"></i></div>
              <h4 class="title"><a href="">Life Support</a></h4>
         
            </div>
          </div>

          <div class="col-6 col-md-6 col-lg-3 d-flex align-items-stretch mb-4">
            <div class="icon-box w-100" data-aos="fade-up" data-aos-delay="200">
              <div class="icon"><i class="fas fa-pills"></i></div>
              <h4 class="title"><a href="">Medical Support</a></h4>
 
            </div>
          </div>

          <div class="col-6 col-md-6 col-lg-3 d-flex align-items-stretch mb-4">
            <div class="icon-box w-100" data-aos="fade-up" data-aos-delay="300">
              <div class="icon"><i class="fas fa-thermometer"></i></div>
              <h4 class="title"><a href="">Emergency Kit</a></h4>
         
            </div>
          </div>

          <div class="col-6 col-md-6 col-lg-3 d-flex align-items-stretch mb-4">
            <div class="icon-box w-100" data-aos="fade-up" data-aos-delay="400">
              <div class="icon"><i class="fas fa-baby"></i></div>
              <h4 class="title"><a href="">NICU Support
              </a></h4>

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Featured Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>In an emergency? Need help now?</h3>
          <a class="cta-btn scrollto" href="#appointment">Hire an Ambulance</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= About Us Section ======= -->
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about" style="padding: 100px 0; background: #f9fcfc;">
      <div class="container" data-aos="fade-up">

        <div class="card border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #fff;">
          <div class="row g-0">
            
            <!-- Image Side -->
            <div class="col-lg-5 position-relative" style="min-height: 450px;">
              <img src="assets/img/gallery/Doctor.jpg" alt="About Us" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center top;">
              
              <!-- Floating Badge -->
              <div style="position: absolute; bottom: 30px; right: -25px; background: #3fbbc0; padding: 20px 30px; border-radius: 8px; color: #fff; box-shadow: 0 10px 25px rgba(63,187,192,0.4); text-align: center; z-index: 2;">
                <h3 style="margin: 0; font-size: 2.2rem; font-weight: 800;">24/7</h3>
                <p style="margin: 0; font-size: 1rem; font-weight: 600; text-transform: uppercase;">Emergency<br>Support</p>
              </div>
            </div>
            
            <!-- Text Side -->
            <div class="col-lg-7">
              <div class="card-body" style="padding: 60px 50px;">
                <div class="section-title text-start pb-2">
                  <h2 style="font-size: 2.2rem; color: #2c4964; margin-bottom: 15px;">Who We Are</h2>
                </div>
                
                <?php
                $ret=mysqli_query($con,"select * from tblpage where PageType='aboutus' ");
                while ($row=mysqli_fetch_array($ret)) {
                ?>
                <p style="font-size: 1.1rem; line-height: 1.8; color: #555;">
                  <?php  echo $row['PageDescription'];?>
                </p>
                <?php } ?>
                
                <div class="mt-4 pt-4 border-top">
                  <div class="row g-4">
                    <div class="col-md-6 d-flex align-items-center">
                      <div style="background: #e9f7f8; color: #3fbbc0; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 4px 10px rgba(63,187,192,0.15);">
                        <i class="fas fa-ambulance" style="font-size: 1.2rem;"></i>
                      </div>
                      <div>
                        <h5 style="margin: 0; font-weight: 700; color: #2c4964; font-size: 1.05rem;">Fast & Reliable</h5>
                        <span style="color: #777; font-size: 0.9rem;">Rapid deployment.</span>
                      </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                      <div style="background: #e9f7f8; color: #3fbbc0; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 4px 10px rgba(63,187,192,0.15);">
                        <i class="fas fa-heartbeat" style="font-size: 1.2rem;"></i>
                      </div>
                      <div>
                        <h5 style="margin: 0; font-weight: 700; color: #2c4964; font-size: 1.05rem;">Expert Medical Team</h5>
                        <span style="color: #777; font-size: 0.9rem;">Trained professionals.</span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    






    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="padding: 100px 0; background: #fff;">
      <div class="container" data-aos="fade-up">

        <div class="section-title text-center mb-5">
          <h2 style="font-size: 2.4rem; color: #2c4964; margin-bottom: 20px;">Get In Touch</h2>
          <p style="font-size: 1.1rem; color: #666; max-width: 800px; margin: 0 auto; line-height: 1.8;">We are the elite Emergency Hub designed to meet the needs of the people and community as a whole. We are fast, reliable and comfortable to book with easy access. The wellbeing of the society is our priority.</p>
        </div>

        <?php 
        $query=mysqli_query($con,"select * from tblpage where PageType='contactus'");
        while ($row=mysqli_fetch_array($query)) {
        ?>
        <div class="row g-4 mt-2 justify-content-center">
          
          <!-- Address Card -->
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="info-card h-100 p-5 text-center rounded shadow-sm" style="background: #fcfdfd; border: 1px solid #eef5f5; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(63,187,192,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
              <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; background: #e9f7f8; color: #3fbbc0; font-size: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 4px 15px rgba(63,187,192,0.2);">
                <i class="bx bx-map"></i>
              </div>
              <h3 style="font-size: 1.5rem; font-weight: 700; color: #2c4964; margin-bottom: 15px;">Our Address</h3>
              <p style="color: #666; line-height: 1.6; font-size: 1.05rem;"><?php echo $row['PageDescription']; ?></p>
            </div>
          </div>

          <!-- Email Card -->
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="info-card h-100 p-5 text-center rounded shadow-sm" style="background: #fcfdfd; border: 1px solid #eef5f5; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(63,187,192,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
              <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; background: #e9f7f8; color: #3fbbc0; font-size: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 4px 15px rgba(63,187,192,0.2);">
                <i class="bx bx-envelope"></i>
              </div>
              <h3 style="font-size: 1.5rem; font-weight: 700; color: #2c4964; margin-bottom: 15px;">Email Us</h3>
              <p style="margin: 0;"><a href="mailto:<?php echo $row['Email']; ?>" style="color: #3fbbc0; text-decoration: none; font-size: 1.15rem; font-weight: 600;"><?php echo $row['Email']; ?></a></p>
              <p style="color: #999;font-size: 0.9rem; margin-top:5px;">We reply within 24 hours.</p>
            </div>
          </div>

          <!-- Phone Card (Highlighted) -->
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="info-card h-100 p-5 text-center rounded shadow-lg" style="background: linear-gradient(135deg, #3fbbc0 0%, #2f8e91 100%); color: #fff; border: none; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(63,187,192,0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 30px rgba(63,187,192,0.2)';">
              <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; background: rgba(255,255,255,0.25); color: #fff; font-size: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; backdrop-filter: blur(5px);">
                <i class="bx bx-phone-call"></i>
              </div>
              <h3 style="font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 15px;">Call Us Now</h3>
              <p style="font-size: 1.4rem; font-weight: 800; margin: 0; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);"><?php echo $row['MobileNumber']; ?></p>
              <p style="margin-top: 15px; font-size: 0.95rem; opacity: 0.9; background: rgba(0,0,0,0.1); padding: 5px 15px; border-radius: 20px; display: inline-block;">Available 24/7 for Emergencies</p>
            </div>
          </div>

        </div>
        <?php } ?>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <?php include_once('includes/footer.php');?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>