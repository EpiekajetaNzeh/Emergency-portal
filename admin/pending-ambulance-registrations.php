<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['eahpaid']==0)) {
  header('location:logout.php');
} else {
    // Handle AJAX accept/reject requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pending_action']) && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $action = $_POST['pending_action'];
        
        if ($action === 'accept') {
            // Get pending ambulance data
            $result = mysqli_query($con, "SELECT * FROM tblambulance_pending WHERE ID='$id'");
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // Insert into tblambulance
                $fields = "AmbulanceType, AmbRegNum, DriverName, DriverContactNumber, OwnerName, OwnerContact, Status, AuthDocument";
                $values = "'{$row['AmbulanceType']}', '{$row['AmbRegNum']}', '{$row['DriverName']}', '{$row['DriverContactNumber']}', '{$row['OwnerName']}', '{$row['OwnerContact']}', 'available', '{$row['AuthDocument']}'";
                mysqli_query($con, "INSERT INTO tblambulance ($fields) VALUES ($values)");
                // Delete from pending
                mysqli_query($con, "DELETE FROM tblambulance_pending WHERE ID='$id'");
                echo json_encode(['success' => true, 'message' => 'Ambulance accepted and added to active list.']);
            }
            exit();
        } elseif ($action === 'reject') {
            // Delete from pending
            mysqli_query($con, "DELETE FROM tblambulance_pending WHERE ID='$id'");
            echo json_encode(['success' => true, 'message' => 'Ambulance registration rejected.']);
            exit();
        }
    }
?>
<!DOCTYPE html>
<head>
<title>Pending Ambulance Registrations</title>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="css/style.css?v=<?=time()?>" rel='stylesheet' type='text/css' />
<link href="css/style-responsive.css?v=<?=time()?>" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="js/jquery2.0.3.min.js"></script>
</head>
<body>
<section id="container">
<!--header start-->
<?php include_once('includes/header.php');?>
<!--header end-->
<!--sidebar start-->
<?php include_once('includes/sidebar.php');?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pending Ambulance Registrations for Review
                </div>
                <div class="panel-body table-responsive">
                    <?php
                    $pending_result = mysqli_query($con, "SELECT * FROM tblambulance_pending");
                    $pending_count = mysqli_num_rows($pending_result);
                    
                    if ($pending_count > 0) {
                    ?>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Owner Name</th>
                                <th>Ambulance Reg No.</th>
                                <th>Driver Name</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $cnt = 1;
                            while ($pending_row = mysqli_fetch_assoc($pending_result)) { 
                            ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo $pending_row['OwnerName']; ?></td>
                                <td><span class="badge bg-info"><?php echo $pending_row['AmbRegNum']; ?></span></td>
                                <td><?php echo $pending_row['DriverName']; ?></td>
                                <td><?php echo $pending_row['OwnerContact']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#reviewModal<?php echo $pending_row['ID']; ?>"
                                            data-toggle="modal" data-target="#reviewModal<?php echo $pending_row['ID']; ?>">
                                        <i class="fa fa-eye"></i> Review
                                    </button>
                                </td>
                            </tr>
                            <?php 
                            $cnt++;
                            } ?>
                        </tbody>
                    </table>

                    <?php } else { ?>
                        <div class="alert alert-success text-center">
                            <i class="fa fa-check-circle"></i> No pending ambulance registrations. All ambulances have been reviewed!
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->
    <?php include_once('includes/footer.php');?>  
    <!-- / footer -->
</section>

<!--main content end-->
</section>
<script src="js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>

<script>
$(document).ready(function() {
    // Accept ambulance
    $('.accept-ambulance').click(function() {
        var ambulance_id = $(this).data('id');
        var modal_id = $(this).data('modal');
        
        if (confirm('Are you sure you want to ACCEPT this ambulance registration?')) {
            $.ajax({
                type: 'POST',
                url: 'pending-ambulance-registrations.php',
                data: {
                    pending_action: 'accept',
                    id: ambulance_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#' + modal_id).modal('hide');
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function() {
                    alert('An error occurred while processing your request.');
                }
            });
        }
    });
    
    // Reject ambulance
    $('.reject-ambulance').click(function() {
        var ambulance_id = $(this).data('id');
        var modal_id = $(this).data('modal');
        
        if (confirm('Are you sure you want to REJECT this ambulance registration?')) {
            $.ajax({
                type: 'POST',
                url: 'pending-ambulance-registrations.php',
                data: {
                    pending_action: 'reject',
                    id: ambulance_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#' + modal_id).modal('hide');
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function() {
                    alert('An error occurred while processing your request.');
                }
            });
        }
    });
});
</script>

<!-- Modals for all pending ambulances -->
<?php 
$pending_result_modals = mysqli_query($con, "SELECT * FROM tblambulance_pending");
while ($pending_row_modal = mysqli_fetch_assoc($pending_result_modals)) { 
?>
<div class="modal fade" id="reviewModal<?php echo $pending_row_modal['ID']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-ambulance"></i> Review Ambulance Registration</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3"><strong>Ambulance Details:</strong></h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Owner Name:</strong><br><?php echo $pending_row_modal['OwnerName']; ?></p>
                        <p><strong>Owner Contact:</strong><br><?php echo $pending_row_modal['OwnerContact']; ?></p>
                        <p><strong>Ambulance Type:</strong><br>
                        <?php 
                        $atype = $pending_row_modal['AmbulanceType'];
                        if($atype=="1") echo "Basic Life Support (BLS) Ambulances";
                        elseif($atype=="2") echo "Advanced Life Support (ALS) Ambulances";
                        elseif($atype=="3") echo "Non-Emergency Patient Transport Ambulances";
                        elseif($atype=="4") echo "Boat Ambulance";
                        else echo $atype;
                        ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ambulance Reg No:</strong><br><?php echo $pending_row_modal['AmbRegNum']; ?></p>
                        <p><strong>Driver Name:</strong><br><?php echo $pending_row_modal['DriverName']; ?></p>
                        <p><strong>Driver Contact:</strong><br><?php echo $pending_row_modal['DriverContactNumber']; ?></p>
                    </div>
                </div>
                <hr>
                <h6 class="mb-3"><strong>Authorization Document:</strong></h6>
                <?php if ($pending_row_modal['AuthDocument']) { ?>
                    <a href="../<?php echo $pending_row_modal['AuthDocument']; ?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fa fa-file-pdf-o"></i> View Document
                    </a>
                    <p class="text-muted mt-2" style="font-size: 12px;">Click the button above to view and verify the authorization document</p>
                <?php } else { ?>
                    <p class="text-danger"><i class="fa fa-exclamation-triangle"></i> No document uploaded</p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success accept-ambulance" data-id="<?php echo $pending_row_modal['ID']; ?>" data-modal="reviewModal<?php echo $pending_row_modal['ID']; ?>">
                    <i class="fa fa-check"></i> Accept
                </button>
                <button type="button" class="btn btn-danger reject-ambulance" data-id="<?php echo $pending_row_modal['ID']; ?>" data-modal="reviewModal<?php echo $pending_row_modal['ID']; ?>">
                    <i class="fa fa-times"></i> Reject
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

</body>
</html>
<?php } ?>
