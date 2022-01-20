<!DOCTYPE HTML>
<html>

<style>

body{
  background-image: linear-gradient(-225deg, ##f7f7f7 0%, ##f7f7f7 100%);
    background-image: linear-gradient(to top, #f7f7f7 50%, #f7f7f7 100%);
}

.ul-category{
	font-size:25px;
	margin-left:29vw;
	margin-top:5vh;
}

.lead{
	text-align:center;
}
</style>
<body>
<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$query = "SELECT * FROM category ORDER BY cname";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	if(mysqli_num_rows($result) == 0){
		echo "Empty category ! Something wrong! check again";
		exit;
	}

	$title = "List Of Categories";
	require "./header.php";
?>
	<br>
	<br>
	<br>
	<p class="lead" style="font-size:30px">List of Category</p>
	<ul class="ul-category">
	<?php 
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT c_id FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($pubInBook = mysqli_fetch_assoc($result2)){
				if($pubInBook['c_id'] == $row['c_id']){
					$count++;
				}
			}
	?>
		<li>
			<span id="number-badge" class="badge"><?php echo $count; ?></span>
		    <a id="category-name" href="bookPerCat.php?c_id=<?php echo $row['c_id']; ?>"><?php echo $row['cname']; ?></a>
		</li>
	<?php } ?>
		<li>
			<a href="books.php">List full of books</a>
		</li>
	</ul>
</body>
<?php
	mysqli_close($conn);
?>
</html>