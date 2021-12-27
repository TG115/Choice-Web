<?

    @header('Expires: Fri, 1 Jan 2021 12:00:00 GMT');
    @header('Cache-Control: no-store, no-cache, must-revalidate');
    @header('Pragma: no-cache');
    ini_set('memory_limit','-1');

    include_once($_SERVER['DOCUMENT_ROOT'].'/lib/config.php');

    function libReturn($state='', $arr=array()) {
        $res = array('state'=>$state, 'arr'=>$arr);
        
        if ($GLOBALS['ret_type'] == 'ajax') {
            echo json_encode($res);
            exit;
        } else {
            return $res;
        }
        
    }

    function libRefValues(&$arr) {
        if (strnatcmp(phpversion(),'5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    function libConnect() {
        global $mysqli;
        global $cfg;
        
        if (!$mysqli) {
            
            $mysqli = @mysqli_connect($cfg['DB']['Server'], $cfg['DB']['UserId'], $cfg['DB']['Password'], $cfg['DB']['DBName']) or include('err_db.php');
            @mysqli_set_charset($mysqli, 'utf8');
        }
        return $mysqli ;
    }

    function libQuery($sql, $types='', $params=array()) {
        $r = array();

        if ($types && count($params) > 0) {
            $stmt = @mysqli_prepare(libConnect(), $sql) or include('err_db.php');
            @call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt, $types), libRefValues($params))) or include('err_db.php');
            @mysqli_stmt_execute($stmt);

            // echo '<xmp>';
            // print_r($stmt);
            // echo '</xmp>';

            if (@$stmt->field_count) {
                $cols = array();
                $meta = mysqli_stmt_result_metadata($stmt);
                while ($col = $meta-> fetch_field()) $cols[$col->name] = '';

                @call_user_func_array('mysqli_stmt_bind_result', array_merge(array($stmt), libRefValues($cols)));

                $idx = 0;
                while (@mysqli_stmt_fetch($stmt)) {
                    foreach ($cols as $k => $v) $r[$idx][$k] = $v;
                    $idx++;
                }
            }
        } else {
            $res = @mysqli_query(libConnect(), $sql) or include('err_db.php');

            if (is_object($res)) while ($row = @mysqli_fetch_assoc($res)) {
                $r[] = $row;
            }
        }

        return $r;
    }

    function libFileUpload($el, $dir="") {
        
        if (!$el['name']) {
            $upfile = "";
        } else {
            $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "webp");
            // $name  = date('dhi').'_'.uniqid();
            $pathinfo = pathinfo($el['name']);
            $name = substr($el['name'], 0, strripos($el['name'], '.')).'_'.date('dhi');
            $ext   = strtolower($pathinfo['extension']);

            if(in_array($ext,$valid_formats)) {
                $root  = $_SERVER['DOCUMENT_ROOT'];
                if (substr($root, -1) == '/') {
                    $root = substr_replace($root, '', -1);
                }
        
                $path1 = $root.'/uploads';
                $path2 = $dir.date('/Y/m');
                if (!is_dir("{$path1}/{$path2}")) mkdir("{$path1}/{$path2}", 0777, true);
                move_uploaded_file( $el['tmp_name'], "{$path1}/{$path2}/{$name}.{$ext}" );
        
                $upfile = "/uploads/{$path2}/{$name}.{$ext}";
            } else {
                return "이미지 파일만 업로드 할 수 있습니다.\n(jpg, png, gif, bmp, jpeg, webp)";
            }
        }
    
        return $upfile;
    }

?>