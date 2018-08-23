<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/recipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare category object
$recipe = new Recipe($db);

// get category id
$data = json_decode(file_get_contents("php://input"));

// set category id to be deleted
$recipe->id = $data->id;

// delete the category
if($recipe->delete()){
	echo '{';
		echo '"message": "Recipe successfully removed!"';
	echo '}';
}

// if unable to delete the category
else{
	echo '{';
		echo '"message": "No Recipe found"';
	echo '}';
}
?>
