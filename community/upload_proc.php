<?
$root  = $_SERVER['DOCUMENT_ROOT'];
if (substr($root, -1) == '/') {
	$root = substr_replace($root, '', -1);
}

$path1 = $root.'/uploads';
$path2 = 'community'.date('/Y/m');

$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPEG", "JPG", "GIF");
$data = array(); 
$data['success'] = false;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
	$orgName = $_FILES['imageFile']['name'];
	
	if(strlen($orgName)) {   
		$name  = date('dhi').'_'.uniqid();
		$ext   = strtolower(substr($orgName, strripos($orgName, '.') + 1));

		if(in_array($ext,$valid_formats)) {
			$tmp = $_FILES['imageFile']['tmp_name'];

			if (!is_dir("{$path1}/{$path2}")) @mkdir("{$path1}/{$path2}", 0777, true);

			if(@move_uploaded_file($tmp, "{$path1}/{$path2}/{$name}.{$ext}")) {       
				$data['success'] = true;
				$data['url']  = "/uploads/{$path2}/{$name}.{$ext}";
			} else {	
				$data['success'] = false;
				$data['error'] = "이미지 업로드에 실패하였습니다. 다시 시도해주십시오.";
			}
		} else {
			$data['error'] = "이미지 파일만 업로드해주세요.";
		}
	} else {
		$data['error'] = "이미지를 선택해주세요.";
	}
}

echo json_encode($data);
?>
