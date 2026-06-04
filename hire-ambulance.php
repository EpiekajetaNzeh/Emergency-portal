<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');
$ambulance_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$ambulance = null;
if ($ambulance_id > 0) {
    $result = mysqli_query($con, "SELECT * FROM tblambulance WHERE ID = $ambulance_id");
    $ambulance = mysqli_fetch_assoc($result);
    if ($ambulance) {
        $status = strtolower(trim($ambulance['Status']));
        if ($status != '' && $status != 'available' && $status != 'reached') {
            echo "<script>alert('This ambulance is currently on a mission and not available for hire. Please choose another one.');</script>";
            echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            exit;
        }
    }
}
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
        $ambid = $_POST['ambulance_id'];
        $payment_amount = isset($_POST['payment_amount']) ? preg_replace('/[^0-9]/', '', $_POST['payment_amount']) : '30000';
        $payment_phone = isset($_POST['payment_phone']) ? preg_replace('/[^0-9+]/', '', $_POST['payment_phone']) : '';
        // Phone validation (9 digits)
        $errors = array();
        if (!preg_match('/^[0-9]{9}$/', $phone)) {
            $errors[] = "Relative phone number must be exactly 9 digits.";
        }
        if (empty($payment_phone) || !preg_match('/^[0-9]{9,15}$/', preg_replace('/^\+/', '', $payment_phone))) {
            $errors[] = "Please enter a valid mobile money phone number.";
        }
        if (empty($payment_amount) || intval($payment_amount) < 1) {
            $errors[] = "Please enter a valid amount to pay.";
        }
        if (empty($errors)) {
            $ambregno = '';
            if ($ambulance) {
                $ambregno = $ambulance['AmbRegNum'];
            }

            $transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : '';
            $payment_status = $transaction_id ? 'Paid' : 'Pending';

            // Status is NULL by default for "New Request"
            $query = mysqli_query($con, "INSERT INTO tblambulancehiring (BookingNumber, PatientName, RelativeName, RelativeConNum, HiringDate, HiringTime, AmbulanceType, Address, City, State, Message, AmbulanceRegNo, Status, PaymentStatus, TransactionID, AmountPaid, PaymentNumber) VALUES ('$bookingnum', '$pname', '$rname', '$phone', '$hdate', '$htime', '$ambulancetype', '$address', '$city', '$state', '$message', '$ambregno', NULL, '$payment_status', '$transaction_id', '$payment_amount', '$payment_phone')");
            if ($query) {
                echo "<script>alert('Your request has been sent successfully. Your Booking Number is: $bookingnum');</script>";
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        } else {
            foreach ($errors as $err) {
                echo "<div class='alert alert-danger text-center'>$err</div>";
            }
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Hire Ambulance</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/gallery/Ambulance2.jpg') center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div class="container" style="margin-top: 120px; margin-bottom: 60px;">
    <div class="p-4 rounded shadow-lg bg-white mx-auto" style="max-width: 100%; width: 750px;">
        <h2 class="mb-4 text-center fw-bold" style="color: #2c4964;">Hire Ambulance</h2>
        
        <?php if($ambulance): ?>
            <div class="alert alert-info text-center mb-4 shadow-sm" style="background-color: #e9f7f8; border-color: #3fbbc0; color: #3fbbc0;">You are hiring: <strong><?php echo $ambulance['AmbRegNum']; ?></strong> (<?php echo $ambulance['DriverName']; ?>)</div>
        <?php endif; ?>
        
        <div class="alert alert-warning text-center mb-4 shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i> 
            <strong>Payment Notice:</strong> A non-refundable hiring fee of <span class="badge bg-dark">30,000 FCFA</span> is required to process your request.
        </div>
        
        <form method="post" action="" id="ambulanceForm">
        <input type="hidden" name="ambulance_id" value="<?php echo $ambulance_id; ?>">
        <input type="hidden" name="transaction_id" id="transaction_id" value="">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="pname" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="pname" name="pname" required>
            </div>
            <div class="col-md-6">
                <label for="rname" class="form-label">Relative Name</label>
                <input type="text" class="form-control" id="rname" name="rname" required>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Relative Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{9}" maxlength="9" required title="Enter exactly 9 digits">
            </div>
            <div class="col-md-6">
                <label for="ambulancetype" class="form-label">Type of Ambulance</label>
                <select name="ambulancetype" id="ambulancetype" class="form-select" required>
                    <option value="">Select Type of Ambulance</option>
                    <option value="1" <?php if($ambulance && $ambulance['AmbulanceType']=='1') echo 'selected'; ?>>Basic Life Support (BLS) Ambulances</option>
                    <option value="2" <?php if($ambulance && $ambulance['AmbulanceType']=='2') echo 'selected'; ?>>Advanced Life Support (ALS) Ambulances</option>
                    <option value="3" <?php if($ambulance && $ambulance['AmbulanceType']=='3') echo 'selected'; ?>>Non-Emergency Patient Transport Ambulances</option>
                    <option value="4" <?php if($ambulance && $ambulance['AmbulanceType']=='4') echo 'selected'; ?>>Boat Ambulance</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="hdate" class="form-label">Hiring Date</label>
                <input type="date" class="form-control" id="hdate" name="hdate" required>
            </div>
            <div class="col-md-6">
                <label for="htime" class="form-label">Hiring Time</label>
                <input type="time" class="form-control" id="htime" name="htime" required>
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-md-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="col-md-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="col-12">
                <label for="message" class="form-label">Message (Optional)</label>
                <textarea class="form-control" id="message" name="message" rows="2"></textarea>
            </div>

            <!-- Payment Section -->
            <div class="col-12 mt-3">
                <hr style="border-color: #3fbbc0;">
                <h5 class="fw-bold mb-3" style="color:#2c4964;"><i class="fas fa-credit-card me-2" style="color:#3fbbc0;"></i>Payment Information</h5>
            </div>
            <div class="col-md-6">
                <label for="payment_phone" class="form-label fw-bold">Mobile Money Phone Number <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#e9f7f8; color:#3fbbc0; border-color:#3fbbc0;"><i class="fas fa-mobile-alt"></i></span>
                    <input type="tel" class="form-control" id="payment_phone" name="payment_phone"
                        placeholder="e.g. 676123456" maxlength="15" required
                        title="Enter your MTN or Orange mobile money number">
                </div>
                <small class="text-muted">Enter the number to be charged (MTN/Orange MoMo)</small>
            </div>
            <div class="col-md-6">
                <label for="payment_amount" class="form-label fw-bold">Amount to Pay (FCFA) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text" style="background:#e9f7f8; color:#3fbbc0; border-color:#3fbbc0;"><i class="fas fa-coins"></i></span>
                    <input type="number" class="form-control" id="payment_amount" name="payment_amount"
                        value="30000" min="30000" required
                        title="Minimum amount is 30,000 FCFA">
                </div>
                <small class="text-muted">Minimum fee is 30,000 FCFA</small>
            </div>
            <div class="col-12 mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="paymentAgreement" required>
                    <label class="form-check-label fw-bold" for="paymentAgreement">
                        I agree to pay the <span class="text-primary" style="color: #3fbbc0 !important;">30,000 FCFA</span> hiring fee to proceed with this request.
                    </label>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" name="submit" id="submitBtn" class="btn btn-primary px-5 py-2 shadow-sm" style="background-color: #3fbbc0; border-color: #3fbbc0; font-weight: bold;" disabled>Submit Request</button>
        </div>
    </form>
  </div>
</div>
<?php include_once('includes/footer.php'); ?>
<!-- Hidden trigger button for CamPay SDK -->
<button type="button" id="payButton" class="d-none"></button>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://demo.campay.net/sdk/js?app-id=72Zz60HKh10kP6Egfx_lsigAvW9Cee1UVIMuHHA0tvR_2aCqFu9pg6Sj6ld-Z3qjbg3gLKLMOxoAu_xGq_g5bg"></script>
<script>
// Remove preloader if present
window.addEventListener('DOMContentLoaded', function() {
    var preloader = document.getElementById('preloader');
    if (preloader) preloader.style.display = 'none';
});

// Toggle submit button based on checkbox
document.getElementById('paymentAgreement').addEventListener('change', function() {
    document.getElementById('submitBtn').disabled = !this.checked;
});

// Configure CamPay Options initially
campay.options({
    payButtonId: "payButton",
    description: "Ambulance Hiring Fee",
    amount: "30000",
    currency: "XAF",
    externalReference: "",
    redirectUrl: ""
});

// Payment Integration Logic
document.getElementById('ambulanceForm').addEventListener('submit', function(e) {
    if (!document.getElementById('transaction_id').value) {
        e.preventDefault(); // Stop form from submitting immediately
        
        // Ensure form is valid before initiating payment
        if (this.checkValidity()) {
            var patientName = document.getElementById('pname').value;
            var paymentPhone = document.getElementById('payment_phone').value;
            var paymentAmount = document.getElementById('payment_amount').value || '30000';
            
            // Configure CamPay options dynamically with user-entered amount and phone
            campay.options({
                payButtonId: "payButton",
                description: "Ambulance Hire - " + patientName,
                amount: paymentAmount,
                currency: "XAF",
                externalReference: paymentPhone,
                redirectUrl: ""
            });
            
            // Programmatically click the hidden payButton to trigger CamPay modal
            document.getElementById('payButton').click();
        } else {
            this.reportValidity();
        }
    }
});

// CamPay Callbacks
campay.onSuccess = function (data) { 
    // Set transaction reference in the hidden field
    document.getElementById('transaction_id').value = data.reference;
    // Submit the form programmatically
    HTMLFormElement.prototype.submit.call(document.getElementById('ambulanceForm'));
};

campay.onFail = function (data) { 
    alert('Payment Failed! Status: ' + data.status + '\nReference: ' + data.reference);
};

campay.onModalClose = function (data) { 
    console.log('Payment modal closed: ' + data.status);
};
</script>
</body>
</html>
