<?php
include('includes/dbconnection.php');

if(isset($_GET['booking_number'])){
    $booking_number = mysqli_real_escape_string($con, $_GET['booking_number']);
    
    // Find the ambulance registration number assigned to this booking
    $query = "SELECT tblambulance.Latitude, tblambulance.Longitude FROM tblambulancehiring 
              LEFT JOIN tblambulance ON tblambulance.AmbRegNum = tblambulancehiring.AmbulanceRegNo 
              WHERE tblambulancehiring.BookingNumber = '$booking_number' AND (tblambulancehiring.Status = 'Assigned' OR tblambulancehiring.Status = 'On the way' OR tblambulancehiring.Status = 'Pickup')";
    
    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        echo json_encode(["status" => "success", "data" => $row]);
    } else {
        echo json_encode(["status" => "error", "message" => "Ambulance not found or not in tracking status"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid parameters"]);
}
?>
