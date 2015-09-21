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

//管理ID,パスワード確認 && 初期化
$id= (!empty($_POST["adminid"])) ? $m->h($_POST["adminid"]) : "";
$pass= (!empty($_POST["pass"])) ? $m->h($_POST["pass"]) : "";
$_SESSION["id"]= (!empty($_SESSION["id"])) ? $m->h($_SESSION["id"]) : $id;
$_SESSION["pass"]= (!empty($_SESSION["pass"])) ? $m->h($_SESSION["pass"]) : $pass;
$flag=0;

//管理者チェック
if($id==ADMIN && $pass==PASS){
  $flag=1;
  $_SESSION["id"]=$id;
  $_SESSION["pass"]=$pass;
}else{
//管理者でなければセッション破棄

}

// ユーザーのセッションとクッキー
if(!empty($_POST["adminid"]))
{
  setcookie("adminid",$_POST["adminid"],time()+60*60*24*14);
}
if(!empty($_POST["pass"]))
{
  setcookie("pass",htmlspecialchars($_POST["pass"],ENT_QUOTES),time()+60*60*24*14);
}


$adminidCookie= (!empty($_COOKIE["adminid"])) ? $_COOKIE["adminid"] :"";
$passCookie= (!empty($_COOKIE["pass"])) ? $_COOKIE["pass"] :"";

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
      <li class="now"><a href="">ログイン画面</a></li><?php if($flag==1){ ?>
      <li><a href="./news.php">新着情報追加</a></li>
      <li><a href="./newsEdit.php">新着情報編集</a></li>
      <li><a href="./twadd.php">つぶやき追加</a></li>
      <li><a href="./twEdit.php">つぶやき編集</a></li>
      <li><a href="./image.php">画像保存</a></li>
      <li><a href="./imageAll.php">画像一覧</a></li>
<!--      <li><a href="../inc/pdo/create_table.php">新着情報DB作成</a></li>-->
<!--      <li><a href="../inc/pdo/delete_table.php">新着情報DB削除</a></li>-->
<!--      <li><a href="../inc/pdo/create_image_table.php">imageDB作成</a></li>-->
<!--      <li><a href="../inc/pdo/delete_image_table.php">imageDB削除</a></li>-->
<!--      <li><a href="../inc/pdo/create_tw_table.php">つぶやきDB作成</a></li>-->
<!--      <li><a href="../inc/pdo/delete_tw_table.php">つぶやきDB削除</a></li>-->
      <?php } ?>
      <li><a href="../index.php">Home</a></li>
    </ul>
    </div>
    <hr>
    
</header>
<!-- header class="header" -->

<main id="heightAdmin">
<?php if($flag==0){ ?>
  <form action="" method="post">
    <dl>
      <dt><label for="adminid">【管理ID】</label></dt>
      <dd><input type="text" id="adminid" name="adminid" value="<?php echo $adminidCookie ?>"></dd>
      <dt><label for="pass">【パスワード】</label></dt>
      <dd><input type="password" id="pass" name="pass" value="<?php echo $passCookie ?>"></dd>
    </dl>
    <p><input type="submit" value="送信"></p>
  </form>

<?php }elseif($flag==1){ ?>

<h2>【管理画面】</h2>
<p>新着情報の追加は<a href="./news.php">[新着情報追加]</a>へ。</p>
<p>新着情報の編集は<a href="./newsEdit.php">[新着情報編集]</a>へ。</p>
<p>画像の登録は<a href="./image.php">[画像登録]</a>へ。</p>
<p>画像の一覧は<a href="./imageAll.php">[画像一覧]</a>へ。</p>






<?php } ?>

</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>