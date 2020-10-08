<?php
	header('Access-Control-Allow-Origin: *');

	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM todo";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$row["completed"] = (bool)$row["completed"];
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function getProduct($id=0)
	{
		global $conn;
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
		header('Content-Type: application/json');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function AddProduct()
	{
		global $conn;
		$title = $_POST["title"];
		$description = $_POST["description"];
		$completed = $_POST["completed"];
		$query="INSERT INTO todo(title, description, completed) VALUES('".$title."', '".$description."', '".$completed."')";
		mysqli_query($conn, $query);
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
		header('Content-Type: application/json');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function updateProduct($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$title = $_PUT["title"];
		$description = $_PUT["description"];
		$completed = $_PUT["completed"];
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
		header('Content-Type: application/json');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function deleteProduct($id)
	{
		global $conn;
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
		
		header('Content-Type: application/json');
		echo json_encode($response, JSON_NUMERIC_CHECK);
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