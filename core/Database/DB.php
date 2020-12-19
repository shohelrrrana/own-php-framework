<?php

namespace Core\Database;

use PDO;
use PDOException;
use Exception;

class DB {
	/**
	 * Database connection
	 *
	 * @var PDO $connection
	 */
	protected static PDO $connection;

	/**
	 * Instance of the class
	 *
	 * @var $instance
	 */
	private static $instance = null;

	private static $query;
	private static $table;
	private static $select;
	private static $where;
	private static $orderby;
	private static $limit;
	private static $offset;

	private static $update;


	/**
	 * connect to database
	 *
	 * @return void
	 * @throws Exception
	 */
	private static function connect () {
		if ( defined( 'DB_USERNAME' ) ) {
			$dbname  = DB_NAME;
			$host    = HOST_NAME;
			$dsn     = "mysql:host={$host};dbname={$dbname}";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
				PDO::ATTR_PERSISTENT         => false,
			];

			try {
				$pdo              = new PDO( $dsn, DB_USERNAME, DB_PASSWORD, $options );
				self::$connection = $pdo;
			} catch ( PDOException $err ) {
				throw new Exception( $err->getMessage() );
			}
		}
	}

	/**
	 * Get instance of the class
	 *
	 * @return DB
	 */
	private static function instance () {
		self::connect();
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Setup query
	 *
	 * @param string|null $query
	 *
	 * @return DB|null
	 */
	public static function query ( string $query = null ) {
		self::instance();

		if ( ! static::$table ) {
			throw new Exception( "Unknown table" );
		}

		if ( $query === null ) {
			$query = 'SELECT ';
			$query .= self::$select ? self::$select : '*';
			$query .= 'FROM ';
			$query .= self::$table;
			$query .= self::$where;
			$query .= self::$orderby;
			$query .= self::$limit;
			$query .= self::$offset;
		}

		self::$query = $query;

		return self::instance();
	}

	/**
	 * Set table name
	 *
	 * @param string $table
	 *
	 * @return DB|null
	 */
	public static function table ( string $table ) {
		self::$table = $table . ' ';

		return self::instance();
	}

	/**
	 * Set select columns
	 *
	 * @param array $select
	 *
	 * @return DB|null
	 */
	public static function select ( array $select ) {
		$select       = implode( ', ', $select ) . ' ';
		self::$select = $select;

		return self::instance();
	}

	/**
	 * Set where condition
	 *
	 * @param string $column
	 * @param string $operator
	 * @param string $value
	 *
	 * @return DB
	 */
	public static function where ( string $column, string $operator, string $value ) {
		$where = "WHERE $column $operator $value ";

		self::$where = $where;

		return self::instance();
	}

	/**
	 * Set orderby
	 *
	 * @param string $column
	 * @param string $type
	 * @return DB|null
	 */
	public function orderby ( string $column, string $type = '' ) {
		$type          = strtoupper( $type );
		$type          = in_array( $type, [ 'ASC', [ 'DESC' ] ] ) ? $type : 'ASC';
		self::$orderby = "ORDER BY {$column} {$type} ";

		return self::instance();
	}

	/**
	 * Set Limit
	 *
	 * @param int $number
	 * @return DB|null
	 */
	public function limit ( int $number ) {
		self::$limit = "LIMIT $number ";

		return self::instance();
	}

	/**
	 * Set offset
	 *
	 * @param int $number
	 * @return DB|null
	 */
	public function offset ( int $number ) {
		self::$offset = "OFFSET {$number} ";

		return self::instance();
	}

	/**
	 * Fetch execute
	 *
	 * @return array | object
	 */
	private static function fetchExecute () {
		self::query( self::$query );
		$query = trim( self::$query );

		$data = self::$connection->query( $query );
		$data = $data->fetchAll();

		self::clear();

		return $data;

	}

	/**
	 * Return queried data
	 *
	 * @return array | object
	 */
	public static function get () {
		return self::fetchExecute();
	}

	/**
	 * Return single column
	 *
	 * @return object
	 */
	public static function first () {
		return self::fetchExecute()[0];
	}

	/**
	 * Update column
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public static function update ( array $data ) {
		$values = array_values( $data );
		$table  = self::$table;

		//Make placeholder
		$placeholders = '';
		foreach ( $data as $field => $value ) {
			$placeholders .= "{$field} = ?, ";
		}
		$placeholders = trim( $placeholders );
		$placeholders = trim( $placeholders, ',' );


		$query = "UPDATE {$table}SET {$placeholders} ";

		return self::execute( $query, $values );
	}

	/**
	 * Insert column
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function insert ( array $data ) {
		$fields = array_keys( $data );
		$fields = implode( ', ', $fields );
		$values = array_values( $data );
		$table  = self::$table;

		//Make placeholder
		$placeholders = '';
		foreach ( $data as $field => $value ) {
			$placeholders .= "?, ";
		}
		$placeholders = trim( $placeholders );
		$placeholders = trim( $placeholders, ',' );

		$query = "INSERT INTO {$table}({$fields}) VALUES ({$placeholders})";
		$query = trim( $query );

		return self::execute( $query, $values, false );
	}

	/**
	 * Delete column
	 *
	 * @return bool
	 */
	public function delete () {
		$table = self::$table;

		$query = "DELETE FROM {$table} ";

		return self::execute( $query, [] );
	}

	/**
	 * Execute query
	 *
	 * @param string $query
	 * @param array $data
	 * @param bool $isWhere
	 *
	 * @return bool|string
	 */
	private static function execute ( string $query, array $data, $isWhere = true ) {
		$execute = false;

		if ( $isWhere === true && self::$where ) {
			$query   .= self::$where;
			$stmt    = self::$connection->prepare( $query );
			$execute = $stmt->execute( $data );
		}
		if ( $isWhere === false ) {
			$stmt    = self::$connection->prepare( $query );
			$execute = $stmt->execute( $data );
		}

		self::clear();

		return $execute;
	}

	/**
	 * Clear all properties
	 */
	private
	static function clear () {
		self::$query   = '';
		self::$table   = '';
		self::$select  = '';
		self::$where   = '';
		self::$orderby = '';
		self::$limit   = '';
		self::$offset  = '';
	}


}