<?php
session_start();
ini_set( 'display_errors', 1);

// PDO接続
include_once("../inc/config.php");
include_once("../inc/pdoClass.php");
$DB = new DB();

// Class
include_once("../inc/MHClass.php");
  $m = new MHClass;
// POSTデータチェック
//  $m -> po();
// SESSIONデータチェック
//  $m -> se();
// サニタイズ
//  $m -> h($str);


// news確認 && 初期化
$time= (!empty($_POST["time"])) ? $m->h($_POST["time"]) : "";
$title= (!empty($_POST["title"])) ? $m->h($_POST["title"]) : "";
$news= (!empty($_POST["news"])) ? $m->h($_POST["news"]) : "";
$timeCheck= (!empty($_POST["timeCheck"])) ? $m->h($_POST["timeCheck"]) : "";
$titleCheck= (!empty($_POST["titleCheck"])) ? $m->h($_POST["titleCheck"]) : "";
$newsCheck= (!empty($_POST["newsCheck"])) ? $m->h($_POST["newsCheck"]) : "";
$_SESSION["id"]= (!empty($_SESSION["id"])) ? $m->h($_SESSION["id"]) : "";
$_SESSION["pass"]= (!empty($_SESSION["pass"])) ? $m->h($_SESSION["pass"]) : "";
$_SESSION["time"]= (!empty($_SESSION["time"])) ? $m->h($_SESSION["time"]) : "";
$_SESSION["title"]= (!empty($_SESSION["title"])) ? $m->h($_SESSION["title"]) : "";
$_SESSION["news"]= (!empty($_SESSION["news"])) ? $m->h($_SESSION["news"]) : "";

// $flag( 1:投稿画面 2:投稿チェック画面 3:送信完了通知画面)
$flag=0;

//管理者チェック
if($_SESSION["id"]==ADMIN && $_SESSION["pass"]==PASS){
  $flag=1;
}else{
//管理者でなければセッション破棄
  header("Location: ../index.php");
  exit();
}

// 投稿チェック
if($time != "" && $title != "" && $news != "")
{
//  print "OK";
  $_SESSION["time"]= $time;
  $_SESSION["title"]= $title;
  $_SESSION["news"]= $news;
  $flag=2;
}
if($timeCheck != "" && $titleCheck != "" && $newsCheck != "")
{
//  print "OK";
//INSERT
  $news= $DB -> newsInsert($timeCheck, $titleCheck, $newsCheck);
  $_SESSION["time"]= "";
  $_SESSION["title"]= "";
  $_SESSION["news"]= "";
  $flag=3;
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>管理画面</title>
<link rel="shortcut icon" href="../images/faviconB.ico">
<link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="../css/reset.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript"></script>
</head>

<body>
<article>

<header>
    <h1 class="header">管理画面
<!--      <img class="logo" src="../images/ikupaca_logo.png" alt="ikupaca">-->
    </h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li><a href="./index.php">ログオフ</a></li>
      <li class="now"><a href="">新着情報追加</a></li>
      <li><a href="./newsEdit.php">新着情報編集</a></li>
      <li><a href="./tw.php">つぶやき編集</a></li>
      <li><a href="./image.php">画像保存</a></li>
      <li><a href="./imageAll.php">画像一覧</a></li>
    </ul>
    </div>
    <hr>
    
</header>
<!-- header class="header" -->
<?php


//はーい、分岐ですよ〜
if($flag==1){
?>
<main>
  <h2>【新着情報追加】</h2>
  <form action="" method="post">
    <dl>
     <dt><label for="timeAdmin">投稿時間</label></dt>
     <dd><input type="text" id="timeAdmin" name="time" value="<?php echo date('Y/m/d H:i:s'); ?>"></dd>
      <dt><label for="titleAdmin">【タイトル】</label></dt>
      <dd><input type="text" id="titleAdmin" name="title" value="<?php echo $_SESSION["title"]; ?>"></dd>
      <dt><label for="textAdmin">【内容】</label></dt>
      <dd><textarea rows="10" name="news" id="textAdmin"><?php echo $_SESSION["news"]; ?></textarea></dd>
    </dl>
    <p><input type="submit" value="確認"></p>
  </form>
<?php


}elseif($flag==2){
?>
<main>
  <h2>【新着情報追加】</h2>
  <form action="" method="post">
    <dl>
     <dt>投稿時間</dt>
     <dd><?php echo $_SESSION["time"]; ?></dd>
      <dt>【タイトル】</dt>
      <dd><?php echo $_SESSION["title"]; ?></dd>
      <dt>【内容】</dt>
      <dd><?php echo nl2br($_SESSION["news"]); ?></dd>
    </dl>
    <p><input type="submit" value="送信"></p><br>
    <p><input class="redButton" type="button" onclick="location.href='./news.php'" value="戻る"></p>
     <dl>
      <dd><input type="hidden" id="timeCheck" name="timeCheck" value="<?php echo $_SESSION["time"]; ?>"></dd>
      <dd><input type="hidden" id="titleCheck" name="titleCheck" value="<?php echo $_SESSION["title"]; ?>"></dd>
      <dd><input type="hidden" name="newsCheck" id="newsCheck" value="<?php echo $_SESSION["news"]; ?>"></dd>
    </dl>
  </form>
<?php


}elseif($flag==3){
?>
<main id="heightAdmin">
  <h2>【新着情報追加】</h2>
  <p>送信が完了しました。</p>
  <p><input class="redButton" type="button" onclick="location.href='./news.php'" value="戻る"></p>
<?php
}else{
  
}
?>




</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

