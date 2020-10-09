<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getProducts()
	{
		global $conn;
		header('Content-Type: application/json');
		$query = "SELECT * FROM todo";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function getProduct($id=0)
	{
		global $conn;
		header('Content-Type: application/json');
		$query = "SELECT * FROM todo";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		$response = array_reduce($response, function($c, $v){
			foreach ($v as $key => $val) $c[$key] = $val;
			return $c;
		    }, array());
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function AddProduct()
	{
		global $conn;
		header('Content-Type: application/json');
		$title = $_GET["title"];
		$description = $_GET["description"];
		$completed = $_GET["completed"];
		$query="INSERT INTO todo(title, description, completed) VALUES('".$title."', '".$description."', ".$completed.")";
		mysqli_query($conn, $query);
		echo($query);
		var_dump(mysqli_error($conn));
		$query = "SELECT * FROM todo WHERE title='".$title."' LIMIT 1";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		$response = array_reduce($response, function($c, $v){
			foreach ($v as $key => $val) $c[$key] = $val;
			return $c;
		    }, array());
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function updateProduct($id)
	{
		global $conn;
		header('Content-Type: application/json');
		$title = $_GET["title"];
		$description = $_GET["description"];
		$completed = $_GET["completed"];
		$query="UPDATE todo SET title='".$title."', description='".$description."', completed='".(int)$completed."' WHERE id=".$id;
		
		mysqli_query($conn, $query);
		$query = "SELECT * FROM todo";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		$response = array_reduce($response, function($c, $v){
			foreach ($v as $key => $val) $c[$key] = $val;
			return $c;
		    }, array());
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function deleteProduct($id)
	{
		global $conn;
		header('Content-Type: application/json');
		$query = "SELECT * FROM todo";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		$response = array_reduce($response, function($c, $v){
			foreach ($v as $key => $val) $c[$key] = $val;
			return $c;
		    }, array());
		$query = "DELETE FROM todo WHERE id=".$id;
		mysqli_query($conn, $query);
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}

	function isAValidName($name) {
		if (!preg_match('/[^A-Za-z0-9]/', $name)) {
			return true;
		} else {
			return false;
		}
	}
	
	switch($request_method)
	{	
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getProduct($id);
			}
			else
			{
				getProducts();
			}
			break;
			
		case 'POST':
			// Ajouter un produit
			AddProduct();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateProduct($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteProduct($id);
			break;

		case 'OPTIONS':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getProduct($id);
			}
			else
			{
				getProducts();
			}
			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

	}
?>