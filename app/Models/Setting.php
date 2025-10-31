<?php
declare(strict_types=1);

namespace App\Models;

use App\Database;

class Setting
{
	public static function get(string $key): ?string
	{
		$db = Database::getConnection();
		$stmt = $db->prepare('SELECT svalue FROM settings WHERE skey = ? LIMIT 1');
		$stmt->bind_param('s', $key);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res ? $res->fetch_assoc() : null;
		return $row ? (string)$row['svalue'] : null;
	}

	public static function set(string $key, ?string $value): void
	{
		$db = Database::getConnection();
		$stmt = $db->prepare('INSERT INTO settings(skey, svalue) VALUES(?, ?) ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)');
		$stmt->bind_param('ss', $key, $value);
		$stmt->execute();
	}
}
