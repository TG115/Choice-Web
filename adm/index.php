<? include_once $_SERVER["DOCUMENT_ROOT"]."/adm/adm.proc.php" ?>

<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
	<title>FiveM Hive - 관리자페이지</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>

    <!-- Main content -->
<div class="container my-5">
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
        <div class="container">
            <div class="header-body mb-3">
            <div class="row py-3">
                <div class="col-xl-12 col-lg-12 col-md-12 px-5">
                <h1>관리자 페이지</h1>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow bg-secondary border-0 mb-0">
                    <div class="card-header bg-dark">
                        <h5 class="form-text fw-bold text-white">아이템 지급하기</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" action="adm.proc.php" method="post">
                        <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">지급할 고유번호</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="give_id" placeholder="고유번호를 입력하세요." type="tel">
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary my-4" onclick="giveItem('req=checkId&' + $(this.form).serialize());">닉네임 확인</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="itemname" class="form-text h6 fw-bold text-light">지급할 아이템</label>
								<select class="form-control" name="give_itemname" class="form-control" id="itemname">
                                    <option value="choice">--선택--</option>
                                    <option value="후원 박스">후원 박스</option>
                                    <option value="후원 박스 세트">후원 박스 세트</option>
                                    <option value="마일리지">마일리지</option>
								</select>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">직접 입력</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="give_itemname2" placeholder="idname" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">지급할 개수</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="give_amount" placeholder="지급 개수를 입력하세요." type="tel">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary my-4" onclick="giveItem('req=giveItem&' + $(this.form).serialize());">지급하기</button>
                            </div>
                            <div class="text-center">
                            <!-- <a href="#" class="text-white-50">아이디 찾기</a> | <a href="#" class="text-white-50">비밀번호 찾기</a>  -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>

    <script>
    function giveItem(data) {

        if (document.xhr) {
            alert('처리중입니다. 잠시만 기다려주세요.');
            return;
        } 

        document.xhr = $.ajax({
            url: '/adm/adm.proc.php',
            data: data,
            type:'post',
            dataType: "json",
            success:function(r){
                if (r.state == "success") {
                    alert(r.arr.nickname + "[" + r.arr.user_id + ']님께 ' + r.arr.itemname + ' ' + r.arr.amount + '개 지급 완료');
                    location.reload();
                } else if (r.state == "nickname") {
                    alert("[" + r.arr.user_id + ']님의 닉네임 : ' + r.arr.nickname);
                } else {
                    alert(r.state);
                }
            }, error:function(request, status, error){
                console.log(request, status, error);
            }, complete:function(){
                document.xhr = false;
            }
        });
    }
    </script>
</body>

</html>