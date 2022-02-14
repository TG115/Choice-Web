<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/database.php';
	$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';

    if(!isset($_SESSION)) session_start();

    function SQL_UploadThumb() {
        if(count($_FILES) > 0) {
			$el = $_FILES['thumb'];
			$thumb = libFileUpload($el, 'phone_bg/file');

            if (strpos($thumb, '/') !== 0) libReturn($thumb);

            $path = libQuery("
                SELECT phone_bg
                FROM hive_account
                WHERE user_id = ?
            ", 'i', array($_SESSION['user_id']))[0]['phone_bg'];
            
            if ($path) @unlink($_SERVER["DOCUMENT_ROOT"].$path);

			libQuery("
                UPDATE hive_account
                SET phone_bg = ?
                WHERE user_id = ?
            ", 'si', array($thumb, $_SESSION['user_id']));

			libReturn('OK');
		}
    }

    function SQL_ResetThumb() {
        $path = libQuery("
            SELECT phone_bg
            FROM hive_account
            WHERE user_id = ?
        ", 'i', array($_SESSION['user_id']))[0]['phone_bg'];
        if ($path) @unlink($_SERVER["DOCUMENT_ROOT"].$path);

        libQuery("
            UPDATE hive_account
            SET phone_bg = ''
            WHERE user_id = ?
        ", 'i', array($_SESSION['user_id']));

        libReturn('Deleted');
    }

    $ACT = @$_POST['ACT'];
    if ($ACT == 'D') {
        SQL_ResetThumb();
    } else {
        SQL_UploadThumb();
    }
?>