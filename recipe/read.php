<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/recipe.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

// initialize object
$recipe = new Recipe($db);

// query categorys
$stmt = $recipe->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

	// products array
	$recipe_arr=array();
	$recipe_arr["recipes"]=array();

	// retrieve our table contents
	// fetch() is faster than fetchAll()
	// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// extract row
		// this will make $row['name'] to
		// just $name only
		extract($row);

		$recipe_item=array(
			"id" => $id,
			"title" => $title,
			"making_time" => $making_time,
			"serves" => $serves,
			"ingredients" => $ingredients,
			"cost" => $cost,
		);

		array_push($recipe_arr["recipes"], $recipe_item);
	}

	echo json_encode($recipe_arr);
}

else{
    echo json_encode(
		array("message" => "No recipes found.")
	);
}
?>
