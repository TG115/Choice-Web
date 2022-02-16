<? include_once 'bbs.proc.php' ?>
<? include $_SERVER["DOCUMENT_ROOT"].'/inc/head.php' ?>
<?
    $GLOBALS['api_params']['not_view_cnt'] = false;
    $r = include 'view.proc.php';
    $r_id = @$r['arr']['id'];
    $r_bbs = @$r['arr']['bbs'];
    $r_this = @$r['arr']['this'][0];
    $r_prev = @$r['arr']['prev'][0];
    $r_next = @$r['arr']['next'][0];
    $likes = SQL_Get_bbs_like($r_this['idx']);
    $description = mb_strlen(strip_tags($r_this['content']), 'euc-kr') > 200 ? substr(strip_tags($r_this['content']), 0, 200) . "..." : strip_tags($r_this['content']);
?>
	<title>FiveM Hive - <?=$r_this['title']?></title>

</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>
<div class="container my-5">
    <!-- Page Heading/Breadcrumbs -->
	<h1 class="mt-4 mb-3">커뮤니티
	<small><?=$r_this['bbs']?></small>
	</h1>

	<ol class="breadcrumb">
    <li class="breadcrumb-item disabled">커뮤니티</li>
	<li class="breadcrumb-item active"><?=$r_this['bbs']?></li>
	</ol>

    <ul class="nav nav-tabs mb-5">
        <li class="nav-item">
            <a class="nav-link <?=$r_this['bbs'] == "공지사항" ? 'active' : ''?>" href="notice.php">공지사항</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$r_this['bbs'] == "자유 게시판" ? 'active' : ''?>" href="freeboard.php">자유 게시판</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$r_this['bbs'] == "이벤트 게시판" ? 'active' : ''?>" href="eventboard.php">이벤트 게시판</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$r_this['bbs'] == "꿀팁 게시판" ? 'active' : ''?>" href="tipboard.php">꿀팁 게시판</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?=$r_this['bbs'] == "질문 게시판" ? 'active' : ''?>" href="qnaboard.php">질문 게시판</a>
        </li>
    </ul>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card bg-secondary">
                    <div class="card-header border-0">
                        <h4 class="mb-0">[<?= $r_this['cname'] ?>] <?= htmlspecialchars($r_this['title']) ?></h4>
                    </div>

                    <div class="p-3">
                        <div class="text-right mini-info">
                        <span class="px-3"><? if (isAdminId($r_this['user_id'])) echo "<img src='/asset/img/HIVE.png' width='17px'>"; ?> <strong><?= SQL_getUserName($r_this['user_id'])?> [<?= $r_this['user_id'] ?>]</strong></span> |
                        <span class="px-3">등록일 : <span class="text-white-50"><?if (date("Y-m-d", strtotime($r_this['wdate'])) == date("Y-m-d")) {
                            echo date("H:i:s", strtotime($r_this['wdate']));
                        } else {
                            echo date("Y-m-d", strtotime($r_this['wdate']));
                        }?></span></span>|
                        <span class="px-3">추천 : <span class="text-white-50 bbs_Likes"><?= number_format($likes) ?></span></span>|
                        <span class="px-3">조회수 : <span class="text-white-50"><?= number_format($r_this['hit']) ?></span></span>
                        </div>
                        <hr>
                        <div class="card-text m-4">
                        <?= $r_this['content'] ?>
                        </div>
                        <div class="my-5 text-center">
                            <button type="button" data-micron="groove" class="btn btn-outline-info px-4" onclick="likeUp(<?= $r_this['idx'] ?>);">
                                <div class="h4 bbs_Likes"><?= $likes ?></div>
                                <div class="fw-bold">추천</div>
                            </button>
                        </div>
                        <hr>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col text-right">
                                    <? if ($r_this['user_id'] == @$_SESSION['user_id'] || isset($_SESSION['isadmin'])) { ?>
                                    <button type="button" class="btn btn-warning" onclick="location.href='write.php?ACT=r&idx=<?=$r_this['idx']?>'">수정 / 삭제</button>
                                    <? } ?>
                                    <button type="button" class="btn btn-secondary" onclick="location.href='<?=getPageName($r_bbs)?>'">목록</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table border-bottom table-dark">
                                <tbody>
                                <?
                                    if ($r_prev) {
                                        echo '<tr>';
                                        echo     '<td width="100" class="text-center font-weight-bold" style="background: rgba(0,0,0,.5);">이전글 ▲</td>';
                                        echo     '<td class="pl-4"><div class="bbs_title"><a href="view.php?idx='. $r_prev['idx'] .'">'. htmlspecialchars($r_prev['title']) .'</a></div></td>';
                                        echo '</tr>';
                                    }

                                    if ($r_next) {
                                        echo '<tr>';
                                        echo     '<td width="100" class="text-center font-weight-bold" style="background: rgba(0,0,0,.5);">다음글 ▼</td>';
                                        echo     '<td class="pl-4"><div class="bbs_title"><a href="view.php?idx='. $r_next['idx'] .'">'. htmlspecialchars($r_next['title']) .'</a></div></td>';
                                        echo '</tr>';
                                    } 
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <?
                            $cmts = include 'comment.proc.php';
                            foreach ($cmts['arr']['this'] as $el) { 
                                $comment = strip_tags($el['comment']);
                                if (date("Y-m-d", strtotime($el['wdate'])) == date("Y-m-d")) {
                                    $date = date("H:i:s", strtotime($el['wdate']));
                                } else {
                                    $date = date("Y-m-d", strtotime($el['wdate']));
                                }
                                ?>
                                <div class="media border-top border-bottom p-3">
                                    <!-- <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt=""> -->
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <? if (isAdminId($el['user_id'])) echo "<img src='/asset/img/HIVE.png' width='17px'>"; ?> <strong><?=SQL_getUserName($el['user_id'])?> [<?=$el['user_id']?>]</strong> <? if ($el['user_id'] == $r_this['user_id']) {?><span class="badge rounded-pill bg-info text-white">작성자</span><?}?> | <?=$date?>
                                            </div>
                                            <div class="col-4 text-right">
                                                <? if($el['user_id'] == @$_SESSION['user_id'] || isset($_SESSION['isadmin'])) { ?>
                                                <button class="btn btn-danger" onclick="if (confirm('이 댓글을 삭제하시겠습니까?')) fdAjax(<?=$el['cmt_idx']?>)">삭제</button>
                                                <? } ?>
                                            </div>
                                        </div>
                                        <?=nl2br($comment)?>
                                    </div>
                                </div>
                            <? } ?>
                            <div class="card my-4 bg-dark">
                            <h5 class="card-header">댓글을 남겨주세요 :</h5>
                                <div class="card-body">
                                    <? if(isset($_SESSION['hive_id'])) { ?>
                                        <form id="AjaxForm" method="post">
                                            <input type="hidden" name="idx" value="<?=$r_this['idx']?>">
                                            <input type="hidden" name="ACT" value="w">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" name='comment' placeholder="댓글 작성 시 타인을 존중해주세요." style="background-color:rgba(255,255,255,.1); color:white"></textarea>
                                            </div>
                                            <div class="text-right"><button type="button" data-micron="bounce" class="btn btn-primary" onclick="fAjax($(this.form))">댓글 등록</button></div>
                                        </form>
                                    <? } else {?>
                                        <a href="/login"><textarea class="form-control" rows="3" name='comment' disabled>로그인 후 이용하실 수 있습니다.[클릭]</textarea></a>
                                    <? } ?>
                                        
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


</div>


<? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>

<script>

    function fAjax(target) {
		if (document.xhr) return;

		var frm = target[0];
        var formData = new FormData(frm);

		document.xhr = $.ajax({
			url: 'comment.proc.php',
			type: 'post',
			data: formData,
			processData:false,
			contentType:false,
			dataType: 'json',
			success: function (r) {
                console.log(r);
				switch (r.state) {
					case 'insert':
						alert('댓글이 정상적으로 등록되었습니다.');
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
    function fdAjax(idx) {
		if (document.xhr) return;

		document.xhr = $.ajax({
			url: 'comment.proc.php',
			type: 'post',
			data: "ACT=d&cmt_idx=" + idx,
			dataType: 'json',
			success: function (r) {
                console.log(r);
				switch (r.state) {
					case 'delete':
						alert('댓글이 정상적으로 삭제되었습니다.');
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
</script>
</body>
</html>