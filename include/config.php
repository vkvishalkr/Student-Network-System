<?php

session_start();

class Db{

	private $db = "stunet";
	Private $user = "root";
	private $host = "localhost";
	private $pass = "";
	protected $con;

	public function __construct(){
		$this->con = new mysqli($this->host,$this->user,$this->pass,$this->db);
	}
}

class Datawork extends Db{

	public function __construct(){
		parent::__construct();
	}

	public function insertData($table,$fields){
		$query = $this->con->query("INSERT INTO $table $fields");

		return ($query)? true : false;
	}

	public function callingData($table,$cond=null){
		$array = array();

		if ($cond==null) {
			$query = "SELECT * FROM $table";
		}
		else{
			$query = "SELECT * FROM $table WHERE $cond";
		}

		$data = $this->con->query($query);

		while ($row = $data->fetch_array()){
			$array[] = $row;
		}
		
		return $array;
	}

	public function checkData($table,$cond=null){
         
        $query = "SELECT * FROM $table WHERE $cond";
		$data = $this->con->query($query);
		$row = $data->fetch_array();
		$count = $data->num_rows;

		if($count > 0):
			return true;
		else:
			return false;
		endif;
	}

	public function countData($table,$cond=null){
         
        $query = "SELECT * FROM $table WHERE $cond";
		$data = $this->con->query($query);
		$count = $data->num_rows;

		return $count;
	}

	public function redirect($page='index'){
		echo "<script>window.open('$page.php','_self')</script>";

	}

	public function deleteData($table,$cond){
		$query = $this->con->query("DELETE FROM $table WHERE $cond");
		return ($query)? true : false;
	}

	public function updateData($table,$fields,$cond){
		$query = $this->con->query("UPDATE $table SET $fields WHERE $cond");
		return ($query)? true : false;
	}

}

//object creation
$data = new Datawork();


?>