<?php
        //1
        $connection = mysqli_connect("localhost", "root", "root", "nuzl");
        $error = mysqli_connect_error();

        if ($error != null) {
            echo "<p>Could not connect to the database.</p>";
        } else{
        if(isset($_GET['property_id'])){ 
        $property_id = $_GET['property_id'];
    
        $query2 = "SELECT p.*, c.category FROM property p JOIN propertycategory c ON p.property_category_id = c.id WHERE p.id = $property_id";
        $result2 = mysqli_query($connection, $query2);

        if ($result2 == false || mysqli_num_rows($result2) == 0) {
        echo "<p>No property was found with id $property_id.</p>";
        } else {
             $property2 = mysqli_fetch_assoc($result2);
        }
        
          $query = "SELECT p.*, h.name AS homeowner_name, h.phone_number, h.email_address
          FROM Property p
          JOIN Homeowner h ON p.homeowner_id = h.id
          WHERE p.id = $property_id";
    
            $result = mysqli_query($connection, $query);

            if (!$result) {
            echo "Failed to retrieve property information from the database: " . mysqli_error($connection);
            exit();
        }
        if (mysqli_num_rows($result) == 0) {
            echo "No property was found with ID $property_id.";
            exit();
        }
        else
        { $property = mysqli_fetch_assoc($result); }
        
        //2
        session_start(); //check user type and id 
     /*   $_SESSION['userID']=1;
        $_SESSION['role'] = 'homeseeker'; */

        if (!isset($_SESSION['userID']) || !isset($_SESSION['role']))
        {
            header('Location: homepage.html');
            exit(); }
           
         
        if ($_SESSION['role'] == 'homeseeker') 
        {
            
        $homeowner_name = $property['homeowner_name'];
        $phone_number = $property['phone_number'];
        $email_address = $property['email_address'];
        
        //check if he did apply to the property
         $home_seeker_id =$_SESSION['userID'];
         $query3 = "SELECT id FROM RentalApplication WHERE property_id = $property_id AND home_seeker_id = $home_seeker_id";
         $result3 = mysqli_query($connection, $query3);

            if (!$result3) {
            echo "Failed to retrieve property information from the database: " . mysqli_error($connection);
            exit(); } }  
        
         $query_images = "SELECT * FROM PropertyImage WHERE property_id = $property_id";
        $result_images = mysqli_query($connection, $query_images); }}
         
       ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Property Details - <?php echo $property['name']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="base.css"> 
    <link rel="stylesheet" href="details.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img id="logo" src="images/Nuzl logo.png" alt="Nuzl logo" width="150"
                    height="90" class="d-inline-block align-text-top"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Account</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link link-danger" href="homepage.html">Log Out</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav> 

    <h1><?php echo $property['name']; ?></h1>
  
    <form class="form-style-4" action="" method="post">
        <label for="field1">
        <span>Property Name</span><input type="text" name="field1" value="<?php echo $property['name'];?>"/>
        </label>
        <label for="field2">
        <span>Category</span><input type="text" name="field2" value="<?php echo $property2['category']; ?>"/>
        </label>
        <label for="field3">
        <span> Number Of Rooms </span><input type="text" name="field3" value="<?php echo $property['rooms']; ?>" />
        </label>
        <label for="field4">
        <span>Rent</span><input type="text" name="field4" value="<?php echo $property['rent_cost']; ?>"/>
        </label>
        <label for="field5">
        <span>Location</span><input type="text" name="field5" value="<?php echo $property['location']; ?>" />
        </label>
        <label for="field6">
        <span>Max No. Of Tenants</span><input type="text" name="field6" value="<?php echo $property['max_tanants']; ?>"/>
        </label>
        <label for="field7">
            <span>Description</span><textarea name="field7" rows="4" cols="60" ><?php echo $property['description']; ?></textarea>
        </label>

    </form>

 <div class="grid">
  <?php
    if (!$result_images || mysqli_num_rows($result_images) == 0) {
      echo "<p>No images found for this property.</p>";
    } else {
      while ($row = mysqli_fetch_assoc($result_images)) {
        $path = $row['path'];
        echo '<div class="item"><img src="' . $path . '" style="height: 300px; width: 400px;"></div>';
      }
    }
  ?>
</div>
    
    
        <div id="homeowner-info" style="text-align: center; margin-bottom: 5%; margin-top: 5%;">     
        <?php
          if ($_SESSION['role'] == 'homeseeker') {
            if ($result2 == false || mysqli_num_rows($result2) == 0) {
              echo "<p>No homeowner found with id $property_homeowne_id</p>";
            } else {
              echo "<h2>Homeowner Information</h2>";
              echo "<form class='form-style-4' action='' method='post' style='height:70%;>";
              echo "<label for='field1'><span style= 'display: inline-block; width: 200px;'>Name:</span><input type='text' name='field1' value='$homeowner_name'/></label>";
              echo "<label for='field2'><span>Email:</span><input type='text' name='field2' value='$phone_number'/></label>";
              echo "<label for='field3'><span>Phone:</span><input type='text' name='field3' value='$email_address'/></label>";
              echo "</form>";
            }
          }
        ?>
      </div>

   <div id="btn" style="margin-top: 5%;" >
    <?php 
        if ($_SESSION['role'] == 'homeseeker') {
            if (mysqli_num_rows($result3) == 0) //change the url
            {  echo '<button class="button-grow"><a href="HomeSeeker.php?property_id=' . $property_id . '">Apply</a></button>';}
        } else {
        echo '<button class="button-grow"><a href="editProperty.php?property_id=' . $property_id . '">Edit</a></button>';}
    ?>
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

</body>
</html>
