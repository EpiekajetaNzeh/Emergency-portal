<?php

error_reporting(0);
include('includes/dbconnection.php');
?>

<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="dashboard.php" class="logo">
        Admin
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>
<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
              <!-- inbox dropdown start-->
                
<?php
             
$ret1=mysqli_query($con,"select * from tblambulancehiring
  
 where (tblambulancehiring.Status is null || tblambulancehiring.Status='')");
$num=mysqli_num_rows($ret1);

?>  
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important"><?php echo $num;?></span>
            </a>
 

            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You received <?php echo $num;?> New Request</p>
                </li>

    <?php if($num>0){
while($result=mysqli_fetch_array($ret1))
{
?>
                <li>
<span class="subject">
<span class="from"><a class="dropdown-item" href="booking-details.php?id=<?php echo $result['ID'];?>&&bookingnum=<?php echo $result['BookingNumber'];?>">New Request Received from <?php echo $result['PatientName'];?> (<?php echo $result['BookingNumber'];?>)</a></span>
</span>
                </li>
<?php } }  else {?>
  <li>  No New Request Received</li>
        <?php } ?>


                <li>
                    <a href="all-amublance-request.php">See all Request</a>
                </li>
            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu d-flex align-items-center">
        
        <li class="pill-nav-item">
            <a href="../index.php" class="pill-btn">
                <i class="fa fa-home"></i> <span>Visit Website</span>
            </a>
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown pill-nav-item">
            <a data-toggle="dropdown" class="dropdown-toggle pill-btn profile-btn" href="#">
                <?php
$adid=$_SESSION['eahpaid'];
$ret=mysqli_query($con,"select AdminName from tbladmin where ID='$adid'");
$row=mysqli_fetch_array($ret);
$name=$row['AdminName'];

?>
                <img alt="" src="images/2.png" class="profile-img">
                <span class="username"><?php echo $name; ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="admin-profile.php"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="change-password.php"><i class="fa fa-cog"></i> Change Password</a></li>
                <li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end--> 
</div>
<script>
$(document).ready(function() {
    $('.sidebar-toggle-box .fa-bars').click(function(e) {
        if ($(window).width() <= 768) {
            $('#sidebar').toggleClass('open');
            e.stopPropagation();
        }
    });
    // Close sidebar when clicking outside on mobile
    $(document).click(function(e) {
        if ($(window).width() <= 768 && !$(e.target).closest('#sidebar').length && !$(e.target).closest('.sidebar-toggle-box').length) {
            $('#sidebar').removeClass('open');
        }
    });
});
</script>
</header>
<style>
/* Global Color Overrides for Teal and Black consistency */
:root {
    --primary-teal: #3fbbc0;
    --primary-hover: #36a5a9;
}
.btn-primary, .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
    background-color: var(--primary-teal) !important;
    border-color: var(--primary-teal) !important;
    color: #fff !important;
}
.badge-primary {
    background-color: var(--primary-teal) !important;
}
a {
    transition: all 0.3s ease;
}

/* Fix scattered alignment in tables and panels */
.panel-heading {
    background: #000 !important;
    color: var(--primary-teal) !important;
    font-weight: bold !important;
    text-align: center;
}
.table thead th {
    background: #f8f9fa;
    color: #000;
}

/* Redesigned Pill Buttons */
.pill-nav-item {
    margin-left: 15px;
}
.pill-btn {
    background: var(--primary-teal) !important;
    color: #fff !important;
    padding: 8px 18px !important;
    border-radius: 50px !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-weight: 600 !important;
    text-transform: none !important;
    border: 2px solid var(--primary-teal) !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
}
.pill-btn:hover {
    background: #fff !important;
    color: var(--primary-teal) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15) !important;
}
.profile-btn {
    padding: 4px 18px 4px 4px !important;
}
.profile-img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #fff;
    background: #000;
}
.d-flex {
    display: flex !important;
}
.align-items-center {
    align-items: center !important;
}
.top-nav .nav > li > a:hover, .top-nav .nav > li > a:focus {
    background: none !important;
}

/* Ensure responsiveness on mobile */
@media (max-width: 768px) {
    .market-update-gd {
        margin-bottom: 15px;
    }
    .table-responsive {
        border: none !important;
    }
}
/* Professional Footer Styling */
.professional-footer {
    background: #111;
    color: #bbb;
    padding: 60px 0 20px;
    font-size: 14px;
    border-top: 5px solid #3fbbc0;
}
.professional-footer h3, .professional-footer h4 {
    color: #fff;
    margin-bottom: 25px;
    font-weight: 700;
}
.professional-footer h3 {
    font-size: 24px;
    letter-spacing: 1px;
}
.professional-footer .footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 40px;
}
.professional-footer .footer-col ul {
    list-style: none;
    padding: 0;
}
.professional-footer .footer-col ul li {
    margin-bottom: 12px;
}
.professional-footer .footer-col ul li a {
    color: #bbb;
    transition: 0.3s;
}
.professional-footer .footer-col ul li a:hover {
    color: #3fbbc0;
    padding-left: 5px;
}
.professional-footer .social-links {
    margin-top: 20px;
    display: flex;
    gap: 15px;
}
.professional-footer .social-links a {
    width: 35px;
    height: 35px;
    background: #222;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 0.3s;
}
.professional-footer .social-links a:hover {
    background: #3fbbc0;
    transform: translateY(-3px);
}
.professional-footer .contact p {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.professional-footer .contact i {
    color: #3fbbc0;
}
.professional-footer .footer-bottom {
    margin-top: 50px;
    padding-top: 25px;
    border-top: 1px solid #222;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
@media (max-width: 991px) {
    .professional-footer .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 575px) {
    .professional-footer .footer-grid {
        grid-template-columns: 1fr;
    }
    .professional-footer .footer-bottom {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}
</style>