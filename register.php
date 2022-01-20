<?php
require_once "config.php";

$email = $password = $confirm_password = "";
$address = $name = $phone ="";
$a = "";
$email_err = $password_err = $confirm_password_err = "";
$err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST")
{

    // Check if email is empty
    if(empty(trim($_POST["email"])))
    {
      echo '<script>alert("Email cannot be blank")</script>';
        $email_err = "email cannot be blank";
    }
    else
    {
        $sql = "SELECT user_id FROM Customer WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set the value of param email
            $param_email = trim($_POST['email']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                  echo '<script>alert("This email is already taken")</script>';
                  $email_err = "This email is already taken"; 
                }
                else
                {
                    $email = trim($_POST['email']);
                }
            }
            else
            {
              echo '<script>alert("Something went wrong")</script>';
            }
        }
        mysqli_stmt_close($stmt); 
    }

    
//Check for name
if(empty(trim($_POST['password'])))
{
  $err = "X";
    echo '<script>alert("Name cannot be blank")</script>';
}

// Check for password
if(empty(trim($_POST['password'])))
{
    $password_err = "Password cannot be blank";
    echo '<script>alert("Password cannot be blank")</script>';
}
elseif(strlen(trim($_POST['password'])) < 4)
{
    $password_err = "Password cannot be less than 8 characters";
    echo '<script>alert("Password cannot be less than 4 characters")</script>';
}
else
{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password']))
{
    $password_err = "Passwords should match";
    echo '<script>alert("Passwords should match")</script>';
}

//Check for length of mobile number
if(strlen(trim($_POST['phone'])) != 10)
{
  $err = "X";
    echo '<script>alert("Mobile Number should be of 10 digits")</script>';
}



//Check for address
if(empty(trim($_POST['address'])))
{
  $err = "X";
    echo '<script>alert("Address cannot be blank")</script>';
}


$a=$_POST["address"];
$address = $a.", ";

// If there were no errors, go ahead and insert into the database
if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($err))
{
    $sql = "INSERT INTO Customer (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_password,  $param_phone, $param_address);

        // Set these parameters
        $param_email = $_POST["email"];
        $param_password =  $_POST["password"];
        $param_name = $_POST["name"];
        $param_address=$_POST["address"];
        $param_phone = $_POST["phone"];

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
echo '<script>alert("Successfully Registered")</script>';
mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>ETHEREAL</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"  style="background-color: #00004d;" >
  <a class="navbar-brand" href="#">Ethereal Book Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>

      
     
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Please Register Here:</h3>
<hr>
<form action="" method="post">
  <div class="form-group">
    
    <label>Name</label>
    <input type="text" class="form-control" name="name"  placeholder="Name">
  
  </div>
  <div class="form-group">
    
      <label>Email</label>
      <input type="text" class="form-control" name="email" placeholder="Email">
    
  </div>
  <div class="form-group">
    
      <label>Password</label>
      <input type="password" class="form-control" name ="password" placeholder="Password(atleast 4 characters)">
    
  </div>
  <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" class="form-control" name ="confirm_password"  placeholder="Confirm Password">
    </div>
  <div class="form-group">
    <label>Address</label>
    <input type="text" class="form-control" name ="address" placeholder="Apartment, studio, or floor">
  </div>
  
  <div class="form-group">
    
      <label for="Phone_number">Phone Number</label>
      <input type="Phone" class="form-control" name ="phone"  placeholder="Phone">
    
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
</div>
  </body>
</html>
