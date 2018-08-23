<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/recipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare category object
$recipe = new Recipe($db);

// set ID property of record to read
$recipe->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of category to be edited
$recipe->readOne();

// create array
$recipe_arr = array(
	"id" =>  $recipe->id,
	"title" => $recipe->title,
	"making_time" => $recipe->making_time,
	"serves" =>  $recipe->serves,
	"ingredients" => $recipe->ingredients,
	"cost" => $recipe->cost
);

// make it json format
print_r(json_encode($recipe_arr));
?>
