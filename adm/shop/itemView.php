<? include_once $_SERVER["DOCUMENT_ROOT"]."/lib/_admin.php" ?>
<? if (!in_array($_GET['cate'], ['총기','차량','물약','잡화','이벤트'])) { ?> <script>alert('존재하지 않는 페이지입니다.'); location.href='/';</script><?}?>
<?
$idx = $_GET['idx'] ?? '';
if ($idx) {
    $r = include $_SERVER["DOCUMENT_ROOT"].'/lib/_shopItemView.php'; 
    $r = $r[0];
}
?>

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
                    <h1><?=$_GET['cate']?> 아이템 <?=$idx?'수정':'등록'?></h1>
                    <p class="text-lead">상점 아이템 정보를 <?=$idx?'수정':'등록'?> 할 수 있습니다.</p>
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
                        <h5 class="form-text fw-bold text-white"><?=$_GET['cate']?> 아이템 <?=$idx?'수정':'등록'?>하기</h5>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" action="/lib/_shopItem.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idx" value="<?=$idx??''?>">
                            <input type="hidden" name="i_category" value="<?=$_GET['cate']?>">
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">판매 설정</span>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitches" name="i_status" <?=$idx?($r['status']?'checked':''):'checked'?>>
                                    <label class="custom-control-label" for="customSwitches">
                                        판매 상태 설정
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="itemname" class="form-text h6 fw-bold text-light">카테고리</label>
								<select class="form-control" name="i_category" class="form-control" id="itemname">
                                    <option value="Hive">--선택--</option>
                                    <option value="총기" <//$idx&&$r['category']=="총기"?'selected':''?>>총기</option>
                                    <option value="차량" <//$idx&&$r['category']=="차량"?'selected':''?>>차량</option>
                                    <option value="물약" <//$idx&&$r['category']=="물약"?'selected':''?>>물약</option>
                                    <option value="잡화" <//$idx&&$r['category']=="잡화"?'selected':''?>>잡화</option>
                                    <option value="이벤트" <//$idx&&$r['category']=="이벤트"?'selected':''?>>이벤트</option>
								</select>
                            </div> -->
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">아이템 이름</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_name" placeholder="유저에게 보여질 아이템 이름을 입력하세요. (7자 이하 권장)" type="text" value='<?=$idx?$r['name']:''?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">아이템 코드</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_code" placeholder="게임 내 아이템 코드를 입력하세요." type="text" value='<?=$idx?$r['code']:''?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">한줄 설명</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_content" placeholder="아이템에 대한 한줄 설명을 입력하세요." type="text" value='<?=$idx?$r['content']:''?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">개수</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_amount" placeholder="판매 묶음당 개수를 입력하세요." type="number" value='<?=$idx?$r['amount']:''?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">가격</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_price" placeholder="한 묶음당 가격을 입력하세요." type="tel" onchange="changeSale()" value='<?=$idx?$r['price']:''?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">할인율 (%)</span>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="i_sale" placeholder="할인율을 입력하세요." type="number" onchange="changeSale()" value='<?=$idx?$r['sale']:''?>'>
                                </div>
                                <div class="form-text text-white-50 mini-info">할인율 적용 시 가격 : <span style="color:red" id="tot_price"><?=$idx&&$r['price']?$r['price']*(100-$r['sale'])/100:0?></span></div>
                            </div>
                            <div class="form-group">
                                <span class="form-text h6 fw-bold text-light">이미지</span>
                                
                                <table class="table table-dark table-striped table-hover align-items-center table-flush mg-table dual-table">
                                    <tr>
                                        <td width="120" class="text-center font-weight-bold">미리보기</td>
                                        <td id="td-thumb">
                                        <? if ($idx&&$r['thumb']) { ?>
                                            <div class="box-file">
                                                <a href="<?=$r['thumb']?>" target="_blank">
                                                    <img src="<?=$r['thumb']?>" alt="" style="width:40%">
                                                </a>
                                            </div>
                                        <? } else { ?>
                                            설정 된 이미지가 없습니다.
                                        <? } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="120" class="text-center font-weight-bold">업로드</td>
                                        <td>
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="thumb" id="bg_file" accept="image/*" style="padding:3px">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-center">
                            <?if ($idx) { ?><input type="button" class="btn btn-danger m-4" onclick="deleteItem(<?=$idx?>,'<?=$_GET['cate']?>')" value="삭제하기"><? } ?>
                                <input type="submit" class="btn btn-primary m-4" value="저장하기" />
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
            url: '/lib/_admin.php',
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

    function changeSale() {
        const price = $('input[name="i_price"]').val();
        const per = $('input[name="i_sale"]').val();
        $('#tot_price').html(price * (100 - per) / 100);
    }

    function deleteItem(idx, cate) {
        if(confirm('정말 삭제 하시겠습니까?')) 
            location.href=`/lib/_shopItem.php?ACT=D&idx=${idx}&cate=${cate}`;
    }
    </script>
</body>

</html>