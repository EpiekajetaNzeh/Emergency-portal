<!-- ======= Professional Footer ======= -->
<style>
.professional-footer {
    background: #111 !important;
    color: #bbb !important;
    padding: 80px 0 30px !important;
    font-size: 14px !important;
    border-top: 5px solid #3fbbc0 !important;
    width: 100% !important;
    line-height: 1.6 !important;
    text-align: left !important;
}
.professional-footer h3, .professional-footer h4 {
    color: #fff !important;
    margin-bottom: 25px !important;
    font-weight: 700 !important;
    position: relative !important;
    padding-bottom: 12px !important;
}
.professional-footer h3 {
    font-size: 26px !important;
}
.professional-footer .footer-grid {
    display: grid !important;
    grid-template-columns: 2fr 1fr 1fr 1.5fr !important;
    gap: 40px !important;
}
.professional-footer .footer-links {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
}
.professional-footer .footer-links li {
    margin: 0 0 15px 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    list-style: none !important;
}
.professional-footer .social-links {
    margin-top: 25px !important;
    display: flex !important;
    gap: 12px !important;
}
.professional-footer .social-links a {
    width: 40px !important;
    height: 40px !important;
    background: #222 !important;
    color: #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
    text-decoration: none !important;
}
.professional-footer .footer-bottom {
    margin-top: 60px !important;
    padding-top: 30px !important;
    border-top: 1px solid #222 !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: wrap !important;
}
@media (max-width: 991px) {
    .professional-footer .footer-grid {
        grid-template-columns: 1fr 1fr !important;
    }
}
@media (max-width: 575px) {
    .professional-footer .footer-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
<footer class="professional-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Column 1: About -->
            <div class="footer-col about">
                <h3>Ambullance Portal</h3>
                <p>Swift, reliable emergency medical transportation when Every. Second. Counts. We connect you to life-saving services instantly.</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <!-- Column 2: Services -->
            <div class="footer-col">
                <h4>Our Services</h4>
                <ul class="footer-links">
                    <li><i class="bi bi-chevron-right"></i> <a href="#">BLS Ambulance</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">ALS Ambulance</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Patient Transport</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Boat Ambulance</a></li>
                </ul>
            </div>

            <!-- Column 3: Quick Links -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><i class="bi bi-chevron-right"></i> <a href="index.php">Home</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="index.php#ambulance-availability">Browse Ambulances</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="check-request.php">Track Request</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="admin/login.php">Admin Login</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact -->
            <div class="footer-col contact">
                <h4>Contact Us</h4>
                <?php
                $footer_email = 'help@ambullance.com';
                $footer_phone = '671683311';
                $footer_address = 'Buea, Cameroon';
                if (isset($con)) {
                    $ft_query = mysqli_query($con, "SELECT Email, MobileNumber, PageDescription FROM tblpage WHERE PageType='contactus'");
                    if ($ft_query && mysqli_num_rows($ft_query) > 0) {
                        $ft_data = mysqli_fetch_assoc($ft_query);
                        $footer_email = !empty($ft_data['Email']) ? $ft_data['Email'] : $footer_email;
                        $footer_phone = !empty($ft_data['MobileNumber']) ? $ft_data['MobileNumber'] : $footer_phone;
                        $footer_address = !empty($ft_data['PageDescription']) ? $ft_data['PageDescription'] : $footer_address;
                    }
                }
                $display_phone = (strpos($footer_phone, '+') === 0) ? $footer_phone : '+237 ' . $footer_phone;
                ?>
                <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($footer_address); ?></p>
                <p><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($display_phone); ?></p>
                <p><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($footer_email); ?></p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> <strong>Emergency Ambulance Portal</strong>. All Rights Reserved.
            </div>
            <div class="credits">
                A premium solution by <strong>KAJETA EPIE</strong>
            </div>
        </div>
    </div>
</footer>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>