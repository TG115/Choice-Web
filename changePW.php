<?
if (!isset($_SESSION)) session_start();
$c_uid = $_SESSION['changeinfo']['uid'];
$c_user_id = $_SESSION['changeinfo']['user_id'];
if (!isset($_SESSION['changeinfo'])) {
    echo '<script>alert("잘못 된 접근입니다."); location.href="/";</script>';
}
?>

<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
<? if (isset($_SESSION['hive_id'])) { echo "<script>location.href='/';</script>"; } ?>
	<title>FiveM Hive - 비밀번호 변경</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>

    <!-- Main content -->
<div class="container my-5">
<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
		<div class="container">
			<div class="header-body text-center mb-3">
			<div class="row justify-content-center py-3 text-white">
				<div class="col-xl-5 col-lg-6 col-md-8 px-5">
				<h1>FiveM Hive Server</h1>
				<p class="text-lead">비밀번호 변경하기</p>
				</div>
			</div>
			</div>
		</div>
	</div>
    <!-- Page content -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow bg-secondary border-0 mb-0">
                    <div class="card-header bg-dark">
                        <h5 class="form-text fw-bold text-white">비밀번호 변경하기</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" action="/lib/_findInfo.php" method="post">
                            <input type="hidden" name="c_user_id" value="<?=$c_user_id?>">
                            <div class="form-group mb-5">
                                <span class="form-text h6 fw-bold text-light">변경할 ID</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" type="text" disabled value="<?=$c_uid?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">변경할 비밀번호<span class="text-danger">*</span></span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="hive_pw" placeholder="비밀번호를 입력하세요." type="password" required>
                                </div>
                                <div class="form-text text-white-50 mini-info">비밀번호는 8자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.</div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">변경할 비밀번호 확인<span class="text-danger">*</span></span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="hive_pw2" placeholder="비밀번호를 한번 더 입력하세요" type="password" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary my-4" onclick="changePW2('req=changePW&' + $(this.form).serialize());">변경하기</button>
                            </div>
                            <!-- <div class="text-center">
                                <a href="/signup" class="text-white-50">회원가입</a>  |  <a href="/login" class="text-white-50">로그인</a>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>

</body>

</html>