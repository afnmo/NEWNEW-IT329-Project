<?php
     

session_start();

//database connection 

        $con= mysqli_connect('localhost','root','root','nuzl');
        if (!isset($con)){
            die('please check your connection'.mysqli_error());
        }
//$ID_HS=$_SESSION['userID'];
     
                 
         //  if(isset($_GET['id2'])){
              
               $id1=$_SESSION['userID'];
               $id2=$_GET['id2'];
               
             //   $id3=$_GET['id3'];
                $id4=333;
                     $add="INSERT INTO rentalapplication ( property_id, home_seeker_id, application_status_id)"
                             . " VALUES ($id2, $id1, $id4 )";
                  

              if (mysqli_query($con, $add)) {
  echo "New record created successfully";
 header('Location: homeseeker.php');
 die();
} else {
  echo "Error: " . $add . "<br>" . mysqli_error($con);
   header('Location: homeseeker.php');
 die();
}      
         
             
    
      
        

