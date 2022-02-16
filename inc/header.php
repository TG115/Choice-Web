<? include_once $_SERVER["DOCUMENT_ROOT"]."/lib/_menu.php"; ?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="http://soojeong.kro.kr"><img src="/asset/img/HIVE.png" width="40px"> FiveM Hive</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <? if (isset($_SESSION['hive_id'])) { ?>

          <? if (isset($_SESSION['isadmin'])) {?>
            <li class="nav-item dropdown px-2">
              <a class="nav-link dropdown-toggle" href="#" id="adm_shop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mb-0 text-sm">상점 관리</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adm_shop">
                <a class="dropdown-item" href="/adm/shop/?cate=총기">총기 상점 관리</a>
                <a class="dropdown-item" href="/adm/shop/?cate=차량">차량 상점 관리</a>
                <a class="dropdown-item" href="/adm/shop/?cate=물약">물약 상점 관리</a>
                <a class="dropdown-item" href="/adm/shop/?cate=잡화">잡화 상점 관리</a>
                <a class="dropdown-item" href="/adm/shop/?cate=이벤트">이벤트 상점 관리</a>
              </div>  
            </li>
            <li class="nav-item dropdown px-2">
              <a class="nav-link dropdown-toggle" href="#" id="adm_item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mb-0 text-sm">아이템 관리</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adm_item">
                <a class="dropdown-item" href="/adm/items/giveItem.php">아이템 지급</a>
                <a class="dropdown-item" href="/adm/items/giveLog.php">아이템 지급 로그</a>
                <hr>
                <a class="dropdown-item" href="/adm/items/givePoint.php">포인트 지급</a>
                <a class="dropdown-item" href="/adm/items/pointLog.php">포인트 지급 로그</a>
                <hr>
                <a class="dropdown-item" href="/adm/items/quickLog.php">퀵배송 로그</a>
                <a class="dropdown-item" href="/adm/items/registerLog.php">회원가입 선물 로그</a>
              </div>  
            </li>
            <li class="nav-item dropdown px-2">
              <a class="nav-link dropdown-toggle" href="#" id="pointshop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mb-0 text-sm">포인트 상점</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pointshop">
                <a class="dropdown-item" href="/shop.php?cate=총기">총기 상점</a>
                <a class="dropdown-item" href="/shop.php?cate=차량">차량 상점</a>
                <a class="dropdown-item" href="/shop.php?cate=물약">물약 상점</a>
                <a class="dropdown-item" href="/shop.php?cate=잡화">잡화 상점</a>
                <a class="dropdown-item" href="/shop.php?cate=이벤트">이벤트 상점</a>
              </div>  
            </li>
          <? } ?>

          <li class="nav-item dropdown px-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMypage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mb-0 text-sm  font-weight-bold"><?= $_SESSION['hive_nickname'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMypage">
              <a class="dropdown-item" href="/pointlogs.php">내 포인트 : <?= number_format(SQL_myPoint($_SESSION['user_id']))?></a>
              <a class="dropdown-item" href="/">마이 페이지</a>
              <hr>
              <a class="dropdown-item" href="/logout.php">로그아웃</a>
            </div>
          </li>
        <? } else { ?>
		  <li class="nav-item px-2">
            <a class="nav-link" href="/login.php">로그인</a>
          </li>
		  <? }?>
        </ul>
      </div>
    </div>
  </nav>