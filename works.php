<?php
//ログオフ
session_start();
// SESSIONを削除
$_SESSION = array();
session_destroy();

ini_set( 'display_errors', true);
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();

// Class
include_once("./inc/MHClass.php");

// 表示用画像
if (isset($_GET['id'])) {
	try {
			$stmt = $pdo->prepare('SELECT type, raw_data FROM tw WHERE id = ? LIMIT 1');
			$stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
			$stmt->execute();
			if (!$row = $stmt->fetch()) {
					throw new RuntimeException('該当する画像は存在しません', 404);
			}
			header('X-Content-Type-Options: nosniff');
			header('Content-Type: ' . image_type_to_mime_type($row['type']));
			echo $row['raw_data'];
	} catch (RuntimeException $e) {
			http_response_code($e instanceof PDOException ? 500 : $e->getCode());
			$msgs[] = ['red', $e->getMessage()];
	}
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ikupaca</title>
<!--  <meta name="keywords" content="ikupaca">-->
<!--  <meta name="description" content="ikupacaワールドへようこそ。京都宇治を拠点に活動中。カラフルを大切にbabyからご長寿まで愛されるような作品を日々ハンドメイドしております。合言葉はクレイジーゴナクレイジー！"> -->
  
<!--  検索させない！-->
  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
  
  <link rel="shortcut icon" href="./images/faviconB.ico">
  <link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script type="text/javascript" src="./js/jquery.js"></script>
  
</head>

<body>
<article>
  <header>
    <h1 class="header">ikupaca<img class="logo" src="./images/ikupaca_logo.png" alt="ikupaca"></h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li id="n2"><a href="./index.php">Home</a></li>
      <li id="n3"><a href="./profile.php">Profile</a></li>
      <li id="n4"><a class="now" href="./works.php">作品紹介</a></li>
      <li id="n5"><a href="./intro/index.php">サイト紹介</a></li>
      <li id="n6"><a href="http://ameblo.jp/koharu-biyori-rena/" target="_blank">ブログ</a></li>
      <li id="n7"><a href="https://www.facebook.com/ikupaca" target="_blank">facebook</a></li>
      <li id="n1"><a href="https://instagram.com/IKUPACA/" target="_blank">Instagram</a></li>
      <li id="n8"><a href="./contact.php">お問合わせ</a></li>
<!--      <li><a href="">チームikupaca</a></li>-->
<!--      <li><a href="">Access</a></li>-->
    </ul>
    </div>
    <hr>

  </header>
  <!-- header class="header" -->

  <div class="wrapper">
    <div class="content">
      <div id="p_con">

        <h2 id="p_back2">作品紹介</h2>
        <p id="wk1">
        <a href="./works/20150918_2734.jpg" target="_blank"><img class="works" src="./works/20150918_2734.jpg" alt=""></a>
        <a href="./works/20150918_3185.jpg" target="_blank"><img class="works" src="./works/20150918_3185.jpg" alt=""></a>
        <a href="./works/20150918_4329.jpg" target="_blank"><img class="works" src="./works/20150918_4329.jpg" alt=""></a>
        <a href="./works/20150918_4339.jpg" target="_blank"><img class="works" src="./works/20150918_4339.jpg" alt=""></a>
        <a href="./works/20150918_4513.jpg" target="_blank"><img class="works" src="./works/20150918_4513.jpg" alt=""></a>
        <a href="./works/20150918_4655.jpg" target="_blank"><img class="works" src="./works/20150918_4655.jpg" alt=""></a>
        <a href="./works/20150918_4779.jpg" target="_blank"><img class="works" src="./works/20150918_4779.jpg" alt=""></a>
        <a href="./works/20150918_5243.jpg" target="_blank"><img class="works" src="./works/20150918_5243.jpg" alt=""></a>
        <a href="./works/20150918_5259.jpg" target="_blank"><img class="works" src="./works/20150918_5259.jpg" alt=""></a>
        <a href="./works/20150918_5549.jpg" target="_blank"><img class="works" src="./works/20150918_5549.jpg" alt=""></a>
        <a href="./works/20150918_5862.jpg" target="_blank"><img class="works" src="./works/20150918_5862.jpg" alt=""></a>
        <a href="./works/20150918_5983.jpg" target="_blank"><img class="works" src="./works/20150918_5983.jpg" alt=""></a>
        <a href="./works/20150918_6533.jpg" target="_blank"><img class="works" src="./works/20150918_6533.jpg" alt=""></a>
        <a href="./works/20150918_7638.jpg" target="_blank"><img class="works" src="./works/20150918_7638.jpg" alt=""></a>
        <a href="./works/20150918_7819.jpg" target="_blank"><img class="works" src="./works/20150918_7819.jpg" alt=""></a>
        <a href="./works/20150918_8542.jpg" target="_blank"><img class="works" src="./works/20150918_8542.jpg" alt=""></a>
        <a href="./works/20150918_8598.jpg" target="_blank"><img class="works" src="./works/20150918_8598.jpg" alt=""></a>
        <a href="./works/20150918_9084.jpg" target="_blank"><img class="works" src="./works/20150918_9084.jpg" alt=""></a>
        </p>
       
      </div>
<!--   div class="p_con"-->
    </div>
    <!-- div class="content" -->

  </div>
  <!-- div class="wrapper" -->

<?php include_once("./tmp/footer.php"); ?>

<div class="pagetop" style="position:fixed;right:5px;bottom:80px;"><a href="#mainpage"><img width="80" src="./images/top.png" alt="↑"></a></div>
</article>

<script type="text/javascript">
$(document).ready(function() {
  var pagetop = $('.pagetop');
  pagetop.hide();
    $(window).scroll(function () {
       if ($(this).scrollTop() > 400) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});

</script>

</article>
</body>
</html>