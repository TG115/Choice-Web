
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
<? if (isset($_SESSION['Hive_id'])) { echo "<script>location.href='/';</script>"; } ?>
  <title>FiveM Hive - 아이디 찾기</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>
<!-- Main content -->
<div class="container my-5">
	<!-- Header -->
	<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
		<div class="container">
			<div class="header-body text-center mb-3">
			<div class="row justify-content-center py-3 text-white">
				<div class="col-xl-5 col-lg-6 col-md-8 px-5">
				<h1>FiveM Hive Server</h1>
				<p class="text-lead">아이디 찾기</p>
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
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" action="/lib/_findInfo.php" method="post">
                <input type="hidden" name="req" value="id">
                <div class="form-group mb-3">
                  <span class="form-text h6 fw-bold text-light">고유번호<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control" name="f_user_id" placeholder="고유번호" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <span class="form-text h6 fw-bold text-light">인증번호<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="f_logincode" placeholder="인증번호" type="text" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-dark my-4 mr-4" onclick="location.href='/signup.php'">회원가입</button>
                  <button type="submit" class="btn btn-primary my-4">아이디 찾기</button>
                </div>
                <div class="text-center">
                  <a href="/login.php" class="text-white-50">로그인</a> | <a href="/findPW.php" class="text-white-50">비밀번호 찾기</a> 
                </div>
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