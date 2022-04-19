
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
<? if (isset($_SESSION['hive_id'])) { echo "<script>location.href='/';</script>"; } ?>
  <title>FiveM Hive - 로그인</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>
<!-- Main content -->
<div class="container my-5" style="min-height:675px">
	<!-- Header -->
	<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
		<div class="container">
			<div class="header-body text-center mb-3">
			<div class="row justify-content-center py-3 text-white">
				<div class="col-xl-5 col-lg-6 col-md-8 px-5">
				<h1>FiveM Hive Server</h1>
				<p class="text-lead">Welcome Hive</p>
				</div>
			</div>
			</div>
		</div>
	</div>
    <!-- Page content -->
    <div class="container pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card shadow bg-secondary border-0 mb-3">
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" action="/lib/_login.php" method="post">
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control" name="hive_id" placeholder="아이디" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" name="hive_pw" placeholder="비밀번호" type="password" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-dark my-4 mr-4" onclick="location.href='/signup.php'">회원가입</button>
                  <button type="submit" class="btn btn-primary my-4">로그인</button>
                </div>
                <div class="text-center">
                  <a href="/findID.php" class="text-white-50">아이디 찾기</a> | <a href="/findPW.php" class="text-white-50">비밀번호 찾기</a> 
                </div>
              </form>
            </div>
          </div>
          <div class="card shadow bg-secondary border-0 mb-0">
          <iframe src="https://api.trackyserver.com/widget/tracky?id=1852535&lang_code=&map=0&version=1&votes=1&plist=1&connect=1&button_name=서버 접속&color1=212B34&color2=33404D&color3=33404D&color4=FFFFFF&color5=FFFFFF&color7=EDF4FF&color8=8a8e94&color9=fff&title=FiveM The Hive Server - 서버 접속 현황" height="350" allowtransparency="true" frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

  <? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>

</body>
</html>