<?php
class Recipe{

	// database connection and table name
	private $conn;
	private $table_name = "recipe";

	// object properties
	public $id;
	public $title;
	public $making_time;
	public $serves;
	public $ingredients;
	public $cost;

	public function __construct($db){
		$this->conn = $db;
	}

	// delete selected categories
	public function deleteSelected($ids){

		$in_ids = str_repeat('?,', count($ids) - 1) . '?';

		// query to delete multiple records
		$query = "DELETE FROM " . $this->table_name . " WHERE id IN ({$in_ids})";

		$stmt = $this->conn->prepare($query);

		if($stmt->execute($ids)){
			return true;
		}else{
			return false;
		}
	}

	public function readOne(){
		// read the details of category to be edited
		// select single record query
		$query = "SELECT id, title, making_time,serves,ingredients,cost
				FROM " . $this->table_name . "
				WHERE id = ?
				LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind selected record id
		$stmt->bindParam(1, $this->id);

		// execute the query
		$stmt->execute();

		// get record details
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// assign values to object properties
		$this->title = $row['title'];
		$this->making_time = $row['making_time'];
		$this->serves = $row['serves'];
		$this->ingredients = $row['ingredients'];
		$this->cost = $row['cost'];
	}

	public function update(){

		// update the category
		$query = "UPDATE " . $this->table_name . "
				SET title = :title, making_time = :making_time,serves = :serves, ingredients = :ingredients,cost = :cost,
				WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->title=htmlspecialchars(strip_tags($this->title));
		$this->making_time=htmlspecialchars(strip_tags($this->making_time));
		$this->serves=htmlspecialchars(strip_tags($this->serves));
		$this->ingredients=htmlspecialchars(strip_tags($this->ingredients));
		$this->cost=htmlspecialchars(strip_tags($this->cost));
		
		// bind values
		$stmt->bindParam(":title", $this->title);
		$stmt->bindParam(":making_time", $this->making_time);
		$stmt->bindParam(":serves", $this->serves);
		$stmt->bindParam(":ingredients", $this->ingredients);
		$stmt->bindParam(":cost", $this->cost);
		// execute the query
		if($stmt->execute()){
			return true;
		}

		return false;
	}

	public function delete(){
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind record id
		$stmt->bindParam(1, $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}

		return false;
	}

	function create(){

		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					title=:title, making_time=:making_time, serves=:serves, ingredients=:ingredients, cost=:cost";
		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->title=htmlspecialchars(strip_tags($this->title));
		$this->making_time=htmlspecialchars(strip_tags($this->making_time));
		$this->serves=htmlspecialchars(strip_tags($this->serves));
		$this->ingredients=htmlspecialchars(strip_tags($this->ingredients));
		$this->cost=htmlspecialchars(strip_tags($this->cost));
		
		// bind values
		$stmt->bindParam(":title", $this->title);
		$stmt->bindParam(":making_time", $this->making_time);
		$stmt->bindParam(":serves", $this->serves);
		$stmt->bindParam(":ingredients", $this->ingredients);
		$stmt->bindParam(":cost", $this->cost);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			echo "<pre>";
				print_r($stmt->errorInfo());
			echo "</pre>";

			return false;
		}
	}

	// get search results with pagination
	public function searchPaging($search_term, $from_record_num, $records_per_page){

		// search category based on search term
		// search query
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				WHERE name LIKE ? OR description LIKE ?
				ORDER BY name ASC
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind  variables
		$query_search_term = "%{$search_term}%";

		$stmt->bindParam(1, $query_search_term);
		$stmt->bindParam(2, $query_search_term);
		$stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// count all categories
	public function count(){
		// query to count all data
		$query = "SELECT COUNT(*) as total_rows FROM recipe";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['total_rows'];

		return $total_rows;
	}

	// count all categories with search term
	public function countSearch($keywords){

		// search query
		$query = "SELECT COUNT(*) as total_rows FROM recipe WHERE title LIKE ? OR making_time LIKE ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind search term
		$keywords = "%{$keywords}%";
		$stmt->bindParam(1, $keywords);
		$stmt->bindParam(2, $keywords);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['total_rows'];

		return $total_rows;
	}

	// read all with paging
	public function readPaging($from_record_num, $records_per_page){
		// read all categories from the database
		$query = "SELECT id, title, making_time,serves,ingredients,cost
				FROM " . $this->table_name . "
				ORDER BY id DESC
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// used by select drop-down list
	public function read(){

		//select all data
		$query = "SELECT
					id, title, making_time,serves,ingredients,cost
				FROM
					" . $this->table_name . "
				ORDER BY
					id";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}

	// search without pagination
	public function searchAll_WithoutPagination($keywords){
		//select all data
		$query = "SELECT
					id, title, making_time,serves,ingredients,cost
				FROM
					" . $this->table_name . "
				WHERE
					name LIKE ? OR title LIKE ?
				ORDER BY
					name";

		$stmt = $this->conn->prepare( $query );

		// sanitize
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";

		// bind
		$stmt->bindParam(1, $keywords);
		$stmt->bindParam(2, $keywords);

		$stmt->execute();

		return $stmt;
	}

	// used to read category name by its ID
	function readNameById(){

		$query = "SELECT title FROM " . $this->table_name . " WHERE id = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->name = $row['title'];
	}
}
?>
