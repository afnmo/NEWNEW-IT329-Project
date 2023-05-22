<?php
session_start();
// Establish a database connection
$dbhost = 'localhost';
$dbname = 'nuzl';
$dbuser = 'root';
$dbpass = 'root';

if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != "Homeowner") {
    header('Location: homepage.html');
    exit();
}
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$error = mysqli_connect_error();
if ($error != null) {
    echo "<p> Cannot connect with DataBase </p>";
}



// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = mysqli_query($connection, "SELECT id FROM propertyCategory WHERE category = '" . $_POST['category'] . "'");
    $resultArray = mysqli_fetch_all($result);
    $category_id = $resultArray[0][0];

    // Set the values of the parameters
    $homeowner_id = $_SESSION['userID']; // Replace with the ID of the logged-in homeowner
    $name = $_POST["name"];
    $rooms = $_POST["Rooms"];
    $rent_cost = $_POST["rent"];
    $location = $_POST["location"];
    $max_tenants = $_POST["tenants"];
    $description = $_POST["description"];

    $sql = "INSERT INTO property (homeowner_id, property_category_id, name, rooms, rent_cost, location, max_tanants, description) "
            . "VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    if ($statement = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($statement, "iisiisis", $homeowner_id, $category_id,
                $name, $rooms, $rent_cost, $location, $max_tenants, $description);
        if (mysqli_stmt_execute($statement)) {
//            successfully executed
//            get the last inserted id by the last query, (insert query above) in this case
//            only works with auto increment
            $property_id = mysqli_insert_id($connection);
        } else {
//            failed execute insert query
        }
    } else {
//        failed prepare statement
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

    // Redirect the user to the new property details page
    // make sure the name is correct!
    header("Location: propertyDetails.php?id=" . $id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Add Property </title>
        <!-- -- -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css"> 
        <!-- -- -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="addProperty.css">
        <link rel="stylesheet" href="base.css"> 
        <script src="https://kit.fontawesome.com/5ccf46ed5e.js" crossorigin="anonymous"></script>
    </head>


    <body>

        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
            <div class="container">
                <a class="navbar-brand" href="homepage.html"><img id="logo" src="images/Nuzl logo.png" alt="Nuzl logo" width="150"
                                                                  height="90" class="d-inline-block align-text-top"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link" href="homepage.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#prop">Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Account">Account</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link link-danger" href="logIn.html">Log Out</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav> 

        <h1 id="addText"> Add A Property </h1>


        <form class="form_Add" action="addProperty.php" method="post">
            <fieldset>
                <legend> Property Details </legend>
                <i class="fa fa-home"></i> <label for="name"> Property Name:</label><br>
                <input type="text" id="name" name="name" required><br>

                <p> <i class="fa fa-home"></i> Category:

                    <input type="radio" name="category" value="apartment" required> Apartment
                    <input type="radio" name="category" value="villa"> Villa
                    <input type="radio" name="category" value="duplex"> Duplex 
                </p>



                <i class="fa fa-home"></i> <label for="location"> Location:</label><br>
                <input type="text" id="location" name="location" required><br>

                <i class="fa fa-home"></i> <label for="Rooms"> Number of rooms:</label><br>
                <input type="number" id="Rooms" name="Rooms" value="" required><br>

                <i class="fa fa-home"></i> <label for="rent"> Rent:</label><br>
                <input type="number" id="rent" name="rent" value="" placeholder="Rent per month" required min="50"> <br>


                <i class="fa fa-home"></i> <label for="tenants"> Maximum Number Of Tenants:</label><br>
                <input type="number" id="tenants" name="tenants" value="" required> <br>

                <p><i class="fa fa-home"></i> Description: </p>
                <textarea name="description" rows="5" cols="64" id="description"
                          placeholder="Add a decription of the property" required></textarea>
                <br>

                <p> <i class="fa fa-home"></i> Upload Pictures Of The Property:</P> 
                <input type="file" id="pic1" name="pic1" accept="image/jpeg, image/png, image/jpg" required> <br>
                <br>
            </fieldset>
            <br>
            <div id="submit">
                <input type="hidden" name="application_id" value="<?php echo $application['id']; ?>">
                <input type="submit" id="addP" class="submit" value="Add">
            </div>




        </form>
        <div id="btn">
            <button id="logOutBtn"><a href="homepage.html"> Log out </a></button>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="footer-col">
                        <h4>company</h4>
                        <ul>
                            <li><a href="#">about us</a></li>
                            <li><a href="#">our services</a></li>
                            <li><a href="#">privacy policy</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>get help</h4>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">order status</a></li>
                            <li><a href="#">payment options</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>follow us</h4>
                        <div class="social-links">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <p>&copy;2023 All Rights Reserved</p>
                </div>
            </div>
        </footer> 


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script> 

    </body>

</html>