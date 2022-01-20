<?php
if (count(get_included_files()) == 1) define ('__MAIN__', __FILE__);

include_once '../db_access/common.php';

/**
 * Description of DB_class
 *
 * @author Micha
 */
class DBclass 
{
	static private $db_connection;
	
	private $saved_result, $saved_prepare, $saved_values;
	
	protected function __construct($sql = null, $values = null) {
		if (func_num_args() == 1) { // query
			$this->saved_result = $this->querySetup($sql);
		} else { // prepared statement
			$this->saved_prepare = self::prepareSetup($sql, $values);
		}
	}
	
	public static function connected() {
		return self::$db_connection;
	}

	static function connect() {
		if (!self::connected()) {
			try {
				self::$db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=UTF8', DB_USERNAME, DB_PASSWORD);
				self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die('Connection failed: ' . $e->getMessage());
			}
		}
		return self::$db_connection;
	}
	
	public static function disconnect() {
		self::$db_connection = null;
	}
	

	protected function querySetup($sql) {
		self::connect();
		try {
			return self::$db_connection->query($sql);
		} catch (PDOException $e) {
			print_pre('Error: ' . $e->getMessage());
			die();
		}
	}
	
	public static function query($sql) {
		return new self($sql);
	}
	
	function one($flags = PDO::FETCH_ASSOC) {
		return $this->saved_result->fetch($flags);
	}
	
	function column($column_number = 0) {
		return $this->saved_result->fetchColumn($column_number);
	}
	
	function all($flags = PDO::FETCH_ASSOC) {
		return $this->saved_result->fetchAll($flags);
	}
	
	function get($number_of_rows = null, $flags = PDO::FETCH_ASSOC) {
		$return = array();
		while (($row = $this->saved_result->fetch($flags)) && ($number_of_rows !== null ? $number_of_rows-- : true)) {
			$return[] = $row;
		}
		return $return;
	}
	
	function lastInsertId() {
		return self::$db_connection->lastInsertId();
	}

	protected static function colonize($array) {
		$return = array();
		foreach ($array as $key => $value) {
			if ($key[0] != ':') {
				$return[':' . $key] = $value;
			} else {
				$return[$key] = $value;
			}
		}
		return $return;
	}

	protected function prepareSetup($sql, $values = array()) {
		self::connect();
		$this->saved_values = self::colonize($values);
		try {
			$prepared = self::$db_connection->prepare($sql);
			if (!$prepared) {
				die("can't prepare statement");
			}
			return $prepared;
		} catch (PDOException $e) {
			print_pre('Error: ' . $e->getMessage());
			die();
		}
	}
	
	static function prepare($sql, $values = array()) {
		return new self($sql, $values);
	}
	
	function bindParam($key, $value) {
		if ($key[0] != ':') {
			$key = ':' . $key;
		}
		$this->saved_values[$key] = $value;
		return $this;
	}
	
	function bindParams($values = null) {
		if ($values) {
			$values = self::colonize($values);
			$this->saved_values = $values + $this->saved_values;
		}
		return $this;
	}

	function execute($values = array()) {
		$values_to_use = func_num_args() ? self::colonize($values) : $this->saved_values;
		if ($this->saved_prepare->execute($values_to_use)) {
			$this->saved_result = $this->saved_prepare;
			return $this;
		}
	}

	static function columnNames($table) {
		self::connect();
		try {
			$query = self::$db_connection->query('DESCRIBE `' . self::escapeTable($table) . '`');
			return $query->fetchAll(PDO::FETCH_COLUMN);
		} catch (PDOException $e) {
			print_pre('Error: ' . $e->getMessage());
			die();
		}
	}
	
	static function getEnums($table, $column) {
		return self::getEnumsOrSet($table, $column);
	}
	
	static function getSet($table, $column) {
		return self::getEnumsOrSet($table, $column);
	}
	
	static function getEnumsOrSet($table, $column) {
		$result = self::query("SHOW COLUMNS FROM " . self::escapeTable($table) . " WHERE Field = '" . self::escapeColumn($column) . "'")->column(1);
		
		if (!$result) {	
			return false;
		}
		
		return self::parseList($result);
	}
	
	static function parseList($list) {
		$list = str_replace("''", "\n", $list); // replace escaped commas as something mysql never outputs
		$list = preg_replace("#^(enum\\('|set\\(')|'\\)$#", '', $list);
		$parts = explode("','", $list);

		$values = array();
		foreach ($parts as $i => $part) {
			$part = str_replace("\n", "'", $part); // convert newlines back to commas
			$part = preg_replace('#^\\\\r|([^\\\\])(\\\\\\\\)*(\\\\r)#', "$1$2\r", $part); // mysql return \r as \\r in SHOW COLUMNS
			$part = preg_replace('#^\\\\n|([^\\\\])(\\\\\\\\)*(\\\\n)#', "$1$2\n", $part); // mysql return \n as \\n in SHOW COLUMNS
			$part = preg_replace('#\\\\\\\\#', '\\', $part);
			$values[$i + 1] = $part; // internally enums and sets are stored 1 indexed or start by 1
		}
		return $values;
		
	}

	static function escapeTable($table) {
		return preg_replace('/[^a-z0-9_$]/i', '', $table);
	}
	
	static function escapeColumn($column) {
		return self::escapeTable($column);
	}
}


if (defined('__MAIN__') && __MAIN__ == __FILE__) {
	// run tests here
}