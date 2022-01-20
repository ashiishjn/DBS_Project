<!DOCTYPE HTML>
<html>

<style>

body{
  background-image: linear-gradient(-225deg, #e3fdf5 0%, #ffe6fa 100%);
    background-image: linear-gradient(to top, #f7f7f7 50%, #e2e0e0 100%);
}

#img-size{
  height:40vh;
  width: 15vw;
}

.btn{
  color:white;
  background-color:#706e6e;
}
</style>

<body>
<?php
  session_start();
  $count = 0;
  // connecto database
  require_once "./functions/database_functions.php";
  $conn = db_connect();
  if(isset($_POST['title']))
    {
      if(isset($_POST['order']))
      $ans=$_POST['order'];
        if($ans=="asc")
        {
        $query = "SELECT * FROM books order by title asc";
        }
        else if($ans=="desc"){
        $query = "SELECT * FROM books order by title desc";
        }
        else{
        $query = "SELECT * FROM books";
        }
    }
  else if(isset($_POST['price']))
    {
      if(isset($_POST['order']))
      $ans=$_POST['order'];
      if($ans=="asc")
      {
      $query = "SELECT * FROM books NATURAL JOIN author order by price asc";
      }
      else if($ans=="desc")
      {
      $query = "SELECT * FROM books NATURAL JOIN author order by price desc";
      }
      else{
      $query = "SELECT * FROM books NATURAL JOIN author";
      }
    }
  else if(isset($_POST['name']))
    {
      if(isset($_POST['order']))
      $ans=$_POST['order'];
      if($ans=="asc")
      {
      $query = "SELECT * FROM books NATURAL JOIN author order by author.name asc";
      }
      else if($ans=="desc")
      {
      $query = "SELECT * FROM books NATURAL JOIN author order by author.name desc";
      }
      else{
      $query = "SELECT * FROM books NATURAL JOIN author";
      }
    }
  else
    {
    $query = "SELECT * FROM books NATURAL JOIN author";
    }

  $result = mysqli_query($conn, $query);
  $title = "Full Catalogs of Books";
    require_once "./header.php";
?>
<br>
<br>
<br>
  <p class="lead text-center text-muted">Full Catalogs of Books</p>
<h5 class="lead text-muted">Sort By:</h5>
<form method="post" action="books.php">
  <div class="radio">
    <label><input type="radio" name="order" value="asc" >Ascending</label>
  </div>
  <div class="radio">
    <label><input type="radio" name="order" value="desc">Descending</label>
  </div>



  <button type="submit" class="btn btn-secondary"  name="title">Title</button>
  <button type="submit" class="btn btn-secondary" name="price">Price</button>
  <button type="submit" class="btn btn-secondary" name="name">Author</button>
  <button type="submit" class="btn btn-secondary" name="clear">Clear</button>
  
</form>

<br><br>

    <?php for($i = 0; $i < mysqli_num_rows($result)/2; $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="book.php?bookisbn=<?php echo $query_row['ISBN']; ?>">
              <img id="img-size" class="img-responsive img-thumbnail" src="<?php echo $query_row['book_img']; ?>">
              </a>
              <table>
                <tr>
                  <td><strong>  <?php echo $query_row['title']; ?></strong></td>
                </tr>
                <tr>
                <td> <?php echo $query_row['name']; ?></td>
                </tr>
                <tr>
                <td><strong>Rs.<?php echo $query_row['price'];?></strong>  </td>
                </tr>
              </table>
            </div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
      <br>
        </body>
<?php
      }
  if(isset($conn)) 
    { 
      mysqli_close($conn); 
    }

?>

 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </html>