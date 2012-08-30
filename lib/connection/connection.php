<?php

	class Connection {
		protected $link;
		private $host, $username, $password, $db;
	
		public function __construct($host, $db, $username, $password) {
			$this -> host = $host;
			$this -> username = $username;
			$this -> password = $password;
			$this -> db = $db;
		}
	
		public function Open() {
	
			$this -> link = mysql_connect($this -> host, $this -> username, $this -> password);
			if ($this -> link == false)
				throw new Exception(mysql_error($this -> link));
	
			if (mysql_select_db($this -> db, $this -> link) == false)
				throw new Exception(mysql_error($this -> link));
		}
	
		public function getLink() {
			return $this -> link;
		}
	
		public function getStringConnection() {
			return "Server=$this->host; User=$this->username; DB=$this->db";
		}
	
		public function Close() {
			mysql_close($this -> link);
		}
	
	}
	
	class Command {
		private $connection;
		private $command;
		private $result;
	
		public function __construct($connection) {
			$this -> connection = $connection;
		}
	
		public function setCommand($command) {
			$this -> command = "$command";
		}
	
		public function ExecuteQuery() {
			$this -> result = mysql_query($this -> command, $this -> connection -> getLink());
			if ($this -> result == false)
				throw new Exception(mysql_error($this -> connection -> getLink()));
	
			return mysql_num_rows($this -> result);
		}
	
		public function NumRows() {
			return mysql_num_rows($this -> result);
		}
	
		public function ExecuteNoQuery() {
			$this -> result = mysql_query($this -> command, $this -> connection -> getLink());
			if ($this -> result == false)
				throw new Exception(mysql_error($this -> connection -> getLink()));
	
			return mysql_affected_rows($this -> connection -> getLink());
		}
	
		public function lastIDGenerate()
		{
			return mysql_insert_id($this -> conexion->getLink());
		}
		
		public function getResult() {
			return $this -> result;
		}
	
	}
	
	class Reader {
		private $result;
		private $row;
	
		public function __construct($result) {
			$this -> result = $result;
			$this -> row = null;
		}
	
		public function NextByPosition() {
			if ($this -> row = mysql_fetch_row($this -> result))
				return true;
	
			return false;
		}
	
		public function NextByName() {
			if ($this -> row = mysql_fetch_assoc($this -> result))
				return true;
	
			return false;
		}
	
		public function __get($column)
		{
			if(isset($this->row[$column]))
			{
				return $this->row[$column];
			}
		}
		
		public function __isset($column)
		{
			return isset($this->row[$column]);
		}

		public function __unset($column)
		{
			unset($this->row[$column]);
		}

		public function RowHeader() {
			$header = array();
	
			for ($i = 0; $i < mysql_num_fields($this -> result); $i++) {
				$meta = mysql_fetch_field($this -> result, $i);
				$header[$i] = $meta -> name;
			}
			return $header;
		}
	
		public function Row() {
			if ($this -> row != null)
				return $this -> row;
	
			return false;
		}	
	}
?>