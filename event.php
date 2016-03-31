<?php
//ログオフ
session_start();
//// SESSIONを削除
//$_SESSION = array();
//session_destroy();

ini_set( 'display_errors', true);
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();

// Class
include_once("./inc/MHClass.php");
//$m= new MHClass();
//$year= 2016;
//$month= 2;
//$m::calendar($year,$month);
//$m-> calendar($year,$month);
//MHClass::calendar($year,$month);

//$i="1abc";
//if($i==1){
//  echo "NG";
//}

//$r= range(0,100,5);
//print_r($r);


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
      <li id="n4"><a href="./works.php">作品紹介</a></li>
      <li id="n9"><a class="now" href="./event.php">イベント</a></li>
      <li id="n5"><a href="./intro/index.php">お店紹介</a></li>
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

        <h2 id="e_back">イベント</h2>
        
        <div id="ev">
        <img class="event" src="./images/20160220_event.jpg" alt="event画像">
<p>
2016.2/21 10時〜16時<br>
<span class="ki">コトマルシェ</span>に出展します。<br>
伏見桃山MOMOテラス1階、ブースno.23にて出展いたします。<br>
皆様よろしくお願いいたします！<br>
詳しくは<a class="ki" href="https://www.facebook.com/ikupaca">facebook</a>をご覧ください。
</p>
       </div>
<!--       div#ev-->
      </div>
<!--   div class="p_con"-->
    </div>
    <!-- div class="content" -->

  </div>
  <!-- div class="wrapper" -->

<?php include_once("./tmp/footer.php"); ?>
</article>
</body>
</html>