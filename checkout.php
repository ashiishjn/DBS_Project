<!DOCTYPE HTML>
<style>
	body{
    	background-image: linear-gradient(-225deg, #e3fdf5 0%, #ffe6fa 100%);
        background-image: linear-gradient(to top, #f7f7f7 50%, #bbbbbb 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
	}
	.text{
		text-align:center;
		font-size:24px;
	}

	form{
		background-color:white;
		width:25vw;
		border-radius:5px;
		padding:2rem;
		margin-top:20vh;
		border: solid 2px navy;
	}
</style>

<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="./bootstrap/css/jumbotron.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>
	<?php
     $quantity = $_POST['quantity'];
     $total_price = $_POST['total_price'];
     $cust_id= $_POST['cust_id'];
     $items = $_POST['items'];
	 $sql="CALL `amt_check`();";
	 foreach($_SESSION['cart'] as $isbn =>$qty){
			unset($_SESSION['cart']["$isbn"]);	
	}
     $conn = new mysqli("localhost","root","root","ethereal");
     if($conn->connect_error)
     {
       die('connection failed :' .$conn->connect_error);

     }
     else

     {
        echo'<center>';
		
		echo'<form action="checkout.php" method="POST">';
		echo'<h1>Billing Information';
        
		echo'<br/>';
		echo'<br/>';
       $stmt = $conn->prepare("insert into shopping_cart(quantity,total_price,cust_id,items)
       values(?, ?, ?, ?)");
	   if($total_price<1000)
	   {
	   echo'<p class="text">Amount to be paid:Rs. '.$total_price;
	   }
       $stmt->bind_param("ssss",$quantity,$total_price,$cust_id,$items);
       $stmt->execute();
	   $stmt = $conn->prepare($sql);
	   $stmt->execute();

	 
	   if($total_price>1000)
	   {
		echo'<p class="text">Old Amount: Rs. '.$total_price;
		echo'<br/>';
		echo'<p class="text" style="color:red;">20% discount applied';
		echo'<br/>';
		$discounted=$total_price*0.8;
		echo'<p class="text">Net Amount to be paid after available discount: Rs.'.$discounted;
		

	   }
    
	   echo'<br/>';
	   echo'<br/>';
echo'<input type="submit" value="Proceed to Pay" class="btn btn-success" name="proceed"/>';
echo'</form>';
echo'</center>';
	if(isset($_POST["proceed"]))
	{
	session_start();
    session_destroy();	
    header("Location:index.php");
	}
       $stmt->close();
       $conn->close();
    
     
    

     } 
?>
</body>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>