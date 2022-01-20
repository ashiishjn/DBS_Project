<?
session_start();

if($_SESSION["user"]==true){

}
else{
    header("Location:login.php");
}
?>
<style>
#img-size{
  height:40vh;
  width: 15vw;
  }


</style>

<?php
  session_start();
  $count = 0;
  // connecto database
  
  $title = "Index";
  require_once "./header.php";
  require_once "./functions/database_functions.php";
  $conn = db_connect();
  $rown = select4LatestBook($conn);
?><br>
<div style="text-align:left; background-color:lightgreen; border-radius: 25px; padding:0.2rem; text-align:center;">
<?php 
$email=$_SESSION["user"];
$sql="SELECT name FROM `customer` WHERE email='$email'";
$result=$conn->query($sql);
{while($row=$result->fetch_assoc())
{
  echo'<h4>Welcome: '.$row['name'];
}
}
?>
</div>
<h3 class="lead text-center text-muted">OUR LATEST BOOKS</h3>
      
      <div class="row">
        <?php foreach($rown as $book) { ?>
      	<div class="col-md-3">
      		<a href="book.php?bookisbn=<?php echo $book['ISBN']; ?>">
           <img id="img-size" class="img-responsive img-thumbnail" src="<?php echo $book['book_img']; ?>">
          </a>
      	</div>
        <?php } ?>
      </div>
