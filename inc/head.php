<?php
    if(!isset($_SESSION)) session_start();

    if (!isset($_SESSION['user_id'])) {
		if(
            !strpos($_SERVER["SCRIPT_NAME"],"login.php") &&
            !strpos($_SERVER["SCRIPT_NAME"],"signup.php") &&
            !strpos($_SERVER["SCRIPT_NAME"],"findID.php") &&
            !strpos($_SERVER["SCRIPT_NAME"],"findPW.php") &&
            !strpos($_SERVER["SCRIPT_NAME"],"changePW.php")
            ) {
            header('Location: /login.php');
		}
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
	<link rel="shortcut icon" href="http://soojeong.kro.kr/HIVE.ico">

    <!-- Bootstrap core CSS -->
    <link href="/asset/vendor/bootstrap/css/bootstrap.min.css?ver=1.10" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/asset/css/modern-business.css" rel="stylesheet">

    <link rel="stylesheet" href="/asset/css/style.css?ver=1.10">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


	<title>FiveM Hive</title>
    <meta name="description" content="FiveM Hive Server Management System">
    
	<link href="https://unpkg.com/webkul-micron@1.1.6/dist/css/micron.min.css" type="text/css" rel="stylesheet">
    <script src="https://unpkg.com/webkul-micron@1.1.6/dist/script/micron.min.js" type="text/javascript"></script>
