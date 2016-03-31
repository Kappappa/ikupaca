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

$edit_id= (!empty($_POST["edit"])) ? intval($_POST["edit"]) : "";
//print $edit_id;
if(!empty($edit_id)){
  $flag= 2;
}

// 初期化
$table= 'addTable';



// 画像投稿チェック
/* アップロードがあったとき */
//if (isset($_FILES['addfile']['error']) && is_int($_FILES['addfile']['error'])) {
//  $file= $_FILES['addfile'];
////  $flag= $DB -> ImageInsert($table,$file);
//}










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
      <li><a href="./site.php">サイト紹介</a></li>
      <li class="now"><a href="./siteAll.php">サイト一覧</a></li>
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

<?php
  $DB -> addSelect();
?>

<!--
  <form enctype="multipart/form-data" action="" method="post">
    <dl>
    <dt>test</dt>
      <dt><label for=""></label></dt>
      <dd><input type="text" name="" id=""></dd>
    </dl>
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="addfile"></p><br>
    <p><input type="submit" value="送信"></p>
  </form>
-->

<?php
}elseif($flag==2){
  $DB -> addEdit($edit_id);
?>



<?php
}elseif($flag==3){
?>
<main id="heightAdmin">
  <h2>【サイト紹介】</h2>
  <p>送信が完了しました</p>
  <p><input class="redButton" type="button" onclick="location.href='./siteAll.php'" value="戻る"></p>
<?php
}else{
?>
<main id="heightAdmin">
  <h2>【Error】</h2>
  <p><input class="redButton" type="button" onclick="location.href='./siteAll.php'" value="戻る"></p>
<?php
}
?>
</main>

  <?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

