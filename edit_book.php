<?php	
	// if save change happen
	if(!isset($_POST['save_change'])){
		echo "Something wrong!";
		exit;
	}

	$isbn = trim($_POST['ISBN']);
	$title = trim($_POST['title']);
	$author = trim($_POST['name']);
	$des = trim($_POST['des']);
	$price = floatval(trim($_POST['price']));
	$publisher = trim($_POST['publisher']);
	$category = trim($_POST['category']);

	if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
		$image = $_FILES['image']['name'];
		$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "bootstrap/img/";
		$uploadDirectory .= $image;
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
	}

	require_once("./functions/database_functions.php");
	$conn = db_connect();

// find publisher and return pubid
		// if publisher is not in db, create new
		$findPub = "SELECT * FROM publisher WHERE pname = '$publisher'";
		$findResult = mysqli_query($conn, $findPub);
		if(mysqli_num_rows($findResult)==0){
			// insert into publisher table and return id
			$insertPub = "INSERT INTO publisher(publisher_name) VALUES ('$publisher')";
			$insertResult = mysqli_query($conn, $insertPub);
			if(!$insertResult){
				echo "Can't add new publisher " . mysqli_error($conn);
				exit;
			}
			$p_id = mysqli_insert_id($conn);
		} else {
			$row = mysqli_fetch_assoc($findResult);
			$p_id = $row['p_id'];
		}
// find category and return catid
		// if category is not in db, create new
		$findCat = "SELECT * FROM category WHERE c_name = '$category'";
		$findResult = mysqli_query($conn, $findCat);
		if(mysqli_num_rows($findResult)==0){
			// insert into category table and return id
			$insertCat = "INSERT INTO category(c_name) VALUES ('$category')";
			$insertResult = mysqli_query($conn, $insertCat);
			if(!$insertResult){
				echo "Can't add new category " . mysqli_error($conn);
				exit;
			}
			$c_id = mysqli_insert_id($conn);
		} else {
			$row = mysqli_fetch_assoc($findResult);
			$c_id = $row['c_id'];
		}


	$query = "UPDATE books SET  
	book_title = '$title', 
	author_id = '$author_id', 
	book_descr = '$des', 
	book_price = '$price',
	publisherid = '$p_id',
	categoryid = '$c_id'";
	if(isset($image)){
		$query .= ", book_img='$image' WHERE ISBN = '$ISBN'";
	} else {
		$query .= " WHERE ISBN = '$ISBN'";
	}
	// two cases for fie , if file submit is on => change a lot
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't update data " . mysqli_error($conn);
		exit;
	} else {
		header("Location: admin_edit.php?bookisbn=$isbn");
	}
?>