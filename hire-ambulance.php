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
        // Phone validation (9 digits)
        $errors = array();
        if (!preg_match('/^[0-9]{9}$/', $phone)) {
            $errors[] = "Phone number must be exactly 9 digits.";
        }
        if (empty($errors)) {
            $ambregno = '';
            if ($ambulance) {
                $ambregno = $ambulance['AmbRegNum'];
            }

            $transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : '';
            $payment_status = $transaction_id ? 'Paid' : 'Pending';

            // Status is NULL by default for "New Request"
            $query = mysqli_query($con, "INSERT INTO tblambulancehiring (BookingNumber, PatientName, RelativeName, RelativeConNum, HiringDate, HiringTime, AmbulanceType, Address, City, State, Message, AmbulanceRegNo, Status, PaymentStatus, TransactionID) VALUES ('$bookingnum', '$pname', '$rname', '$phone', '$hdate', '$htime', '$ambulancetype', '$address', '$city', '$state', '$message', '$ambregno', NULL, '$payment_status', '$transaction_id')");
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
            <div class="col-12 mt-3">
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
<!-- Simplified MoMo Simulator Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-header text-white" style="background: #3fbbc0; border-bottom: none;">
        <h5 class="modal-title fw-bold" id="paymentModalLabel"><i class="fas fa-mobile-alt me-2"></i> Mobile Money Payment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <p class="mb-4 text-muted">You are about to authorize a payment of <strong class="text-dark fs-5">30,000 FCFA</strong> for this ambulance request.</p>
        
        <div class="mb-4 text-start">
            <label class="form-label text-muted fw-bold small text-uppercase">Mobile Money Number</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-secondary"></i></span>
                <input type="text" id="momoNumber" class="form-control border-start-0 ps-0" placeholder="e.g., 670000000" pattern="[0-9]{9}" maxlength="9">
            </div>
        </div>

        <div id="paymentProcessing" class="d-none my-4">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
              <span class="visually-hidden">Processing...</span>
            </div>
            <p class="mt-3 fw-bold text-primary">Dial *126# or *150# to confirm...</p>
        </div>

        <div id="paymentSuccess" class="d-none my-4">
            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-success fw-bold">Payment Successful!</h4>
            <p class="text-muted small">Transaction ID: <span id="displayTxnId" class="fw-bold"></span></p>
        </div>

        <button type="button" id="payBtn" class="btn btn-lg w-100 text-white fw-bold shadow-sm" style="background: #3fbbc0; border-radius: 8px;">
            Pay 30,000 FCFA Now
        </button>
      </div>
    </div>
  </div>
</div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
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

// Payment Simulation Logic
document.getElementById('ambulanceForm').addEventListener('submit', function(e) {
    if (!document.getElementById('transaction_id').value) {
        e.preventDefault(); // Stop form from submitting immediately
        
        // Ensure form is valid before showing modal
        if (this.checkValidity()) {
            var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        } else {
            this.reportValidity();
        }
    }
});

document.getElementById('payBtn').addEventListener('click', function() {
    var number = document.getElementById('momoNumber').value;
    if(number.length !== 9) {
        alert("Please enter a valid 9-digit Mobile Money number.");
        return;
    }

    // Hide inputs, show spinner
    document.getElementById('momoNumber').parentElement.parentElement.classList.add('d-none');
    this.classList.add('d-none');
    document.getElementById('paymentProcessing').classList.remove('d-none');

    // Simulate 4-second API Gateway delay
    setTimeout(function() {
        document.getElementById('paymentProcessing').classList.add('d-none');
        document.getElementById('paymentSuccess').classList.remove('d-none');
        
        // Generate mock transaction ID
        var mockTxnId = 'MOMO_' + Math.random().toString(36).substr(2, 9).toUpperCase();
        document.getElementById('displayTxnId').innerText = mockTxnId;
        
        // Inject into hidden form field
        document.getElementById('transaction_id').value = mockTxnId;

        // Auto-submit the actual form after 1.5 seconds so user sees success
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            modal.hide();
            
            // Bypass the event listener by triggering submit on the form element directly
            HTMLFormElement.prototype.submit.call(document.getElementById('ambulanceForm'));
        }, 1500);

    }, 4000);
});
</script>
</body>
</html>
