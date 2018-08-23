<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/recipe.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

$recipe = new Recipe($db);

// get id of category to be edited
$data = json_decode(file_get_contents("php://input"));
var_dump($data);

// set ID property of category to be edited
$recipe->id = $data->id;

// set product property values
$recipe->title = $data->title;
$recipe->making_time = $data->making_time;
$recipe->serves = $data->serves;
$recipe->ingredients = $data->ingredients;
$recipe->cost = $data->cost;

$response["message"]= "Recipe successfully updated!";
$response["recipe"]=array(
			"title" => $data->title,
			"making_time" => $data->making_time,
			"serves" => $data->serves,
			"ingredients" => $data->ingredients,
			"cost" => $data->cost

// execute the query
if($recipe->update()){
	/*echo '{';
		echo '"message": "recipe was updated."';
	echo '}';*/
	echo json_encode($response);
}

// if unable to update the category, tell the user
else{
	echo '{';
		echo '"message": "Unable to update recipe."';
	echo '}';
}
