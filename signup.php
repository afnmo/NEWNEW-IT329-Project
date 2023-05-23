<?php
session_start();
define('DBHOST', 'localhost');
define('DBNAME', 'nuzl');
define('DBUSER', 'root');
define('DBPASS', 'root');



$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

$error = mysqli_connect_error();
if ($error != null) {
    $output = "<p>Unable to connect to the database</p>" . $error;
    exit($output);
} else {
//    echo "success connected to DB";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST["first_name"];
    $lastname = $_POST["last_name"];
    $age = $_POST["age"];
    $family_members = $_POST["family_members"];
    $income = $_POST["income"];
    $job = $_POST["job"];
    $phone_number = $_POST["phoneNo"];
    $email_address = $_POST["email"];
    $password = $_POST["password"];

    if (!isset($firstname) || !isset($lastname) || !isset($age) || !isset($family_members) || !isset($income) || !isset($job) || !isset($phone_number) || !isset($email_address) || !isset($password)) {

        echo "One of the fields is not set";
    }


    if (empty($firstname) || empty($lastname) || empty($age) || empty($family_members) || empty($income) || empty($job) || empty($phone_number) || empty($email_address) || empty($password)) {

        echo "One of the fields is empty";
    } else {
        $sql = "SELECT email_address FROM HomeSeeker WHERE email_address = '" . mysqli_real_escape_string($connection, $_POST["email"]) . "';";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) == 1) {
            header('Location: signup.php?error=email_already_exists');
            exit();
        } else {
            
//            add to database

            if ($stmt = mysqli_prepare($connection, "INSERT INTO HomeSeeker (first_name, last_name, age, "
                    . "family_members, income, job, phone_number, email_address, password) "
                    . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "ssiiissss", $firstname, $lastname, $age, $family_members, $income, $job, $phone_number, $email_address, $password);

                // Hash the password
                $password = password_hash($password, PASSWORD_DEFAULT);

                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    $id = mysqli_insert_id($connection);
                    $_SESSION['userID'] = $id;
                    header('Location: Homeseeker.php');
                    exit();
                } else {
                    header('Location: signup.php?failedInsertion');
                    exit();
                }
            } else {
                echo 'Could not prepare statement';
            }
        }
    }
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
        <link rel="stylesheet" href="base.css">
        <link rel="stylesheet" href="loginSignup.css">
        <script src="https://kit.fontawesome.com/5ccf46ed5e.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .wrapper{
                top: 93%;
            }
            .footer{
                top: 170%;
            }
        </style>
        <title>signUp</title>
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

            </div>
        </nav>



        <div class="wrapper">
            <div class="form-box login">
                <h2>Sign up</h2>
                <form action="signup.php" method="POST">
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="first_name" onclick="hideErrorMessage()" required>
                        <label>First Name</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="last_name" onclick="hideErrorMessage()" required>
                        <label>Last Name</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"></span>
                        <input type="number" name="age" min="1" max="100" onclick="hideErrorMessage()" required>
                        <label>Age</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-family-pants"></i></span>
                        <input type="number" name="family_members" min="1" max="20" onclick="hideErrorMessage()" required>
                        <label>Number of family members</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-money-bill"></i></span>
                        <input type="text" name="income" onclick="hideErrorMessage()" required>
                        <label>Income</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"></span>
                        <input type="text" name="job" onclick="hideErrorMessage()"  required>
                        <label>Job</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" name="phoneNo" onclick="hideErrorMessage()" required>
                        <label>Phone Number</label>
                    </div>

<?php if (isset($_GET['error'])) { ?>
                        <div id="error" class="alert alert-danger" role="alert">
                            Email address already exists,<br>
                            please try different email address.
                        </div>
<?php } ?>




                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" onclick="hideErrorMessage()" required>
                        <label>Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" onclick="hideErrorMessage()" required>
                        <label>Password</label>
                    </div>

                    
                    <div class="forgot">
                    <a href="login.php">Already has an account?</a>
                    </div>
                    <br>
                    <button type="submit" name="submit" id="login-submit">Sign up</button>


                </form>
            </div>
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
        <script>
            function hideErrorMessage(){
                setTimeout(() => { document.getElementById("error").style.display = "none";}, 5000);
            }
        
        </script>

    </body>

</html>