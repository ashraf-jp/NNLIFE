<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate recipe object
include_once '../objects/recipe.php';

$database = new Database();
$db = $database->getConnection();

$recipe = new Recipe($db);

$data = json_decode(file_get_contents("php://input"));


// make sure data is not empty
if(
	isset($data->title) &&
	isset($data->making_time) &&
	isset($data->serves	) &&
	isset($data->ingredients)&&
	isset($data->cost)
){

	// set product property values
	$recipe->title = $data->title;
	$recipe->making_time = $data->making_time;
	$recipe->serves = $data->serves;
	$recipe->ingredients = $data->ingredients;
	$recipe->cost = $data->cost;


	$response["message"]= "Recipe successfully created!";
	//$response["recipe"]= $product;
	$response["recipe"]=array(
			"title" => $data->title,
			"making_time" => $data->making_time,
			"serves" => $data->serves,
			"ingredients" => $data->ingredients,
			"cost" => $data->cost
		);

	if($recipe->create()){
		/*echo '{';
			echo '"message": "Category was created."';
		echo '}';*/
		echo json_encode($response);
	}

		// if unable to create the product, tell the user
	else{
		echo '{';
		echo '"message": "Unable to create recipe."'."\n";
		echo '"required": "title, making_time, serves, ingredients, cost"'."\n";
		echo '}';
	}
}
?>
