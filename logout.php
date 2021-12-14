<?
	session_start();
	session_destroy();
	
	print "<script> alert('로그아웃되었습니다.'); location.replace('/login.php'); </script>";
?>
