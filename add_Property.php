<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'Homeowner') 
{ 

header('Location: homepage.html');
exit(); 

}
$servername = "localhost"; // replace with your server name
$username = "root"; // replace with your database username
$password = "root";
$dbname = "nuzl"; 

// Create a database connection object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = $_POST['category'];

$sql = "SELECT id FROM PropertyCategory WHERE category='$category'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the first row as an associative array
    $row = $result->fetch_assoc();
    $category_id = $row['id'];
} else {
    // If no results were found, set the category ID to a default value
    $category_id = 1;
}

// Step 3: Retrieve the form data
$property_id = $_POST['property_id'];
$category_id = $row['id'];
$name = $_POST['name'];
$location = $_POST['location'];
$rooms = $_POST['Rooms'];
$rent = $_POST['rent'];
$tenants = $_POST['tenants'];
$description = $_POST['description'];
$homeowner_id = 1;

// Step 4:Sanitize the form data
$name = filter_var($name, FILTER_SANITIZE_STRING);
$category = filter_var($category, FILTER_SANITIZE_STRING);
$location = filter_var($location, FILTER_SANITIZE_STRING);
$rooms = filter_var($rooms, FILTER_SANITIZE_NUMBER_INT);
$rent = filter_var($rent, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$tenants = filter_var($tenants, FILTER_SANITIZE_NUMBER_INT);
$description = filter_var($description, FILTER_SANITIZE_STRING);

// Step 5: Construct the SQL query
$sql = "INSERT INTO Property (homeowner_id, property_category_id, name, rooms, rent_cost, location, max_tanants, description) 
        VALUES ($homeowner_id, $category_id, '$name', $rooms, '$rent', '$location', $tenants, '$description')";

// Step 6: Execute the SQL query
if ($conn->query($sql) === TRUE) {
    $property_id = mysqli_insert_id($conn);
    echo "Property added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

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
                header("Location: propertyDetails.php?property_id=$property_id");
                exit();
            }
        }
    }
}