<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/database.php';


	function SQL_getUserName($user_id) {
		$r = libQuery("
			SELECT nickname
			FROM choice_account
			WHERE user_id = '$user_id'
		;");

		return $r[0]['nickname'] ?? '알 수 없음';
	}

?>