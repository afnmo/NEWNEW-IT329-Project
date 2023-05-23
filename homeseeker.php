<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'HomeSeeker') 
{ 

header('Location: homepage.html');
exit(); 

}
//database connection 

        $con= mysqli_connect('localhost','root','root','nuzl');
        if (!isset($con)){
            die('please check your connection'.mysqli_error());
        }

?>
<!DOCTYPE html>

<html>
    
    
   
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> HomeSeeker page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="base.css"> 
    <link rel="stylesheet" href="HS.css">
    <script src="HS.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
     
        
</head>

<body>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img id="logo" src="Images/Nuzl Logo.png" alt="Nuzl logo" width="150"
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
                        <a class="nav-link link-danger" href="logout.php">Log Out</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav> 
    
        <?php
                
        
        
//line 70-77 may use varible from session that make it in afnan
        $ID_HS=$_SESSION['userID'];
           
        $q="select * from homeseeker where id='$ID_HS' " ;
       
       
        $result= mysqli_query($con, $q);//to excuted the query 
        
         $row1= mysqli_fetch_assoc($result);//process 
           
        if ($row1!=null ) { 
$id=$row1['id'];
           ?> 
    
                <div id="head">
                    <h1 id="h1_ho"> Hello  <?php echo $row1['first_name'] ." " . $row1['last_name'] ; ?></h1></div>

    <div id="info">
        <p id="p1"> Name of the seeker: <?php echo $row1 ['first_name']; ?> </p>
        <p id="p4"> Number of family members:  <?php echo $row1 ['family_members']; ?> </p>
        <p id="p2"> Email:  <?php  echo $row1 ['email_address']; ?> </p>
        <p id="p3"> Phone number:  <?php echo $row1 ['phone_number']; ?> </p>
    </div>

        
          <?php
          
        }
      else{
           echo "you are not availbile to be a home seeker !";
            
      }
        
         
        
//done first step 
        ?>
                    
            
  <main>
      
      
     

        <h2> Requested Homes</h2>
                        <?php
     
     $recors ="select p.name,c.category,p.rent_cost,s.status from rentalapplication r, property p ,propertycategory c,applicationstatus s where r.property_id=p.id and r.application_status_id=s.id and  p.property_category_id=c.id and r.home_seeker_id= '$ID_HS' ";
     
      $result2= mysqli_query($con, $recors);   
                ?>
        
        <table id="RH">

            <thead>
                <tr>
                    <th> Property name </th>
                    <th> Category </th>
                    <th> Rent </th>
                    <th> Status </th>
                </tr>
            </thead>

            <tbody>

                       <?php 
                $property = array();         
           while (  $row2 =  mysqli_fetch_assoc($result2)  )
            {
            $property[] = $row2;
            
            }
            if (!empty($property)){
                foreach ($property as $pro){
                    $name_pro=$pro['name'];
                    $id_pro="select * from property where name= '$name_pro' ";
                    $re= mysqli_query($con, $id_pro);
                    $r =  mysqli_fetch_assoc($re);
                    
                    
      ?>
                <tr>
                    <td class="p"> <a href="propertyDetails.php?property_id=<?php echo $r['id']?>" > <p class="property">  <?php  echo $name_pro; ?> </p> </a> </td>
                            
                        <td>
                            <?php echo $pro['category']; ?>
                        </td>
                    <td class="r"> <?php echo $pro['rent_cost']; ?> </td>
                    <td> <?php echo $pro['status']; ?> </td>


                </tr>
            <?php }}?>
           
            </tbody>

        </table>
            <?php} ?>

      <!-- done second step -->  
        

        <br> <br>
        
        <h2> Homes For Rent </h2>
        <h3>Search By Category</h3>
        
       <div class="filter">
           <form method='post'>  
            <select id="mylist"  name='search' class='form-control' >
                 <option  value="All">All </option> 
                <?php 
                $q4='select c.category from propertycategory c  where c.id  in (select p.property_category_id                                                       from property p,propertycategory c                                                           where p.property_category_id=c.id and p.id not in(select r.property_id                                                                                               from rentalapplication r,property p                                                                               where r.property_id=p.id) ) ';
                      
                $rerr = mysqli_query($con, $q4);

while ($row4 = mysqli_fetch_array($rerr)){

                ?>
               
                <option value="<?php echo $row4['category']; ?>" > <?php echo $row4['category']; ?></option>
   
<?php } ?>
            </select>
               <button type='submit' style="color: white">Search </button>
           </form>
       </div>

        
                        
        <table id="myTable">
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
        
   
        
        
        
     
     <?php 
   
     
     
      if($_SERVER['REQUEST_METHOD'] == "POST") {
     //if (isset($_POST['search'])){
                        $category=$_POST['search'];
     
     if($category!='All' ){
         
          $qeury="select p.name,c.category ,p.rent_cost,p.rooms,p.location from property p , rentalapplication r , propertycategory c where p.property_category_id=c.id && c.category='$category'&&p.id not in (select r.property_id from rentalapplication r,property p where r.property_id=p.id) group by p.name,c.category ,p.rent_cost,p.rooms,p.location;";
         $f_r= mysqli_query($con, $qeury);
    
        while( $rrow=  mysqli_fetch_assoc($f_r) ) {
          $property_not_rent[]=$rrow;
        
        } 

         if(!empty($property_not_rent)) {  
                foreach ( $property_not_rent as $prop){
                    $name_prop=$prop['name'];
                    $c_prop=$prop['category'];
                    $rent_prop=$prop['rent_cost'];
                    $rooms_prop=$prop['rooms'];
                    $loc_prop=$prop['location'];
                
                    $ip="select * from property where name= '$name_prop' ";
                    $rer= mysqli_query($con, $ip);
                    $rr = mysqli_fetch_assoc($rer);
                    $id_prop=$rr['id'];
                    $count=1000;
                    $id_rent=$count++;
                  
               
                   
                    
            
      ?>
                
                
                
                
                <tr>
                    <td> <a href="propertyDetails.php?property_id=<?php echo $id_prop ?>"> <p class="property">   <?php echo $name_prop; ?>      </p>     </a></td>
                            
                    <td> <?php echo  $c_prop;?></td>
                    <td> <?php echo  $rent_prop;?> </td>
                    <td> <?php echo $rooms_prop ;?> </td>
                    <td> <?php echo $loc_prop ;?></td>
                   <td>
                      <a href="apply.php?id1=<?php $id_rent; ?>&id2=<?php echo $id_prop?>&id3=<?php echo $ID_HS?>" >Apply</a>
                  </td> 
                       
            
                </tr>
     <?php }} //for each?>
     
         
        </tbody>
        </table>
        
        
      <?php }
      else{
          
          
       
       $property_not_rent=array();
                      
                         
               
               
          $qeury="select p.name,c.category ,p.rent_cost,p.rooms,p.location from property p , rentalapplication r , propertycategory c where p.property_category_id=c.id and p.id not in (select r.property_id from rentalapplication r,property p where r.property_id=p.id) group by p.name,c.category ,p.rent_cost,p.rooms,p.location;";
         $f_r= mysqli_query($con, $qeury);
    
        while( $rrow=  mysqli_fetch_assoc($f_r) ) {
          $property_not_rent[]=$rrow;
        
        } 

         if(!empty($property_not_rent)) {  
                foreach ( $property_not_rent as $prop){
                    $name_prop=$prop['name'];
                   $c_prop=$prop['category'];
                    $rent_prop=$prop['rent_cost'];
                    $rooms_prop=$prop['rooms'];
                    $loc_prop=$prop['location'];
                
                    $ip="select * from property where name= '$name_prop' ";
                    $rer= mysqli_query($con, $ip);
                $rr =  mysqli_fetch_assoc($rer);
                    $id_prop=$rr['id'];
                $id_rent=$count++;
                 
                   
                    
            
      ?>
                
                
                
                
                <tr>
                    <td> <a href="propertyDetails.php?property_id=<?php echo $id_prop ?>"> <p class="property">   <?php echo $name_prop; ?>      </p>     </a></td>
                            
                            <td> <?php echo  $c_prop;?></td>
                    <td> <?php echo  $rent_prop;?> </td>
                    <td> <?php echo $rooms_prop ;?> </td>
                    <td> <?php echo $loc_prop ;?></td>
                    
                      <td>
                      <a href="apply.php?id1=<?php $id_rent; ?>&id2=<?php echo $id_prop?>&id3=<?php echo $ID_HS?>" >Apply</a>
                  </td> 
                    
                    
    
                </tr>
         <?php }} //for each?>
     
        </tbody>
        </table>
        
        
           
          
          
          
          
          
         <?php 
          
      }}
        //no search all result :        
     else {
        
     
       $property_not_rent=array();
                      
                         
               
               
          $qeury="select p.name,c.category ,p.rent_cost,p.rooms,p.location from property p , rentalapplication r , propertycategory c where p.property_category_id=c.id and p.id not in (select r.property_id from rentalapplication r,property p where r.property_id=p.id) group by p.name,c.category ,p.rent_cost,p.rooms,p.location;";
         $f_r= mysqli_query($con, $qeury);
    
        while( $rrow=  mysqli_fetch_assoc($f_r) ) {
          $property_not_rent[]=$rrow;
        
        } 

         if(!empty($property_not_rent)) {  
                foreach ( $property_not_rent as $prop){
                    $name_prop=$prop['name'];
                   $c_prop=$prop['category'];
                    $rent_prop=$prop['rent_cost'];
                    $rooms_prop=$prop['rooms'];
                    $loc_prop=$prop['location'];
                
                    $ip="select * from property where name= '$name_prop' ";
                    $rer= mysqli_query($con, $ip);
                $rr =  mysqli_fetch_assoc($rer);
                $id_prop=$rr['id'];
              
                   // echo $rr;
                    //add property in databse:
                  
                     
                    
            
      ?>
                
                
                
                
                <tr>
                    <td> <a href="propertyDetails.php?property_id=<?php echo $id_prop ?>" > <p class="property">   <?php echo $name_prop; ?>      </p>     </a></td>
                            
                    <td> <?php echo  $c_prop;?></td>
                    <td> <?php echo  $rent_prop;?> </td>
                    <td> <?php echo $rooms_prop ;?> </td>
                    <td> <?php echo $loc_prop ;?></td>
                    
                    
                  <td>
                      <a href="apply.php?id1=<?php $id_rent; ?>&id2=<?php echo $id_prop?>&id3=<?php echo $ID_HS?>" >Apply</a>
                  </td> 
                    
         
                </tr>
         <?php
         }} //for each?>
     
        </tbody>
        </table>

     
      <?php } 
                 

             
    
      ?> 
        

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
             
                    <?php
    mysqli_close($con);?>

 </body>

</html>