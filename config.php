<?php
class config{
	private $server;
	private $username;
	private $pass;
	private $db;
	private $conn = null;

	public function __construct(){
		// Falls back to the old local XAMPP defaults when the env vars
		// aren't set, so this still works unchanged on localhost.
		$this->server = getenv('DB_HOST') ?: 'localhost';
		$this->username = getenv('DB_USER') ?: 'root';
		$this->pass = getenv('DB_PASS') ?: '';
		$this->db = getenv('DB_NAME') ?: 'clis_db';

		$this->conn = new mysqli($this->server, $this->username, $this->pass, $this->db);
		date_default_timezone_set('Asia/Manila');
    }

	public function getConnection(){
		return $this->conn;
    }
}

function root_url(){
	return '/';
}

function document_url(){
	return ROOT_PATH.'';
}


?>
