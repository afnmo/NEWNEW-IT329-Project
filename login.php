<!DOCTYPE html>

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
    echo "success connected to DB";
}

// check the role 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

//    failed - email or password not set at all
    if (!isset($_POST["email"]) || !isset($_POST["pass"])) {
        echo "Not set at all => not exist";
    } else {

//        failed - email or password set and empty
        if (empty($_POST["email"]) || empty($_POST["pass"])) {
            echo "<h1>Set and empty</h1><br>";
        }

//        successed + email and passowrd are set and non empty
        else {
            echo "Set and not empty<br>";
            echo '$_POST["email"]: ' . $_POST["email"] . ' <br>';
            echo '$_POST["pass"]: ' . $_POST["pass"] . '<br>';

            $userInputEmail = $_POST["email"];
            $userInputPassword = $_POST["pass"];

//            checking the role
//            successed + the dropdown is set (exist)
            if (isset($_POST["seeker-owner"])) {
//                echo '$_POST["seeker-owner"]: ' . $_POST["seeker-owner"] . '<br>';
                //echo gettype($_POST["seeker-owner"]);

                $userRole = $_POST["seeker-owner"];

//                check the credentials existence 
//                whether it is owner or seeker !
                $sql = "SELECT * FROM " . $userRole . " WHERE email_address = ?";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "s", $userInputEmail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);

//              successed + found in database
                if (mysqli_num_rows($result) > 0) {
                    // there are results in $result
                    echo "The " . $userInputEmail . " is exists in " . $userRole . " table<br>";
                    $row = mysqli_fetch_assoc($result);

                    // check if the password matches
                    $hash = $row['password'];

                      if(password_verify($userInputPassword, $hash)){
                        // the password matches
                        echo "Login successful<br>";

//                      Set session variables:
                        $sql = "SELECT id FROM " . $userRole . " WHERE email_address = ?";
                        $stmt = mysqli_prepare($connection, $sql);
                        mysqli_stmt_bind_param($stmt, "s", $userInputEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);

                        $userID = $row['id'];
                        $_SESSION['userID'] = $userID;
                        $_SESSION['role'] = $userRole;
                        
                        if($userRole == "HomeSeeker"){
                            header("Location: HomeSeeker.html");
                            exit();
                        }
                        else{
                            header("Location: Homeowner.html");
                            exit();
                        }
                    } else {
                        // the password does not match
                        header('Location: login.php?error=no_match');
                        exit();
                    }
                }
//              failed - to find in database
                else {
                    // no results
                    echo "Not exist in the database<br>";
                }

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
    <title>Log In</title>
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
        </div>
    </nav>

    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" onclick="hideErrorMessage()" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="pass" onclick="hideErrorMessage()" required>
                    <label>Password</label>
                </div>

                <div class="input-box">
                    <p>Select your role:
                        <select name="seeker-owner" id="my-dropdown">
                            <option value="HomeSeeker">Home Seeker</option>
                            <option value="Homeowner">Home Owner</option>
                        </select>
                    </p>
                </div>

                <?php 
                if (isset($_GET['error'])) { 
                ?>
                <div id="error" class="alert alert-danger" role="alert">
                    Invalid email address or password
                </div>
                <?php } 
                ?>

                <div class="forgot">
                    <a href="#">Forgot Password?</a>
                </div>
                
<!--                <input type="hidden" name="token" value="">-->
                <button type="submit" name="submit" id="login-submit" onclick="redirectOnLogin(); return false;" >Login</button>
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