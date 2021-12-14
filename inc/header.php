<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="http://soojeong.kro.kr"><img src="/asset/img/choice.jpg" width="40px"> FiveM Choice</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
		  <? if (isset($_SESSION['choice_id'])) { ?>
      <? if (isset($_SESSION['isadmin'])) {?>
        <li class="nav-item px-2">
          <a class="nav-link" href="/adm/items/">아이템 관리</a>
        </li>
      <? } ?>
		  <li class="nav-item dropdown px-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCommunity" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        <span class="mb-0 text-sm  font-weight-bold"><?= $_SESSION['choice_nickname'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCommunity">
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