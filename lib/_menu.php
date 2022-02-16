<?
    $GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

    function SQL_myPoint($user_id) {
        $r = libQuery("
            SELECT point
            FROM hive_account
            WHERE user_id = ?
        ", 'i', array($user_id));

        return $r[0]['point'] ?? 0;
    }


?>