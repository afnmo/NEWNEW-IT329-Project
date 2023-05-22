<?php 
session_start();
// Create a new mysqli object to establish a connection
$conn = mysqli_connect("localhost", "root", "root", "nuzl");

 // Check if the user is logged in
  if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'Homeowner') 
{ 

header('Location: homepage.html');
exit(); 

}
// Check if the connection was successful
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);}

// Retrieve the property ID from the POST data
$property_id = $_POST['property_id'];

// Delete the property from the Property table
mysqli_query($conn, "DELETE FROM Property WHERE id = $property_id");

// Delete all rental applications for the property
mysqli_query($conn, "DELETE FROM RentalApplication WHERE property_id = $property_id");

// Delete all images for the property
mysqli_query($conn, "DELETE FROM PropertyImage WHERE property_id = $property_id");

// Redirect the homeowner to their homepage
header("Location: HomeOwner.php");
exit();

?>

