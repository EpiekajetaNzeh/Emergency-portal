<?php
include('includes/dbconnection.php');
if(isset($_POST['submit'])) {
        $ambulancetype = $_POST['ambulancetype'];
        $ambregnum = $_POST['ambregnum'];
        $dname = $_POST['dname'];
        $dconnum = $_POST['dconnum'];
        $ownername = $_POST['ownername'];
        $ownercontact = $_POST['ownercontact'];
        $status = 'pending'; // Pending verification by admin

        // Phone number validation (Cameroon: 9 digits)
        if (!preg_match('/^\d{9}$/', $ownercontact) || !preg_match('/^\d{9}$/', $dconnum)) {
            $msg = "Phone numbers must be exactly 9 digits (Cameroon format).";
        } else {
            // Handle file upload
            $authDocPath = '';
            if (isset($_FILES['authdoc']) && $_FILES['authdoc']['error'] == UPLOAD_ERR_OK) {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fileName = basename($_FILES['authdoc']['name']);
                $targetFile = $targetDir . time() . '_' . $fileName;
                if (move_uploaded_file($_FILES['authdoc']['tmp_name'], $targetFile)) {
                    $authDocPath = $targetFile;
                }
            }
            $query = mysqli_query($con, "INSERT INTO tblambulance_pending (AmbulanceType, AmbRegNum, DriverName, DriverContactNumber, OwnerName, OwnerContact, Status, AuthDocument) VALUES ('$ambulancetype', '$ambregnum', '$dname', '$dconnum', '$ownername', '$ownercontact', '$status', '$authDocPath')");
            if ($query) {
                $msg = "Ambulance registration submitted! Awaiting admin verification.";
            } else {
                $msg = "Something went wrong. Please try again.";
            }
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register Your Ambulance</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/gallery/Doctor.jpg') center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div class="container" style="margin-top: 120px; margin-bottom: 60px;">
    <div class="p-4 rounded shadow-lg bg-white mx-auto" style="max-width: 100%; width: 750px;">
        <h2 class="mb-4 text-center fw-bold" style="color: #2c4964;">Register Your Ambulance</h2>
        
        <?php if(isset($msg)) { echo '<div class="alert alert-success text-center shadow-sm">'.$msg.'</div>'; } ?>
        
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="ownername" class="form-label fw-semibold">Owner Name</label>
                    <input type="text" class="form-control" id="ownername" name="ownername" required>
                </div>
                <div class="col-md-6">
                    <label for="ownercontact" class="form-label fw-semibold">Owner Contact</label>
                    <input type="text" class="form-control" id="ownercontact" name="ownercontact" required maxlength="9" pattern="\d{9}" title="Phone number must be 9 digits (Cameroon)">
                </div>
                <div class="col-md-6">
                    <label for="ambulancetype" class="form-label fw-semibold">Type of Ambulance</label>
                    <select name="ambulancetype" id="ambulancetype" class="form-select" required>
                        <option value="">Select Type of Ambulance</option>
                        <option value="1">Basic Life Support (BLS) Ambulances</option>
                        <option value="2">Advanced Life Support (ALS) Ambulances</option>
                        <option value="3">Non-Emergency Patient Transport Ambulances</option>
                        <option value="4">Boat Ambulance</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="ambregnum" class="form-label fw-semibold">Ambulance Reg No.</label>
                    <input type="text" class="form-control" id="ambregnum" name="ambregnum" required>
                </div>
                <div class="col-md-6">
                    <label for="dname" class="form-label fw-semibold">Driver Name</label>
                    <input type="text" class="form-control" id="dname" name="dname" required>
                </div>
                <div class="col-md-6">
                    <label for="dconnum" class="form-label fw-semibold">Driver Contact</label>
                    <input type="text" class="form-control" id="dconnum" name="dconnum" required maxlength="9" pattern="\d{9}" title="Phone number must be 9 digits (Cameroon)">
                </div>
            </div>
            
            <div class="mt-4 p-3 border rounded bg-light">
                <label for="authdoc" class="form-label fw-bold text-dark">Ambulance Authorization Document</label>
                <input type="file" class="form-control" id="authdoc" name="authdoc" accept=".pdf,.jpg,.jpeg,.png" required>
                <small class="text-muted mt-1 d-block">Upload PDF or Image. Max size 2MB.</small>
            </div>
            
            <div class="text-center mt-5">
                <button type="submit" name="submit" class="btn btn-primary px-5 py-3 shadow-sm w-100" style="background-color: #3fbbc0; border-color: #3fbbc0; font-size: 1.1rem; font-weight: bold; border-radius: 8px;">Submit Ambulance Registration</button>
            </div>
        </form>
    </div>
</div>
<?php include_once('includes/footer.php'); ?>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
window.addEventListener('DOMContentLoaded', function() {
    var preloader = document.getElementById('preloader');
    if (preloader) preloader.style.display = 'none';
});
</script>
</body>
</html>
