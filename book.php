<!DOCTYPE HTML>
<html>

<style>

body{
  background-image: linear-gradient(-225deg, ##f7f7f7 0%, ##f7f7f7 100%);
    background-image: linear-gradient(to top, #f7f7f7 50%, #f7f7f7 100%);
}

</style>

<body>
<?php
  session_start();
  $ISBN = $_GET['bookisbn'];
  // connect to database
  require_once "./functions/database_functions.php";
  $conn = db_connect();

  $query = "SELECT ISBN,year,price,name,des,title,book_img FROM books NATURAL JOIN author WHERE ISBN = '$ISBN'";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Can't retrieve data " . mysqli_error($conn);
    exit;
  }

  $row = mysqli_fetch_assoc($result);
  if(!$row){
    echo "Empty book";
    exit;
  }

  $title = $row['title'];
  require "./header.php";
?>
      <!-- Example row of columns -->
      <br>
      <br>
      <br>
      <p class="lead" style="margin: 25px 0"><a href="books.php">Books</a> > <?php echo $row['title']; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img class="img-responsive img-thumbnail" src="<?php echo $row['book_img']; ?>">
        </div>
        <div class="col-md-6">
          <h3>Book Description</h3>
          <p><?php echo $row['des']; ?></p>
          <h3>Book Details</h3>
          <table class="table">
          	<?php foreach($row as $key => $value){
              if($key == "des" || $key == "book_img" || $key == "p_id" || $key == "title"){
                continue;
              }
              switch($key){
                case "ISBN":
                  $key = "ISBN";
                  break;
                case "title":
                  $key = "Title";
                  break;
                case "name":
                  $key = "Author";
                  break;
                case "price":
                  $key = "Price";
                  break;
              }
            ?>
            <tr>
              <td><?php echo $key; ?></td>
              <td><?php echo $value; ?></td>
            </tr>
            <?php 
              } 
              if(isset($conn)) {mysqli_close($conn); }
            ?>
          </table>
          <form method="post" action="cart.php">
            <input type="hidden" name="bookisbn" value="<?php echo $ISBN;?>">
            
            <input type="submit" value="Add to cart" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>
    </body>
  </html>
