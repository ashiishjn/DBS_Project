<!DOCTYPE HTML>
<style>
	.table{
		margin-top:10vh;
		text-align:center;
	}

	.col{
		font-size:30px;
		padding:3rem;
	}

	.cartrow{
		font-size:20px;
	}

	

	button{
		margin-top:2rem;
		margin-left:23vw;
	}
	body{
    background-image: linear-gradient(-225deg, #e3fdf5 0%, #ffe6fa 100%);
        background-image: linear-gradient(to top, #f7f7f7 50%, #bbbbbb 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
	}

	i{
		cursor: pointer;
	}

	input{
		border:none;
		background-color:#f7f7f700;
		width:3vw;
		text-align:center;
	}

	#submit{
		width:10vw;
		margin-left:30vw;
	}

	i{
		margin-right:1rem;
	}
</style>
<body>
<?php

	session_start();
	require_once "./functions/database_functions.php";
	require_once "./functions/cart_functions.php";
	require_once "./header.php";
	
if($_SESSION["user"]==true){

}
else{
    header("Location:login.php");
}
	$conn = db_connect();
	// book_isbn got from form post method, change this place later.

		$bookisbn = $_POST['bookisbn'];
     
		
	if(isset($bookisbn)){
		// new iem selected
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] is associative array that bookisbn => qty
			$_SESSION['cart'] = array();

			$_SESSION['total_items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}

		if(!isset($_SESSION['cart'][$bookisbn])){
			$_SESSION['cart'][$bookisbn] = 1;
		} elseif(isset($_POST['cart'])){
			$_SESSION['cart'][$bookisbn]++;
			unset($_POST);
		}
	}

	
	
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['total_items'] = total_items($_SESSION['cart']);
		$final=0;
		$total_items=0;
		$item_names=' ';

		$cust_id;
		$email=$_SESSION["user"];
		$sql="SELECT cust_id FROM `customer` WHERE email='$email'";
		$result=$conn->query($sql);
		{while($row=$result->fetch_assoc())
		{
		  $cust_id=$row['cust_id'];
		}
		}
	
?>
<html>
<div id="mycart">
   	<form action="checkout.php" method="post">
	   	<table class="table">
			<thead>
				<tr>
					<th class="col">Item</th>
					<th class="col">Price</th>
					<th class="col">Quantity</th>
					<th class="col">Total</th>
				</tr>
			</thead>
	   		<?php
		    	foreach($_SESSION['cart'] as $isbn => $qty){
					$conn = db_connect();
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
					if($qty==0)
					{

					}
					else{

				    $total_items=$total_items+$qty;
					echo'<tr>';
					echo'<td class="cartrow">'.$book['title'];
				
					$item_names .= $book['title'];
					$item_names .= ",";
					echo'<td class="cartrow">Rs. '.$book['price'];
					echo'<td  class="cartrow"><i class="fa fa-plus" onclick="inc()" aria-hidden="true"></i>';
 					echo'<input type="text" value='.$qty.' id="quantity" readonly>';
					echo'<i class="fa fa-minus" onclick="dec()" aria-hidden="true"></i></td>';
					$total=$qty * $book['price'];
					$final=$final+$total;
					echo'<td class="cartrow">Rs. '.$total;
					echo'</tr>';
					}
				
			
				}

			
				
			?>
			</table>
			<div style="text-align:center;">
			<?php echo'<h2><i class="fa fa-shopping-cart"></i>: Rs. '.$final; ?>
			</div>
	<div>
		<?php
	      echo'<form action="checkout.php" method="post">';
		  echo'<input type="hidden" name="quantity" value='.$total_items.'>';
		  echo'<input type="hidden" name="total_price" value='.$final.'>';
		  echo'<input type="hidden" name="cust_id" value='.$cust_id.'>';
		  echo'<input type="hidden" name="items" value="'.$item_names.'">';
		  echo'<br/>';
		  echo'<input type="submit" id="submit" class="btn btn-primary" value="CHECKOUT" name="save_change">';
		  echo'</form>';
          


			?>
       
   
	  
			</div> 
	</form>
	<br/><br/>
	<div style="text-align:left;">
	
			</div>
			<br/>
	<a href="books.php"><h3><i class="fa fa-cart-plus"></i>Continue Shopping</h3></a>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</div>
</body>

<script>
	function inc(){
		var elem = parseInt(document.getElementById('quantity').value);
		document.getElementById('quantity').value=elem+1;
	
	}

	function dec(){
		var elem = parseInt(document.getElementById('quantity').value);
		document.getElementById('quantity').value=elem-1;
	
	}
</script>
	</html>