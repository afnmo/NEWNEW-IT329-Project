<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "root", "nuzl");

// Check if the connection was successful
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the property ID from the form data
$property_id = $_POST["property_id"];

// Update the property information in the database
$name = $_POST["name"];
$category_id = $_POST["category_id"];
$rooms = $_POST["rooms"];
$rent_cost = $_POST["rent_cost"];
$location = $_POST["location"];
$max_tenants = $_POST["max_tanants"];
$description = $_POST["description"];

$sql = "UPDATE Property SET name='$name', property_category_id='$category_id', rooms='$rooms', rent_cost='$rent_cost', location='$location', max_tanants='$max_tenants', description='$description' WHERE id=$property_id";
mysqli_query($conn, $sql);
echo $sql;

$num_rows_affected = mysqli_affected_rows($conn);
if ($num_rows_affected > 0) {
echo "Property information updated successfully.";
} else {
echo "No changes were made to the property information.";
}

// Update the property images in the database
if (!empty($_FILES["images"]["name"][0])) {
$upload_dir = "Images/";
$allowed_extensions = array("jpg", "jpeg", "png", "gif");

foreach ($_FILES["images"]["error"] as $key => $error) {
if ($error == UPLOAD_ERR_OK) {
$tmp_name = $_FILES["images"]["tmp_name"][$key];
$name = $_FILES["images"]["name"][$key];

  // Check if the file has a valid extension
  $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  if (in_array($extension, $allowed_extensions)) {
    // Generate a unique filename
    $filename = uniqid() . "." . $extension;

    // Move the file to the upload directory
    move_uploaded_file($tmp_name, $upload_dir . $filename);

    // Insert the image record into the database
    $sql = "INSERT INTO PropertyImage (path, property_id) VALUES ('$upload_dir$filename', $property_id)";
    mysqli_query($conn, $sql);
  }
}
}
}

// Close the database connection
mysqli_close($conn);

// Redirect the user to the property details page
header("Location: propertyDetails.php?property_id=$property_id");
exit();