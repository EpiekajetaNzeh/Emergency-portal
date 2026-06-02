<?php
session_start();
include('includes/dbconnection.php');

if (empty($_GET['id']) || empty($_GET['bookingnum'])) {
    header('location:ambulance-tracking.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 

  <title>Emergancy Ambulance Hiring Portal</title>


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
  
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <style>
    #map { height: 400px; width: 100%; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    
    /* Ensure table text is clearly visible on mobile devices */
    @media (max-width: 768px) {
      .table-responsive .table th, 
      .table-responsive .table td {
        font-size: 16px !important;
        padding: 14px 10px !important;
        line-height: 1.6;
      }
      .table-responsive .table th {
        font-weight: 700;
        background-color: #f7fcfc !important;
      }
      h3 { font-size: 22px !important; }
    }
  </style>

</head>

<body>

  <?php include_once('includes/header.php');?>

  <main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Ambulance Tracking</h2>
          <ol>
            <li><a href="index.php" href="#hero">Home</a></li>
            <li>Ambulance Tracking</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
      <div class="container">
       <?php
$id = $_GET['id'];   
$ret = mysqli_query($con, "SELECT tblambulancehiring.*,tblambulance.AmbRegNum, tblambulance.DriverName,tblambulance.DriverContactNumber FROM tblambulancehiring 
    left join tblambulance on tblambulance.AmbRegNum=tblambulancehiring.AmbulanceRegNo  WHERE tblambulancehiring.ID = '$id'");


while ($row = mysqli_fetch_array($ret)) {
   $arnum = $row['AmbulanceRegNo'];
?>
<div class="table-responsive">
<table border="1" class="table table-bordered mg-b-0">
    <tr align="center">
        <th colspan="6" style="font-size:20px;color:blue;text-align: center;">
            View Request Details of #<?php echo $row['BookingNumber']; ?></th>
        
    </tr>
    <tr>
        <th>Patient Name</th>
        <td><?php echo $row['PatientName']; ?></td>
        <th>Relative Name</th>
        <td><?php echo $row['RelativeName']; ?></td>
    </tr>
    <tr>
    <th>Relative Contact Number</th>
    <td><?php  echo $row['RelativeConNum'];?></td>
    <th>Hiring Date</th>
    <td><?php  echo $row['HiringDate'];?></td>
    
  </tr>
  <tr>
    <th>Hiring Time</th>
    <td><?php  echo $row['HiringTime'];?></td>
     <th>Booking Date</th>
     <td><?php  echo $row['BookingDate'];?></td>
     <tr>
        <tr>
    <th>Address</th>
    <td><?php  echo $row['Address'];?></td>
    <th>City</th>
    <td><?php  echo $row['City'];?></td>
  </tr>
   <tr>
    <th>State</th>
    <td><?php  echo $row['State'];?></td>
    <th>Message</th>
    <td><?php  echo $row['Message'];?></td>
  </tr>
    <!-- Display other request details -->

    <?php
    $atype = $row['AmbulanceType'];  
    $ambulanceTypeText = "";
    switch ($atype) {
        case "1":
            $ambulanceTypeText = "Basic Life Support (BLS) Ambulances";
            break;
        case "2":
            $ambulanceTypeText = "Advanced Life Support (ALS) Ambulances";
            break;
        case "3":
            $ambulanceTypeText = "Non-Emergency Patient Transport Ambulances";
            break;
        case "4":
            $ambulanceTypeText = "Boat Ambulance";
            break;
        default:
            $ambulanceTypeText = "Unknown";
            break;
    }
    ?>
    <tr>
        <th>Ambulance Type</th>
        <td colspan="3"><?php echo $ambulanceTypeText; ?></td>
    </tr>
    <!-- Display other request details -->

    <?php if ($row['Remark'] != ''): ?>
    <tr>
        <th>Remark</th>
        <td><?php echo $row['Remark']; ?></td>
        <?php if ($row['Status'] != ''): ?>
        <th>Status</th>
        <td><?php echo $row['Status']; ?></td>
        <?php endif; ?>
    </tr>
  
    </tr>
    <?php endif; ?>
     <?php if ($row['Status'] != ''){ ?>
    <tr>     
       <th>Driver Name</th>
        <td><?php echo $row['DriverName']; ?></td>
         <th>Driver Contact Number</th>
        <td><?php echo $row['DriverContactNumber']; ?></td>
      </tr>
 <?php }else {?>
  <tr>     
       <th>Driver Name</th>
        <td>Not Assigned Yet</td>
         <th>Driver Contact Number</th>
        <td>Not Assigned Yet</td>
      </tr><?php }?>
</table>

<?php
}
?>

<div class="row">
    <div class="col-12">
        <h3 style="color:blue; margin-bottom: 15px;">Real-time Ambulance Tracking</h3>
        <div id="map"></div>
    </div>
</div>

<?php 
  $bookingnum=$_GET['bookingnum'];
$query1=mysqli_query($con,"SELECT Remark,Status,UpdationDate,BookingNumber,AmbulanceRegNum FROM tbltrackinghistory

    where BookingNumber='$bookingnum'");
$count=mysqli_num_rows($query1);
if($count>0){
     ?>
 <div class="col-12">
        <div class="table-responsive">
<table class="table table-bordered" border="1" width="100%">
                                        <tr>
                                            <th colspan="6" style="text-align:center;">Tracking History</th>
                                        </tr>
                                        <tr>
                                            <th>Remark</th>
                                            <th>Status</th>
                                            <th>Ambulance Registration Number </th>
                                            <th>Action Date</th>
                                        </tr>
<?php 
while($row1=mysqli_fetch_array($query1))
{
?>  

<tr>
<td><?php echo htmlentities($row1['Remark']);?></td>
                 <td> <?php   $pstatus=$row1['Status'];  
                 if($pstatus==""){ ?>
<span>New</span>
 <?php } elseif($pstatus=="Assigned"){ ?>
<span>Assigned</span>
 <?php } elseif($pstatus=="On the way"){ ?>
<span>On the Way</span>
 <?php } elseif($pstatus=="Pickup"){ ?>
<span>Patient Pick</span>
 <?php } elseif($pstatus=="Reached"){ ?>
<span>Patient Reached Hospital</span>
 <?php } elseif($pstatus=="Rejected"){ ?>
<span>Rejected</span>

<?php } ?>
</td>
<td><?php echo htmlentities($row1['AmbulanceRegNum']);?></td>
<td><?php echo htmlentities($row1['UpdationDate']);?></td>
             
</tr>
<?php } ?>

</table>
<?php } ?>
      </div>
    </section>

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

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    var map = L.map('map').setView([4.1593, 9.2435], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([0, 0]).addTo(map);
    var bookingNumber = '<?php echo $_GET['bookingnum']; ?>';

    function updateLocation() {
        fetch('get-ambulance-location.php?booking_number=' + bookingNumber)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    var lat = parseFloat(data.data.Latitude);
                    var lng = parseFloat(data.data.Longitude);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        var newLatLng = new L.LatLng(lat, lng);
                        marker.setLatLng(newLatLng);
                        map.setView(newLatLng);
                        marker.bindPopup("<b>Ambulance Registration No:</b> <?php echo $arnum; ?>").openPopup();
                    }
                }
            })
            .catch(error => console.error('Error fetching location:', error));
    }

    // Update every 5 seconds
    setInterval(updateLocation, 5000);
    // Initial update
    updateLocation();
  </script>

</body>

</html>
