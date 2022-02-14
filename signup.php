<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
	<title>FiveM Hive - 회원가입</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>
<div class="container my-5">
    <!-- Header -->
	<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
		<div class="container">
			<div class="header-body text-center mb-3">
			<div class="row justify-content-center py-3 text-white">
				<div class="col-xl-5 col-lg-6 col-md-8 px-5">
				<h1>FiveM Hive Server</h1>
				<p class="h4">회원가입</p>
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
              <form role="form" action="/lib/_signup.php" method="post">
                <div class="form-group mb-3">
                  <span class="form-text h6 fw-bold text-light">아이디<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control" name="hive_id" placeholder="아이디를 입력하세요." type="text" required>
                  </div>
                </div>
                <div class="form-group">
                <span class="form-text h6 fw-bold text-light">비밀번호<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="hive_pw" placeholder="비밀번호를 입력하세요." type="password" required>
                  </div>
                  <div class="form-text text-white-50 mini-info">비밀번호는 8자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.</div>
                </div>
                <div class="form-group">
                <span class="form-text h6 fw-bold text-light">비밀번호 확인<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="hive_pw2" placeholder="비밀번호를 한번 더 입력하세요" type="password" required>
                  </div>
                </div>
                <div class="form-group">
                <span class="form-text h6 fw-bold text-light">고유번호<span class="text-danger">*</span></span>
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="hive_user_id" type="tel" placeholder="고유번호를 입력하세요." required>
                  </div>
                </div>
                <div class="form-group">
                <span class="form-text h6 fw-bold text-light">인증번호<span class="text-danger">*</span></span>
                    <div id="frm_code">
                    <button type="button" class="btn btn-success" onclick="setting_code($('input[name=hive_user_id]').val())">인증번호 받기</button>
                    </div>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-primary my-4 w-100" onclick="signup('req=signup&' + $(this.form).serialize());">회원가입</button>
                </div>
                <div class="text-center">
                    <div class="form-text text-white-50 mini-info">이미 가입 된 계정이 있다면?</div>
                    <button type="button" class="btn btn-dark my-2 w-100" onclick="location.href='/login.php';">로그인</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>

</body>

</html>