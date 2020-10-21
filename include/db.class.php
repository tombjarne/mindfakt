<?php
	$date = new DateTime();
	$GLOBALS['timezone'] = $date->getTimezone()->getName();
	date_default_timezone_set($GLOBALS['timezone']);
	//error_reporting(E_ALL ^ E_WARNING);
	require_once("settings.php");

	class db {
		private $connection;
		protected $query;
		public $queryCount = 0;
		public $connectError = false, $insertError = false, $nextIndexError = false, $selectError = false;
		
		public function __construct() {
			$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
			if (!$this->connection->connect_error) $this->connection->query("SET NAMES 'utf8'");
			else $this->connectError = true;
		}
		
		public function showTable($tableName, $debug = false) {
			$query = "SHOW TABLES LIKE '".$tableName."'";
			
			if (!$debug) {
				$result = $this->connection->query($query);
				if (!$result) return false;
				else return true;
			}
			else print $query;
		}
		
		public function excInsert($dbName, $table, $data, $type, $debug = false) {
			//$index = $this->getIndex($dbName, $table, "id_".$table);
			
			if ($this->nextIndexError == false) {
				if ($type == "quiz") $query = "INSERT INTO `".$dbName."`.`".$table."` VALUES($data[0], '".$data[1]."', '".$data[2]."', $data[3])";
				elseif ($type == "userquiz") $query = "INSERT INTO `".$dbName."`.`".$table."` VALUES($data[0], $data[1], '".$data[2]."', '".$data[3]."', $data[4])";

				if (!$debug) {
					$result = $this->connection->query($query);
					if (!$result) $this->insertError = true;
				}
				else print $query;
			}
		}
		
		public function excSelect($dbName, $table, $fields, $where = false, $order = false, $limit = false, $debug = false) {
			$query = "SELECT $fields FROM `$dbName`.`$table`";
			if ($where) $query .= " WHERE $where";
			if ($order) $query .= " ORDER BY $order";
			if ($limit) $query .= " LIMIT $limit";
			
			if(!$debug) {
				$result = $this->connection->query($query);
				if (!$result) {
					$this->selectError = true;
				}
				else {
					if ($result->num_rows === 0) {
						return 0;
					}
					else if ($result->num_rows === 1) {
						return $result->fetch_assoc();
					}
					else {
						while ($row = $result->fetch_assoc()) {
							$rows[] = $row;
						}
						return $rows;
					}
				}
			}
			else print $query;
		}
		
		public function getIndex($dbName, $table, $field, $debug = false) {
			$query = "SELECT MAX(`".$field."`) AS nextIndex FROM `".$dbName."`.`".$table."`";
			
			if (!$debug) {
				$result = $this->connection->query($query);
				if (!$result) $this->nextIndexError = true;
				else {
					$result = $result->fetch_assoc();
					return $result['nextIndex']+1;
				}
			}
			else print $query;
		}
		
		public function escapeString($string) {
			return preg_replace('~[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]~u', '\\\$0', $string);
		}
	}
?>