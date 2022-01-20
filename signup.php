<?php
	$title = "User SignUp";
	require_once "./header.php";
?>
    <br>
    <br>
    <br>
	<form class="form-horizontal" method="post" action="user_signup.php">
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="name" name="name">
    </div>
    <div class="form-group">

        <label for="inputEmail4">Email</label>
        <input type="text" class="form-control" id="inputEmail4" placeholder="Email" name="email">
        </div>
        <div class="form-group">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="password">
    </div>
    <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
    </div>
    <div class="form-group col-md-12">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<div style="position:fixed; bottom:120px">

<?php
    $fullurl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(strpos($fullurl,"signup=empty")==true){
        echo '<P style="color:red">You did not fill in all the fields.</P>';
        exit();
    }
    if(strpos($fullurl,"signup=invalidemail")==true){
        echo '<P style="color:red">You did not enter a valid email address.</P>';
        exit();
    }
?>
</div>
