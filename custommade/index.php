<?php
session_start();
ini_set( 'display_errors', 1);

// PDO接続
include_once("../inc/config.php");
// Class
include_once("../inc/MHClass.php");
  $m = new MHClass;
// POSTデータチェック
//  $m -> po();
//SESSIONデータチェック
//  $m -> se();
//サニタイズ
//  $m -> h($str);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>カスタムメイド</title>
<link rel="shortcut icon" href="../images/faviconB.ico">
<link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="../css/reset.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<!--<link rel="stylesheet" type="text/css" href="../css/admin.css">-->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
<article>

<header>
    <h1 class="header">カスタムメイド
<!--      <img class="logo" src="../images/ikupaca_logo.png" alt="ikupaca">-->
    </h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li id="n2"><a href="../index.php">Home</a></li>
      <li id="n3"><a href="../profile.php">Profile</a></li>
      <li id="n0"><a class="now" href="">カスタムメイド</a></li>
      <li id="n4"><a href="../works.php">ギャラリー</a></li>
      <li id="n5"><a href="../intro/index.php">お店紹介</a></li>
      <li id="n9"><a href="../event.php">イベント</a></li>
      <li id="n6"><a href="http://ameblo.jp/koharu-biyori-rena/" target="_blank">ブログ</a></li>
      <li id="n7"><a href="https://www.facebook.com/ikupaca" target="_blank">facebook</a></li>
      <li id="n1"><a href="https://instagram.com/IKUPACA/" target="_blank">Instagram</a></li>
      <li id="n8"><a href="../contact.php">お問合わせ</a></li>
<!--      <li><a href="">チームikupaca</a></li>-->
<!--      <li><a href="">Access</a></li>-->
    </ul>
    </div>
    <hr>

</header>
<!-- header class="header" -->

<main id="mainpage">
<h2 id="p_back3">カスタム<br>メイド</h2>

<div class=""> 

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<hr>
</div>
</main>

<?php include_once("../tmp/footer.php"); ?>

<div class="pagetop" style="position:fixed;right:5px;bottom:80px;"><a href="#mainpage"><img width="80" src="../images/top.png" alt="↑"></a></div>
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




</body>
</html>