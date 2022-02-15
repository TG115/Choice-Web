<?
$GLOBALS['ret_type'] = basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"]) ? 'ajax' : '';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/db_function.php';

if(!isset($_SESSION)) session_start();

function SQL_UploadThumb($idx) {
    if(count($_FILES) > 0) {
        $el = $_FILES['thumb'];
        $thumb = libFileUpload($el, 'item_image/file');

        if (strpos($thumb, '/') !== 0) return;

        $path = libQuery("
            SELECT thumb
            FROM hive_shop
            WHERE idx = ?
        ", 'i', array($idx))[0]['thumb'];
        
        if ($path) @unlink($_SERVER["DOCUMENT_ROOT"].$path);

        libQuery("
            UPDATE hive_shop
            SET thumb = ?
            WHERE idx = ?
        ", 'si', array($thumb, $idx));
    }
}

function SQL_UploadItem($el) {
    $idx = $el['idx'];
    $category = $el['i_category'];
    $name = $el['i_name'];
    $code = $el['i_code'];
    $amount = $el['i_amount'];
    $price = $el['i_price'];
    $sale = $el['i_sale'];
    $status = @$el['i_status']=='on'?1:0;
    if ($idx) {
        libQuery("
            UPDATE hive_shop
            SET category = ?, name = ?, code = ?, amount = ?, price = ?, sale = ?, status = ?, mdate = NOW()
            WHERE idx = ?
        ", 'sssiiiii', array($category, $name, $code, $amount, $price, $sale, $status, $idx));
    } else {
        libQuery("
            INSERT INTO hive_shop (category, name, code, amount, price, sale, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ;", 'sssiiii', array($category, $name, $code, $amount, $price, $sale, $status));

        $idx = libQuery("SELECT idx FROM hive_shop ORDER BY idx DESC LIMIT 1")[0]['idx'];
    }

    SQL_UploadThumb($idx);

    echo '<script>alert("저장 되었습니다."); location.href="/adm/shop/?cate=' . $category . '";</script>';
}

function SQL_DeleteItem($idx) {
    libQuery("
        UPDATE hive_shop
        SET dflag = TRUE, mdate = NOW()
        WHERE idx = ?
    ", 'i', array($idx));

    echo '<script>alert("삭제 되었습니다."); location.href="/adm/shop/?cate=' . $_GET['cate'] . '";</script>';
}

if ($_GET['ACT'] == 'D') {
    SQL_DeleteItem($_GET['idx']);
} else {
    SQL_UploadItem($_POST);
}

?>