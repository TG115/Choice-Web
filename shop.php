<? include_once $_SERVER["DOCUMENT_ROOT"]."/lib/_admin.php" ?>


<?
$r = include $_SERVER["DOCUMENT_ROOT"].'/lib/_shopItems.php'; 

	$r_max_row 	= $r['arr']['max_row'];
	$r_page 	= $r['arr']['page'];
	$r_prev 	= $r['arr']['prev'];
	$r_next 	= $r['arr']['next'];
	$r_tot_cnt 	= $r['arr']['tot_cnt'];
	$r_list 	= $r['arr']['list'];

	$cur_page = $_GET['page'] ?? 1;
    if ($r_tot_cnt < $cur_page) $cur_page = $r_tot_cnt;
    $startPage = (($cur_page - 1) / 10) * 10 + 1 - 5;
    if($startPage <= 0) $startPage = 1;
    $endPage = $startPage + 10 - 1;
    if ($endPage > $r_tot_cnt) $endPage = $r_tot_cnt;


	if ($r_prev) {
		$r_page > 2 ?
			$prevUrl = "?page=".$r_prev : 
			$prevUrl = "";
}
?>

<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
	<title>포인트 상점</title>
</head>

<body>

<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>

<div class="container my-5" style="max-width:1300px">
    <ul class="nav nav-tabs mb-5">
        <li class="nav-item">
            <a class="nav-link <?=$_GET['cate']=='총기'?'active':''?>" href="shop.php?cate=총기">총기 상점</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$_GET['cate']=='차량'?'active':''?>" href="shop.php?cate=차량">차량 상점</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$_GET['cate']=='물약'?'active':''?>" href="shop.php?cate=물약">물약 상점</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$_GET['cate']=='잡화'?'active':''?>" href="shop.php?cate=잡화">잡화 상점</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$_GET['cate']=='이벤트'?'active':''?>" href="shop.php?cate=이벤트">이벤트 상점</a>
        </li>
    </ul>

	<div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
		<div class="header-body mb-3">
			<div class="row py-3">
				<div class="col-xl-12 col-lg-12 col-md-12 px-5">
					<h1><?=$_GET['cate']?> 상점</h1>
					<p class="text-lead"><?=$_GET['cate']?> 아이템을 구매할 수 있습니다.</p>
				</div>
			</div>
		</div>
	</div>

    <div class="container">
        <div class="row">
            <? foreach ($r_list as $el) { ?>
                <div class="col-lg-4 mb-4">
                    <form autocomplete="off">
                        <input type="hidden" name="itemname" value="<?=$el['name']?>">
                        <input type="hidden" name="itemprice" value="<?=($el['price'] * (100 - $el['sale']) / 100)?>">
                        <div class="card h-100 shadow bg-secondary">
                            <h3 class="card-header"><?=$el['name']?> <?=$el['sale']?'<span class="badge bg-danger rounded-pill text-white" style="font-size:0.5em">'. $el['sale'] .'% SALE</span>':''?></h3>
                            
                            
                            <ul class="list-group list-group-flush">
                                <div class="text-center" style="height: 250px;">
                                    <a href="<?=$el['thumb']?>" target="_blank">
                                        <img src="<?=$el['thumb']?>" alt="" style="height:250px;">
                                    </a>
                                </div>
                                <li class="list-group-item bg-secondary" style="height:100px"><?=$el['content']?></li>
                                <div class="card-body bg-secondary text-center">
                                    <div class="h5"><span class="<?=$el['sale']?'cancel-line':''?>"><?=number_format($el['price'])?></span> <?=$el['sale']?"-> ".number_format($el['price'] * (100 - $el['sale']) / 100):''?> 포인트</div>
                                    <div class="font-italic"><?=$el['amount']?>개당 가격</div>
                                </div>
                                <li class="list-group-item bg-secondary">
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="tel" value=1 name="amount">
                                        <div class="input-group-append">
                                            <span class="input-group-text">개</span>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" onclick="fAjax($(this.form).serializeArray())">구매하기</button>
                                        </div>
                                    </div>
                                </li>
                        </div>
                    </form>
                </div>
            <? } ?>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?if ($startPage > 1) {?><li class="page-item"><a class="page-link" href="?page=1&cate=<?=$_GET['cate']?>">처음</a></li><?}?>
                <?if ($cur_page > 1) {?><li class="page-item"><a class="page-link" href="?page=<?=$cur_page - 1?>&cate=<?=$_GET['cate']?>">이전</a></li><?}?>
                <? if ($r_tot_cnt) for ($i = $startPage; $i <= $endPage; $i++) { ?>
                <li class="page-item<?=$cur_page == $i ? ' active' : '' ?>">
                    <a class="page-link" href="?page=<?=$i?>&cate=<?=$_GET['cate']?>"><?=$i?></a>
                </li>
                <? } ?>
                <?if ($cur_page < $r_tot_cnt) {?><li class="page-item"><a class="page-link" href="?page=<?=$cur_page + 1?>&cate=<?=$_GET['cate']?>">다음</a></li><?}?>
                <?if ($endPage < $r_tot_cnt) {?><li class="page-item"><a class="page-link" href="?page=<?=$r_tot_cnt?>&cate=<?=$_GET['cate']?>">끝</a></li><?}?>
            </ul>

        </nav>
    </div>
</div>


<? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>
<script>
    function fAjax(frm) {
		if (document.xhr) {
            alert("구매 진행중입니다."); 
            return;
        }

        const itemname = frm[0].value;
        const amount = frm[2].value;
        const itemprice = frm[1].value * amount;

        if (confirm(`${itemprice}포인트를 사용하여 [${itemname}] ${amount}개를 구매하시겠습니까?`)) {
            document.xhr = $.ajax({
                url: 'pointshop.proc.php',
                type: 'post',
                data: "req=buy&itemname=" + itemname + "&amount=" + amount,
                dataType: 'json',
                success: function (r) {
                    console.log(r);
                    switch (r.state) {
                        case 'success':
                            alert(r.arr.price + "포인트를 사용하여 \n[" + r.arr.itemname + "] " + r.arr.amount + "개를 구입하였습니다.");
                            location.reload();
                        break;
                        default:
                            if (r.state) alert(r.state);
                        break;
                    }
                },
                error: function (request, status, error) {
                    console.warn(request, status, error);
                },
                complete: function () {
                    document.xhr = false;
                }
            });
        }
	}
</script>
</body>

</html>