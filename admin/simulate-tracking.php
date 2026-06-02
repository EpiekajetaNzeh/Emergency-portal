<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');

if (strlen($_SESSION['eahpaid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Ambulance Simulation | Emergency Ambulance Hiring Portal</title>
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
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 500px; width: 100%; cursor: crosshair; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .sim-controls { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
</style>
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
		<div class="form-w3layouts">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Simulate Ambulance Tracking
                        </header>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="sim-controls">
                                        <div class="form-group">
                                            <label>Select Ambulance:</label>
                                            <select id="amb_reg_no" class="form-control">
                                                <option value="">-- Select Ambulance --</option>
                                                <?php 
                                                $query = mysqli_query($con, "SELECT AmbRegNum, DriverName FROM tblambulance");
                                                while($row = mysqli_fetch_array($query)){
                                                    echo "<option value='".$row['AmbRegNum']."'>".$row['AmbRegNum']." (".$row['DriverName'].")</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Latitude:</label>
                                            <input type="text" id="lat" class="form-control" readonly style="background: #f9f9f9;">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label>Longitude:</label>
                                            <input type="text" id="lng" class="form-control" readonly style="background: #f9f9f9;">
                                        </div>
                                        <button class="btn btn-primary mt-3 btn-block" onclick="updateLocation()">
                                            <i class="fa fa-map-marker"></i> Update Location
                                        </button>
                                        <div id="status" class="mt-3"></div>
                                    </div>
                                    <div class="alert alert-info mt-4">
                                        <i class="fa fa-info-circle"></i> <strong>Instructions:</strong>
                                        <ul style="padding-left: 20px; margin-top: 10px;">
                                            <li>Select an ambulance from the dropdown.</li>
                                            <li>Click anywhere on the map to pick a location.</li>
                                            <li>Click "Update Location" to save.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </section>
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
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([4.1593, 9.2435], 13); // Default to Buea, Cameroon
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        
        document.getElementById('lat').value = lat.toFixed(6);
        document.getElementById('lng').value = lng.toFixed(6);

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });

    function updateLocation() {
        var amb_reg_no = document.getElementById('amb_reg_no').value;
        var lat = document.getElementById('lat').value;
        var lng = document.getElementById('lng').value;

        if (!amb_reg_no || !lat || !lng) {
            alert("Please select an ambulance and pick a location on the map.");
            return;
        }

        var formData = new FormData();
        formData.append('amb_reg_no', amb_reg_no);
        formData.append('lat', lat);
        formData.append('lng', lng);

        fetch('../update-location.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            var statusDiv = document.getElementById('status');
            if (data.status === 'success') {
                statusDiv.innerHTML = '<div class="alert alert-success"><i class="fa fa-check"></i> Location updated successfully!</div>';
            } else {
                statusDiv.innerHTML = '<div class="alert alert-danger"><i class="fa fa-times"></i> Error: ' + data.message + '</div>';
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
</body>
</html>
<?php } ?>
