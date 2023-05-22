<?php
session_start();
// Create a database connection
ini_set("display_errors", 1);
$conn = mysqli_connect("localhost", "root", "root", "nuzl");

 if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

// Check if the user is logged in
  if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'Homeowner') 
{ 

header('Location: homepage.html');
exit(); 

}

  // Retrieve the homeowner's information from the database
  $homeowner_id = $_SESSION['userID'];
  $homeowner_info_query = "SELECT * FROM homeowner WHERE id = $homeowner_id";
  $homeowner_info_result = mysqli_query($conn, $homeowner_info_query);
  $homeowner_info = mysqli_fetch_assoc($homeowner_info_result);

  // Retrieve all rental applications for the homeowner's properties
  $rental_applications_query = "SELECT ra.id, s.status, pc.category, p.name AS property_name, p.location AS property_location, h.name AS homeowner_name, a.first_name AS homeseeker_name, a.id AS homeseeker_id, p.id AS property_id 
FROM rentalapplication ra 
JOIN property p ON ra.property_id = p.id 
JOIN homeowner h ON p.homeowner_id = h.id 
JOIN homeseeker a ON ra.home_seeker_id = a.id 
JOIN applicationstatus s ON ra.application_status_id = s.id 
JOIN propertycategory pc ON p.property_category_id = pc.id 
WHERE h.id = $homeowner_id;";
 
  
  // Attempt to run the query
if (!$rental_applications_result = mysqli_query($conn, $rental_applications_query)) {
    die("MySQL query1 failed: " . mysqli_error($conn));
}

// Check if any rental applications were found
if (mysqli_num_rows($rental_applications_result) == 0) {
    echo "No rental applications found for this homeowner.";
} else {
    // Fetch all rental applications and store them in an array
    $rental_applications = mysqli_fetch_all($rental_applications_result, MYSQLI_ASSOC);
    // Do something with the rental applications
}

  // Retrieve all unrented properties for the homeowner
$unrented_properties_query = "SELECT p.*, c.category
    FROM property p
    JOIN propertycategory c ON p.property_category_id = c.id
    WHERE p.homeowner_id = $homeowner_id
    AND p.id NOT IN (
        SELECT property_id
        FROM rentalapplication
        WHERE application_status_id = (
            SELECT id FROM applicationstatus WHERE status = 'accepted'
        )
    )";
  $unrented_properties_result = mysqli_query($conn, $unrented_properties_query);
  if (!$unrented_properties_result) {
    die("MySQL query2 failed: " . mysqli_error($conn));
}
  $unrented_properties = mysqli_fetch_all($unrented_properties_result, MYSQLI_ASSOC);


 // mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Homeowner home page </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="base.css"> 
    <link rel="stylesheet" href="homeowner.css"> 
    <script src="https://kit.fontawesome.com/5ccf46ed5e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    
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
                        <a class="nav-link link-danger" href="logout.php">Log Out</a>
                        
                    </li>

                </ul>

            </div>
        </div>
    </nav> 
        <div id="head"> 
      <h1 id="h1_ho"> Hello <?php echo $homeowner_info['name']; ?> </h1> 
    </div>
  
    <div id="info">
      <p id="p1"> Name of the owner: <?php echo $homeowner_info['name']; ?> </p> 
      <p id="p2"> Email: <?php echo $homeowner_info['email_address']; ?></p> 
      <p id="p3"> Phone number: <?php echo $homeowner_info['phone_number']; ?> </p>
    </div>
         
   
    <main>
        
            <h2>  Rental Applications </h2> 
        <br> <br> 
      <table class="RA"> 
           
            <thead>
                 <tr> 
                   <th> Property name </th>
                   <th> Location </th>
                   <th> Applicant </th>
                   <th> Status </th>
                 </tr>
            </thead>
           
            <tbody>
          <?php if (isset($rental_applications)) {
              
  foreach ($rental_applications as $application) {  ?>
    <tr>
        
      <td>
          <!-- check the name of the details page!! -->
        <a href="propertyDetails.php?property_id=<?php echo $application['property_id']; ?>"> 
          <p class="property"><?php echo $application['property_name']; ?></p>
        </a>
      </td>
      
      <td><?php echo $application['property_location']; ?></td>
      <td> <!-- check the name of the applicant info page!! -->
          <a href="applicantInfo.php?id= <?php echo $application['homeseeker_id'];?>">
             <p class="applicant"><?php echo $application["homeseeker_name"]; ?> </p>
          </a>
      </td>
      
  
          
          
      
      
      <td><?php echo $application['status']; ?></td>
      <td> 
        <?php if ($application['status'] == 'under consideration') { ?>
  <form action="update_application.php" method="post">
    <input type="hidden" name="application_id" value="<?php echo $application['id']; ?>">
    <input type="hidden" name="property_id" value="<?php echo $application['property_id']; ?>">
    <button type="submit" name="action" value="accept" class="a"> Accept </button>
    <button type="submit" name="action" value="decline" class="d"> Decline </button>
  </form>
<?php } ?>

      </td>
    </tr>
    
    
    
  <?php }
} ?>
        </tbody>
        
        </table>
      
        <br> <br> <br> <br>
        
        <h2> Listed Properties </h2>
        <div class="btn"> 
            <button id="ADD">  <a  href="addProperty.php"> Add Property </a> </button> 
        </div> 
            <table class="LP"> 
           
            <thead>
                 <tr> 
                   <th> Property Name </th>
                   <th> Category </th>
                   <th> Rent </th>
                   <th> Rooms </th>
                   <th> Location </th>
                 </tr>
            </thead>
            
            <tbody>
          <?php foreach ($unrented_properties as $property) { ?>
            <tr> 
                <!-- check the name of the details page!! -->
              <td> <a href="propertyDetails.php?property_id=<?php echo $property['id']; ?>"> <p class="property"> <?php echo $property['name']; ?> </p> </a></td>
              <td> <?php echo $property['category']; ?> </td>
              <td> <?php echo $property ["rent_cost"]; ?> </td>
              <td> <?php echo $property['rooms']; ?> </td>
              <td> <?php echo $property['location']; ?> </td>
              <td> 
                <form action="delete_property.php" method="post">
                  <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                  <button type="submit" name="delete" class="d"> Delete </button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
          </table>
      
    </main>

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

</body>
</html>
