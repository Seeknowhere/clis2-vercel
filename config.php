<?php
class config{
	private $server = "localhost";
	private $username = "root";
	private $pass = '';
	private $db = "clis_db";
	private $conn = null;

	public function __construct(){
		$this->conn = new mysqli($this->server, $this->username, $this->pass, $this->db);
		date_default_timezone_set('Asia/Manila');
    }

	public function getConnection(){
		return $this->conn;
    }
}

function root_url(){
	return 'http://localhost/clis/';
}

function document_url(){
	return $_SERVER['DOCUMENT_ROOT'].'/clis/';
}


?>
