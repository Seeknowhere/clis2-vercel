<?php
class config{
	private $server;
	private $username;
	private $pass;
	private $db;
	private $port;
	private $conn = null;

	public function __construct(){
		// Falls back to the old local XAMPP defaults when the env vars
		// aren't set, so this still works unchanged on localhost.
		$this->server = getenv('DB_HOST') ?: 'localhost';
		$this->username = getenv('DB_USER') ?: 'root';
		$this->pass = getenv('DB_PASS') ?: '';
		$this->db = getenv('DB_NAME') ?: 'clis_db';
		$this->port = getenv('DB_PORT') ?: 3306;

		$this->conn = new mysqli($this->server, $this->username, $this->pass, $this->db, $this->port);
		date_default_timezone_set('Asia/Manila');

		// This app was written against MySQL/MariaDB defaults that allow
		// GROUP BY queries to return an arbitrary row's value for columns
		// not in the GROUP BY clause or an aggregate function (several
		// queries across the codebase rely on this, including some using
		// SELECT *). Modern MySQL enables ONLY_FULL_GROUP_BY by default,
		// which rejects those queries outright. Relax it for this
		// connection instead of rewriting every affected query.
		$this->conn->query("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
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
