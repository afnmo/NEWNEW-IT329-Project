<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'Homeowner') 
{ 

header('Location: homepage.html');
exit(); 

}
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Create a connection to the database
$conn = mysqli_connect("localhost", "root", "root", "nuzl");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}


if (isset($_POST['application_id']) && isset($_POST['action'])) {
  $application_id = $_POST['application_id'];
  $action = $_POST['action'];
  $seeker_id = $_POST['seeker_id'];
  $prop_id = $_POST['property_id'];

  // Update the status of the rental application based on the clicked button
  if ($action == 'accept') {
  // Set the status of the selected application to "accepted"
  $new_status = 'accepted';

  // Set the status of other applications for the same property to "declined"
  $update = "UPDATE rentalapplication SET 
    application_status_id = '222'
    WHERE 
    id <> '$application_id'
    AND property_id = '$prop_id'
    AND application_status_id = '333';";

mysqli_query($conn, $update);

  // Debugging statement
//echo "Update query for other rental applications: $update<br>";
}

else if ($action == 'decline') {
  // Set the status of the selected application to "declined"
  $new_status = 'declined';
}

  $update_query = "UPDATE rentalapplication SET 
    application_status_id = (
      SELECT id FROM applicationstatus WHERE status = '$new_status'
    )
    WHERE id = $application_id";
  mysqli_query($conn, $update_query);
  
  // Debugging statement
  //echo "Update query for selected rental application: $update_query<br>";

  // Redirect to the homeowner's homepage
  header("Location: HomeOwner.php");
  exit();
}
?>
