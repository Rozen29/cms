<?php
declare(strict_types=1);

namespace App;

use mysqli;
use RuntimeException;

class Database
{
	private static ?mysqli $connection = null;

	public static function getConnection(): mysqli
	{
		if (self::$connection instanceof mysqli) {
			return self::$connection;
		}

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_errno) {
			throw new RuntimeException('Database connection failed: ' . $mysqli->connect_error);
		}
		$mysqli->set_charset(DB_CHARSET);
		self::$connection = $mysqli;
		return self::$connection;
	}
}
