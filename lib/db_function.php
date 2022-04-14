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

	function SQL_Get_bbs_like($idx) {
		$r = libQuery("
			SELECT COUNT(*) AS cnt
			FROM hive_bbs_likes
			WHERE idx = ?
		;", "i", array($idx));
	
		return $r[0]['cnt'];
	}

	function SQL_Get_bbs_comment($idx) {
		$r = libQuery("
			SELECT COUNT(*) AS cnt
			FROM hive_bbs_comment
			WHERE idx = ? AND dflag=0
		;", "i", array($idx));
	
		return $r[0]['cnt'];
	}


	function isAdminId($user_id) {
		$r = false;
		$row = libQuery("
			SELECT dvalue
			FROM vrp_user_data
			WHERE user_id = ? AND dkey = ?
		", 'is', array($user_id,'vRP:datatable'));

		if (isset($row[0])) {
			$dvalue = $row[0]['dvalue'];
			$data = json_decode($dvalue, true);
			$groups = $data['groups'];

			$adm = [
				'rorasujeong', 
				'namu1129',
				'superadmins',
				'normaladmins',
				'testadmins'
			];
			
			foreach($adm as $group) {
				if (array_key_exists($group, $groups)) {
					$r = true;
					break;
				}
			}
		}
    
    	return $r;
	}

?>