 <?php
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "root", "nuzl");

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the property ID from the query string
    $property_id = $_GET["property_id"];
    $sql = "SELECT p.*, c.category FROM property p JOIN propertycategory c ON p.property_category_id = c.id WHERE p.id = $property_id";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if (mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        echo "No property found.";
        exit;
    }
     
    $query_images = "SELECT * FROM PropertyImage WHERE property_id = $property_id";
    $result_images = mysqli_query($conn, $query_images);
    

    // Close the database connection
    mysqli_close($conn);

    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="edit.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img id="logo" src="images/Nuzl logo.png" alt="Nuzl logo" width="150" height="90" class="d-inline-block align-text-top"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
<main>
    <h1>Property Information</h1>
    
    <form class="form-style-4" action="update_property.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="property_id" value="<?php echo $property["id"]; ?>">
         <input type="hidden" name="category_id" value="<?php echo $property['property_category_id']; ?>">
        <label for="name">
            <span>Property Name</span>
            <input type="text" name="name" value="<?php echo $property["name"]; ?>" >
        </label><br/>
        <label for="category">
            <span>Category</span>
            <select name="category_id">
      <?php
        $conn = mysqli_connect("localhost", "root", "root", "nuzl");

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $query_categories = "SELECT * FROM PropertyCategory";
        $result_categories = mysqli_query($conn, $query_categories);
        
        while ($row = mysqli_fetch_assoc($result_categories)) {
          $category_id = $row["id"];
          $category_name = $row["category"];
          $selected = ($category_id == $property["property_category_id"]) ? "selected" : "";
          echo "<option value='$category_id' $selected>$category_name</option>";
        }

        mysqli_close($conn);
      ?>
    </select>
  </label>

       <br/> <label for="rooms">
            <span>Number Of Rooms</span>
            <input type="text" name="rooms" value="<?php echo $property["rooms"]; ?>">
        </label>
        <label for="rent_cost">
            <span>Rent</span>
            <input type="text" name="rent_cost" value="<?php echo $property["rent_cost"]; ?>">
        </label>
        <br>
        <label for="location">
            <span>Location</span>
            <input type="text" name="location" value="<?php echo $property["location"]; ?>">
        </label>
        <label for="max_tenants">
            <span>Max No. Of Tenants</span>
            <input type="text" name="max_tanants" value="<?php echo $property["max_tanants"]; ?>">
        </label>
        <label for="description">
            <span>Description</span><br>
            <textarea name="description" rows="4" cols="60"><?php echo $property["description"]; ?></textarea>
        </label>
        <h2>Property Images</h2>
        <p><a class="ui" href="">Upload images</a></p>
        

         <div class="images">
        <?php  
        if (!$result_images || mysqli_num_rows($result_images) == 0) {
          echo "<p>No images found for this property.</p>";
        } else {
          while ($row = mysqli_fetch_assoc($result_images)) {
            $image_id = $row['id'];
            $path = $row['path'];
        ?>
            <div class="item">
              <img src="<?php echo $path; ?>" alt="property image" style="height: 200px; width: 300px;">
              <a class="delete" href="delete_image.php?image_id=<?php echo $image_id; ?>" style="background-color: #192557;
               " onmouseover="this.style.backgroundColor='#ECD884'" onmouseout="this.style.backgroundColor=''">Delete</a>
            </div>
        <?php 
          }
        }
        ?>
      </div>
          
        <input type="file" name="images[]" multiple>
        <button id="saveBtn" type="submit">SAVE</button>
    </form>
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