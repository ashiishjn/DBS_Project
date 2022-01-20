<?php

	function total_price($shopping_cart){
		$price = 0.0;
		if(is_array($shopping_cart)){
		  	foreach($shopping_cart as $isbn => $qty){
		  		$bookprice = getbookprice($isbn);
		  		if($bookprice){
		  			$price += $bookprice * $qty;
		  		}
		  	}
		}
		return $price;
	}

	function total_items($shopping_cart){
		$items = 0;
		if(is_array($shopping_cart)){
			foreach($shopping_cart as $isbn => $qty){
				$items += $qty;
			}
		}
		return $items;
	}
?>