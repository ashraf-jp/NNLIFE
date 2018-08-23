<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=all_categories_" . date('Y-m-d_H-i-s') . ".csv");
echo $category->export_CSV();
?>
