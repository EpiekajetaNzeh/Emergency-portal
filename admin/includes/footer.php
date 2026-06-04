<!-- ======= Professional Footer ======= -->
<footer class="professional-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Column 1: About -->
            <div class="footer-col about">
                <h3>Ambullance Portal</h3>
                <p>Swift, reliable emergency medical transportation when Every. Second. Counts. We connect you to life-saving services instantly.</p>
                <div class="social-links">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>

            <!-- Column 2: Services -->
            <div class="footer-col">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">BLS Ambulance</a></li>
                    <li><a href="#">ALS Ambulance</a></li>
                    <li><a href="#">Patient Transport</a></li>
                    <li><a href="#">Boat Ambulance</a></li>
                </ul>
            </div>

            <!-- Column 3: Quick Links -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="all-ambulance.php">Browse Ambulances</a></li>
                    <li><a href="check-request.php">Track Request</a></li>
                    <li><a href="admin/login.php">Admin Login</a></li>
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
                <p><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($footer_address); ?></p>
                <p><i class="fa fa-phone"></i> <?php echo htmlspecialchars($display_phone); ?></p>
                <p><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($footer_email); ?></p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong>Emergency Ambulance Portal</strong>. All Rights Reserved.</p>
            <p class="credits text-muted">A premium solution by <strong>KAJETA EPIE</strong></p>
        </div>
    </div>
</footer>