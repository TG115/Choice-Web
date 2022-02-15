<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/database.php';

	function SQL_pointLog($user_id, $category, $text, $point) {
		$r = libQuery("
			SELECT point
			FROM hive_account
			WHERE user_id = ?
		;", "i", array($user_id));

		$remain_point = $r[0]['point'] + $point;

		libQuery("
			INSERT INTO hive_point_log
			VALUES (?, ?, ?, ?, ?, NOW())
		;", "issii", array($user_id, $category, $text, $point, $remain_point));
	}

	function SQL_setUserPoint($user_id, $point) {
		libQuery("
			UPDATE hive_account
			SET point = point + ?
			WHERE user_id = ?
		;", 'ii', array($point, $user_id));
	}

	function SQL_give_items($take_id, $itemname, $amount, $option) {
		
        libQuery("
            INSERT INTO hive_giveitem (give_id, take_id, idname, amount, flag, send_date)
            VALUES (?, ?, ?, ?, ?, NOW())
        ;", "iisis", array($_SESSION['user_id'] ?? $take_id, $take_id, $itemname, $amount, $option));
    }

	function SQL_getUserName($user_id) {
		$r = libQuery("
			SELECT nickname
			FROM hive_account
			WHERE user_id = '$user_id'
		;");

		return $r[0]['nickname'] ?? '알 수 없음';
	}

?>