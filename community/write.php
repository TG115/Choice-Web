<?
    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['hive_id'])) {
        echo '<script>alert("로그인 후 이용하실 수 있습니다."); location.href="/login";</script>';
    }
?>

<? include_once 'bbs.proc.php'; ?>

<?
	$r = include 'write.proc.php';
	$r_ACT = @$r['arr']['ACT'];
	$r_idx = @$r['arr']['idx'];
	$r_bbsOne = @$r['arr']['bbsOne'][0];
	$img_url = @$r['arr']['img_url'];
    $bbs = @$r_bbsOne['bbs'] ?? @$_GET['bbs'];
    if (($bbs == "공지사항" || $bbs == "이벤트 게시판") && !isset($_SESSION['isadmin'])) echo '<script>alert("작성 권한이 없습니다."); history.back();</script>';
?>


<? include $_SERVER["DOCUMENT_ROOT"]."/inc/head.php" ?>
    <link href="/asset/css/quill.snow.css" rel="stylesheet">
	<title>FiveM Hive - 글쓰기</title>
</head>

<body>
<? include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php" ?>
<div class="container my-5">
    <!-- Page Heading/Breadcrumbs -->
	<h1 class="mt-4 mb-3"><?=$bbs?></h1>
    <div class="container-fluid mt--6">
    	<div class="row">
    		<div class="col">
    			<div class="card bg-secondary">
    				<div class="card-header border-0">
						<h3 class="mb-0">글 <?= $r_ACT=='r' ? "수정" : "작성" ?></h3>
    				</div>

    				<form id="ajaxForm" autocomplete="off">
						<input type="hidden" name="idx" value="<?=$r_idx?>">
						<input type="hidden" name="ACT" value="<?= !$r_ACT ? 'w' : 'u' ?>">
                        <input type="hidden" name="bbs" value="<?=$bbs?>">
    					<div class="container-fluid p-5">
                            <? if (isset($_SESSION['isadmin'])) { ?>
                                <div class="text-right">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="noticeCheckbox" name="noti" <?= @$r_bbsOne['wflag'] == "공지" ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="noticeCheckbox">공지글 지정</label>
                                    </div>
                                </div>
                            <?}?>
    						<div class="form-group">
    							<label for="title">제목</label>
    							<input type="text" name="title" value="<?= $r_ACT ? $r_bbsOne['title'] : "" ?>" class="form-control" id="title" placeholder="제목을 적어주세요." required>
    						</div>
    						<div class="form-group">
    							<label for="cate">카테고리</label>
								<select class="form-control" name="cid" class="form-control" id="cate">
									<? 
										//$arr_cate = libConCate(0);
										
										for($c=0; $c<count($arr_cate); $c++){ 
											$row = $arr_cate[$c];
									?>
                                        
										<option value="<?= $row['idx'] ?>" <?= @$r_bbsOne['cid'] == $row['idx'] ? 'selected' : ''; ?>>
											<?= $row['cname'] ?>
										</option>
									<? } ?>
								</select>
    						</div>
							<div style="background-color:white; color:black">
								<div id="quillEdtior" style="height:1000px"></div>
								<textarea name="conts" style="display:none;" class="form-control" id="editorTxt">
									<?= $r_ACT ? $r_bbsOne['content'] : "" ?>
								</textarea>
							</div>
    					</div>

    					<div class="card-footer py-4">
    						<div class="text-center py-4">
    							<button type="button" class="btn btn-primary" onclick="fAjax($(this.form))">저장</button>
								<? if ($r_ACT=='r') { ?>
    								<button type="button" class="btn btn-danger" onclick="if (confirm('이 글을 삭제하시겠습니까?')) fdAjax(<?=$r_idx?>)">삭제</button>
								<? } ?>
    							<button type="button" class="btn btn-secondary" onclick="window.history.back()">취소</button>
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>

    </div>

</div>


<? include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php" ?>
<script src="/asset/js/quill.min.js"></script>
<script>
	var quillOpt = [
		[{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
		[{ 'header': [ 2, 3, 4, 5, 6, false] }],
		[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
		['bold', 'italic', 'underline', 'strike'],        // toggled buttons
		[{ 'align': [] }],
		['blockquote', 'code-block'],

		['link'], ['image'],
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
		[{ 'direction': 'rtl' }],                         // text direction
		['clean']
	];

	var quill = new Quill('#quillEdtior', {
		modules: {
			toolbar: quillOpt
		},
		placeholder: 'Content',
		theme: 'snow'
	});	

	quill.getModule('toolbar').addHandler('image', function(){
		selectLocalImage();
	})

	var txtArea = $('#editorTxt');
	var myEditor = $('#quillEdtior').find('.ql-editor');

	quill.on('text-change', (delta, oldDelta, source) => {
		txtArea.val(myEditor.html())
	})

	function selectLocalImage(){
		const input = document.createElement('input');
		input.setAttribute('type', 'file');
		input.setAttribute('accept', 'image/*');
		input.setAttribute('name', 'imageFile');
		input.click();

		input.onchange = function(){
			const fd = new FormData();
			const file = $(this)[0].files[0];
			fd.append('imageFile', file);

			$.ajax({
				type: 'post',
				enctype: 'multipart/form-data',
				url: 'upload_proc.php',
				data: fd,
				processData:false,
				contentType:false,
				dataType: 'json',
				success: function(data) {
					if(data.error) {
						alert(data.error);
					} else {
						const range = quill.getSelection();
						quill.insertEmbed(range.index, 'image', data.url);
					}
				},
				error: function(err) {
					console.error('Error ::: '+err);
				}
			})
		}
	}

	$(function(){
		if($('#editorTxt').val()) {
			quill.clipboard.dangerouslyPasteHTML($('#editorTxt').val());
		}
	})

	function fAjax(target) {
		if (document.xhr) return;

		var frm = target[0];
        var formData = new FormData(frm);

		document.xhr = $.ajax({
			url: 'write.proc.php',
			type: 'post',
			data: formData,
			processData:false,
			contentType:false,
			dataType: 'json',
			success: function (r) {
                console.log(r);
				switch (r.state) {
					case 'insert':
						alert('글이 정상적으로 등록되었습니다.');
						location.href = r.arr.pagename;
					break;
					case 'update':
						alert('글이 정상적으로 수정되었습니다.');
						location.href = r.arr.pagename;
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
			url: 'write.proc.php',
			type: 'post',
			data: "ACT=d&idx=" + idx,
			dataType: 'json',
			success: function (r) {
                console.log(r);
				switch (r.state) {
					case 'delete':
						alert('글이 정상적으로 삭제되었습니다.');
						location.href = r.arr.pagename;
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

	function thumbChange(target) {
		var base = target.parents('.box-file');
		var inputFile = '<input class="form-control" type="file" name="thumb" accept="image/*">';

		base.empty().append(inputFile);
	}
</script>

</body>
</html>