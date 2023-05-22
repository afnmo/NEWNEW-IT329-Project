<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "root", "nuzl");
// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the image ID from the request data
$image_id = $_GET["image_id"];

// Get the image path from the database
$sql = "SELECT path , property_id FROM PropertyImage WHERE id=$image_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$path = $row["path"];
$property_id = $row["property_id"];

// Delete the image file from the server
unlink($path);

// Delete the image record from the database
$sql = "DELETE FROM PropertyImage WHERE id=$image_id";
mysqli_query($conn, $sql);
}

// Close the database connection
mysqli_close($conn);

// Redirect the user back to the property details page
header("Location: propertyDetails.php?property_id=$property_id");
exit();