<?php
session_start();
ini_set( 'display_errors', 1);

// PDO接続
include_once("../inc/config.php");
include_once("../inc/pdoClass.php");
include_once("../inc/MHClass.php");
$DB = new DB();
$m= new MHClass;

// $flag( 1:投稿画面 , 2:送信完了画面)
$flag=0;

//管理者チェック
if($_SESSION["id"]==ADMIN && $_SESSION["pass"]==PASS){
  $flag=1;
}else{
//管理者でなければセッション破棄
  header("Location: ../index.php");
  exit();
}



#### DB_addAccess  
//> id             : int(10)      : ID  
//> date           : datetime     : 日付  
//> site_name      : varchar(255) : サイト名  
//> site_comment   : text         : サイト紹介  
//  
//> ad_id          : int(11)      : 郵便番号  
//> ad             : varchar(255) : 住所  
//  
//> tel            : int(11)      : 電話番号  
//> site           : varchar(255) : サイト名  
//> url            : varchar(255)   : サイトURL  

// 初期化
$table= 'addTable';
$file="file";
$site_name= (!empty($_POST["site_name"])) ? $m->h($_POST["site_name"]) : "";
//$site_comment= (!empty($_POST["site_comment"])) ? $m->h($_POST["site_comment"]) : "";
$site_comment= (!empty($_POST["site_comment"])) ? ($_POST["site_comment"]) : "";
$ad_id= (!empty($_POST["ad_id"])) ? $m->h($_POST["ad_id"]) : "";
$ad= (!empty($_POST["ad"])) ? $m->h($_POST["ad"]) : "";
$tel= (!empty($_POST["tel"])) ? $m->h($_POST["tel"]) : "";
$site= (!empty($_POST["site"])) ? $m->h($_POST["site"]) : "";
$url= (!empty($_POST["url"])) ? $m->h($_POST["url"]) : "";

$_SESSION["site_name"]= (!empty($_SESSION["site_name"])) ? $m->h($_SESSION["site_name"]) : "";
$_SESSION["site_comment"]= (!empty($_SESSION["site_comment"])) ? $m->h($_SESSION["site_comment"]) : "";
$_SESSION["ad_id"]= (!empty($_SESSION["ad_id"])) ? $m->h($_SESSION["ad_id"]) : "";
$_SESSION["ad"]= (!empty($_SESSION["ad"])) ? $m->h($_SESSION["ad"]) : "";
$_SESSION["tel"]= (!empty($_SESSION["tel"])) ? $m->h($_SESSION["tel"]) : "";
$_SESSION["site"]= (!empty($_SESSION["site"])) ? $m->h($_SESSION["site"]) : "";
$_SESSION["url"]= (!empty($_SESSION["url"])) ? $m->h($_SESSION["url"]) : "";
$_SESSION["msg"]= "";

//置き換え
$comment= $_SESSION["site_comment"];
$i= array($m->h("リンク=>"),$m->h("<=リンク"),$m->h("//リンク"));
$j= array('<a href="','">','</a>');
//$test= str_replace($i,$j,$test);
$comment= str_replace($i,$j,$comment);
echo nl2br($comment);
//<dd class="bl">サイト：

$m->se();

// 投稿チェック
if(empty($site_name) || empty($site_comment) || empty($ad_id) || empty($ad))
{
//  print "1 OK";
  $_SESSION["site_name"]= $site_name;
  $_SESSION["site_comment"]= $site_comment;
  $_SESSION["ad_id"]= $ad_id;
  $_SESSION["ad"]= $ad;
  $_SESSION["tel"]= $tel;
  $_SESSION["site"]= $site;
  $_SESSION["url"]= $url;
  $_SESSION["msg"]= '<dt style="color:red;font-size:2rem;">必須項目を埋めていません</dt>';
  $flag=1;
}else{
//  print "2 OK";
//INSERT
$val1= array("site_name",$site_name,"string");
$val2= array("site_comment",$site_comment,"string");
$val3= array("ad_id",$ad_id,"string");
$val4= array("ad",$ad,"string");
$val5= array("tel",$tel,"string");
$val6= array("site",$site,"string");
$val7= array("url",$url,"string");
$val8= array("date","NOW()","datetime");
$val9= array("flag",1,"integer");

$valuesInsert=array($val1,$val2,$val3,$val4,$val5,$val6,$val7,$val8,$val9);

// 画像投稿チェック
/* アップロードがあったとき */
//if (isset($_FILES['addfile']['error']) && is_int($_FILES['addfile']['error'])) {
//  $file= $_FILES['addfile'];
////  $flag= $DB -> ImageInsert($table,$file);
//}

$DIOi=array($table,$valuesInsert);
$DB->addInsert($DIOi);

  $_SESSION["site_name"]= "";
  $_SESSION["site_comment"]= "";
  $_SESSION["ad_id"]= "";
  $_SESSION["ad"]= "";
  $_SESSION["tel"]= "";
  $_SESSION["site"]= "";
  $_SESSION["url"]= "";
  $_SESSION["msg"]= "";
  $flag=2;
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
      <li><a href="./news.php">新着情報追加</a></li>
      <li><a href="./newsEdit.php">新着情報編集</a></li>
      <li><a href="./twadd.php">つぶやき追加</a></li>
      <li><a href="./twEdit.php">つぶやき編集</a></li>
      <li class="now"><a href="./site.php">サイト紹介</a></li>
      <li><a href="./siteAll.php">サイト一覧</a></li>
      <li><a href="./image.php">画像保存</a></li>
      <li><a href="./imageAll.php">画像一覧</a></li>
      <li class=""><a href="./imageTop.php">トップ画像一覧</a></li>
      <li class=""><a href="./imageWorks.php">作品画像一覧</a></li>
    </ul>
    </div>
    <hr>
    
</header>
<!-- header class="header" -->
<?php

//はーい、分岐ですよ〜
if($flag==1){
?>
<main id="">
  <h2>【サイト一覧】</h2>
  <p><input type="button" onclick="location.href='./siteAll.php'" value="サイト一覧"></p>
  <h2>【サイト追加】</h2>
  <form enctype="multipart/form-data" action="" method="post">
    <dl><?php 
if($_SESSION["msg"]){
  echo $_SESSION["msg"];
}


      ?> 
      <dt><label for="site_name">紹介する方のお名前<span  style="color:red;font-size:0.6rem;padding-left:1rem;">※ 必須</span></label></dt>
      <dd><input type="text" name="site_name" id="site_name" value="<?php echo $_SESSION["site_name"] ?>"></dd>
      <dt><label for="site_comment">紹介文<span  style="color:red;font-size:0.6rem;padding-left:1rem;">※ 必須</span></label></dt>
      <dd><textarea name="site_comment" id="site_comment"><?php echo $_SESSION["site_comment"] ?></textarea></dd>
      <dt><label for="ad_id">郵便番号<span  style="color:red;font-size:0.6rem;padding-left:1rem;">※ 必須</span></label></dt>
      <dd><input type="text" name="ad_id" id="ad_id" value="<?php echo $_SESSION["ad_id"] ?>"></dd>
      <dt><label for="ad">住所<span  style="color:red;font-size:0.6rem;padding-left:1rem;">※ 必須</span></label></dt>
      <dd><input type="text" name="ad" id="ad" value="<?php echo $_SESSION["ad"] ?>"></dd>
      <dt><label for="tel">電話番号</label></dt>
      <dd><input type="text" name="tel" id="tel" value="<?php echo $_SESSION["tel"] ?>"></dd>
      <dt><label for="site">サイト名</label></dt>
      <dd><input type="text" name="site" id="site" value="<?php echo $_SESSION["site"] ?>"></dd>
      <dt><label for="url">サイトURL</label></dt>
      <dd><input type="text" name="url" id="url" value="<?php echo $_SESSION["url"] ?>"></dd>
<!--
      <dt><label for=""></label></dt>
      <dd><input type="text" name="" id=""></dd>
-->
    </dl>
<!--    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="addfile"></p><br>-->
    <p><input type="submit" value="送信"></p>
  </form>



<!--
#### DB_addAccess  
//> id             : int(10)      : ID  
//> date           : datetime     : 日付  
//> site_name      : varchar(255) : サイト名  
//> site_comment   : text         : サイト紹介  
//  
//> ad_id          : int(11)      : 郵便番号  
//> ad             : varchar(255) : 住所  
//  
//> tel            : int(11)      : 電話番号  
//> site           : varchar(255) : サイト名  
//> url            : varchar(255)   : サイトURL  
-->





<?php
}elseif($flag==2){
?>
<main id="heightAdmin">
  <h2>【サイト紹介】</h2>
  <p>送信が完了しました</p>
  <p><input class="redButton" type="button" onclick="location.href='./site.php'" value="戻る"></p>
<?php
}else{
?>
<main id="heightAdmin">
  <h2>【Error】</h2>
  <p><input class="redButton" type="button" onclick="location.href='./site.php'" value="戻る"></p>
<?php
}
?>
</main>

  <?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

