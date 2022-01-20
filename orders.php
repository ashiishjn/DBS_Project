<?
session_start();

if($_SESSION["user"]==true){

}
else{
    header("Location: login.php");
}

$title = "Orders";
require_once "./header.php"; 
?>


<!DOCTYPE HTML>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>

body{
    background-image: linear-gradient(-225deg, #e3fdf5 0%, #ffe6fa 100%);
        background-image: linear-gradient(to top, #f7f7f7 50%, #bbbbbb 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        padding-top:7vh;
}

*{
    margin:0;
    padding:0;
}
      
.topnav {
  background-color: #e91010;
  overflow: hidden;
  margin-bottom: 1rem;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 14px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}



#car_img{
  width:60%;
}

#grid{
  display:grid;
  grid-template-columns: 1fr 1fr;
}

#card-grid{
  display:grid;
  grid-template-rows: 1fr ;
  border:solid 2px navy;
border-radius:5px;
margin:3rem;
padding-top:1.5rem;
background-color: white;
height:30vh;
width:35vw;
box-shadow: rgb(145, 145, 145)  4px 4px 2px;
padding:2rem;
}

.viewbtn{

    cursor: pointer;
    background: red;
    width:10vw;
    height:6vh;
    border: solid 0.2px white;
    color:white;
    border-radius: 5px;
    text-transform: capitalize;
    }

    .viewbtn:hover{
 
    cursor: pointer;
    background: rgb(253, 171, 171);
     color:black;
    }

    #car-logo{
        width:7%;
        
    }
 
</style>


<div style="text-align:center;">

    <h2>Your Orders:</h2>

<div id="grid">
  
<?php

$email=$_SESSION["user"];

$conn = mysqli_connect("localhost","root","root","ethereal");
//nested query
  $sql = "SELECT * FROM `shopping_cart` WHERE cust_id IN (SELECT cust_id FROM `customer` WHERE email='$email');";
  $result = $conn->query($sql);

{while ($row = $result->fetch_assoc()){

echo'<div id="card-grid">';
echo'<center>';
echo '<h4> Items in order: '.$row['items'];
echo '</br> ';
echo '</br> ';
echo '<h4> Total items in order: '.$row['quantity'];
echo '</br> ';
echo '</br> ';
echo '<h4> Total price: Rs.'.$row['total_price'];
echo '</br> ';
echo'</center>';
echo'</div>';



}
}
?>

</div>

</html>