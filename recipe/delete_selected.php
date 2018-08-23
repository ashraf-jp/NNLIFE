<?php
// include database and object file
include_once '../config/database.php';
include_once '../objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare category object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// delete the category
if($category->deleteSelected($data->ids)){
	// records were deleted
	echo "Successfully deleted.";
}

// if unable to delete the category
else{
	echo "Unable to delete records.";
}
?>
