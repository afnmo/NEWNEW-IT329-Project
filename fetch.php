
<?php
 session_start(); 
 $ID_HS=$_SESSION['userID'];
     $con= mysqli_connect('localhost','root','root','nuzl');
        if (!isset($con)){
            die('please check your connection'.mysqli_error());
        }
 // echo "hi";
      
        
    if(isset($_GET['mylist'])){
        $filter = $_GET['mylist'];
        
         
           if($filter == 'all' ){
                
      $qeury="select p.id, p.name,c.category ,p.rent_cost,p.rooms,p.location from property p , rentalapplication r , propertycategory c where p.property_category_id=c.id and p.id not in (select r.property_id from rentalapplication r,property p where r.property_id=p.id) group by p.name,c.category ,p.rent_cost,p.rooms,p.location, p.id;";
               
           }
           else {
                $qeury = "select p.id, p.name,c.category ,p.rent_cost,p.rooms,p.location from property p , rentalapplication r , propertycategory c where p.property_category_id=c.id && c.category='$filter' &&p.id not in (select r.property_id from rentalapplication r,property p where r.property_id=p.id) group by p.name,c.category ,p.rent_cost,p.rooms,p.location, p.id;";
               
    }
     $result= mysqli_query($con, $qeury);
     
    $property_not_rent=array();
        while( $rrow=  mysqli_fetch_assoc($result) ) {
        $property_not_rent[]=$rrow;}
        //header('Content-Type: text/plain');
        print_r(json_encode( $property_not_rent)) ;
         header('Content-Type: text/plain');
          
            
    }
    mysqli_close($con);
      
?>
  
