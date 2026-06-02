<?php
include('includes/dbconnection.php');

if(isset($_POST['amb_reg_no']) && isset($_POST['lat']) && isset($_POST['lng'])){
    $amb_reg_no = mysqli_real_escape_string($con, $_POST['amb_reg_no']);
    $lat = mysqli_real_escape_string($con, $_POST['lat']);
    $lng = mysqli_real_escape_string($con, $_POST['lng']);

    $query = "UPDATE tblambulance SET Latitude = '$lat', Longitude = '$lng' WHERE AmbRegNum = '$amb_reg_no'";
    if(mysqli_query($con, $query)){
        echo json_encode(["status" => "success", "message" => "Location updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($con)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid parameters"]);
}
?>
