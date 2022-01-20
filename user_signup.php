<?php
	session_start();
	$title = "User Signup";
	require "./header.php";
	require "./functions/database_functions.php";
	$conn = db_connect();


		$name = trim($_POST['name']);
		$name = mysqli_real_escape_string($conn, $name);
		

		$email = trim($_POST['email']);
		$email = mysqli_real_escape_string($conn, $email);
		
		$password = trim($_POST['password']);
		$password = mysqli_real_escape_string($conn, $password);
		
		$address = trim(trim($_POST['address']));
		$address = mysqli_real_escape_string($conn, $address);
		
		$phone = trim($_POST['phone']);
        $phone = mysqli_real_escape_string($conn, $phone);
        

		if(empty($name) ||empty($email) || empty($password) || empty($address)||empty($phone)){
				header("Location:../onlinebookstore/signup.php?signup=empty");
		}else{
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				header("Location:../onlinebookstore/signup.php?signup=invalidemail");
			}else{
				$findUser = "SELECT * FROM customer WHERE email = '$email'";
				$findResult = mysqli_query($conn, $findUser);
				if(mysqli_num_rows($findResult)==0){
					$insertUser = "INSERT INTO customer(name,email,address,password,phone) VALUES 
					('$name','$email','$address','$password','$phone')";
					$insertResult = mysqli_query($conn, $insertUser);
					if(!$insertResult){
						echo "Can't add new user " . mysqli_error($conn);
						exit;
				}
				$userid = mysqli_insert_id($conn);
				header("Location: signin.php");
				} else {
					$row = mysqli_fetch_assoc($findResult);
					$userid = $row['cust_id'];
					header("Location: signin.php");
				}
			}
		}	
?>
	
<?php
	if(isset($conn)) {mysqli_close($conn);}
?>











