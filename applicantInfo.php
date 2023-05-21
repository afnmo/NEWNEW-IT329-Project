<?php
// Connect to database
$connection = mysqli_connect("localhost", "root", "root", "nuzl");
$error = mysqli_connect_error();

if ($error != null) {
    echo "<p>Could not connect to the database.</p>";
} else {
    // Get home seeker's information from database based on id in query string
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM homeseeker WHERE id = $id";
        $result = mysqli_query($connection, $sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $age = $row['age'];
            $family_members = $row['family_members'];
            $income = $row['income'];
            $job = $row['job'];
            $phone_number = $row['phone_number'];
            $email_address = $row['email_address'];
        } else {
            echo "No home seeker found with id = $id";
            exit();
        }
    } else {
        echo "No id provided";
        exit();
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="applicantInfo.css">
    <title>Applicant's Information</title>
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
                    <a class="nav-link" href="#Home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#prop">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Account">Account</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link link-danger" href="homepage.html">Log Out</a>
                </li>

            </ul>

        </div>
    </div>
</nav> 
 
<div class="applicant-caption"><h1> Applicant Information </h1></div>

<form class="form-Applicant" action="" method="post">
        <label for="AppName">
        <span>Applicant Name</span><input type="text" id="AppName" value="<?php echo $first_name . ' ' . $last_name; ?>"/>
        </label>
        <label for="phone">
            <span>Phone number</span><input type="text" id="phone" value="<?php echo $phone_number; ?>" />
        </label>
        <label for="FamilyNo">
        <span> Number of family members </span><input type="text" id="FamilyNo" value="<?php echo $family_members; ?>" />
        </label>
        
        <label for="email">
        <span>Email</span><input type="text" id="email" value="<?php echo $email_address; ?>" />
        </label>
        <label for="age">
        <span>Age</span><input type="text" id="age" value="<?php echo $age; ?>"/>
        </label>
       <label for="job">
        <span>Job</span> <input type="text" id="job" value="<?php echo $job; ?>" /> 
        </label>
    <label for="income">
        <span>Income per month</span> <input type="text" id="income" value="<?php echo $income; ?>" /> 
        </label>
    
</form> 

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

