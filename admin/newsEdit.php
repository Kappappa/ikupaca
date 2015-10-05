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

//+------------------------------------------
//	ページング
define("DATA_PER_PAGE",5);
//+------------------------------------------
//	ページング設定(初期化)
if(empty($_GET["p"]) || $_GET["p"]<=0){
	$p=1;
}else{
	$p=intval($_GET["p"]);
}
//	最終ページを求める(表示件数)
$lastPage= $DB -> paging(DATA_PER_PAGE, "News");
if($p>$lastPage) $p=$lastPage;

// $flag( 1:一覧表示 2:編集画面 3:編集チェック画面 4:編集送信完了通知画面 5:削除)
$flag=0;

//管理者チェック
if($_SESSION["id"]==ADMIN && $_SESSION["pass"]==PASS){
  $flag=1;
}else{
//管理者でなければセッション破棄
  header("Location: ../index.php");
  exit();
}
// ページ確認
$edit= (!empty($_GET["edit"])) ? $m->h($_GET["edit"]) : "";
$_SESSION["edit"]= "";
// 編集チェック
if($edit != "")
{
//  print "OK";
  $_SESSION["edit"]= $edit;
  $flag=2;
}



// 編集データチェック(初期化)
$id= (!empty($_POST["edit"])) ? $m->h($_POST["edit"]) : "";
$time= (!empty($_POST["news_create_time"])) ? $m->h($_POST["news_create_time"]) : "";
$title= (!empty($_POST["news_title"])) ? $m->h($_POST["news_title"]) : "";
$news= (!empty($_POST["news"])) ? $m->h($_POST["news"]) : "";
$editIdCheck= (!empty($_POST["editId"])) ? $m->h($_POST["editId"]) : "";
$timeCheck= (!empty($_POST["timeCheck"])) ? $m->h($_POST["timeCheck"]) : "";
$titleCheck= (!empty($_POST["titleCheck"])) ? $m->h($_POST["titleCheck"]) : "";
$newsCheck= (!empty($_POST["newsCheck"])) ? $m->h($_POST["newsCheck"]) : "";
$editDelete= (!empty($_POST["editDelete"])) ? $m->h($_POST["editDelete"]) : "";
$_SESSION["editId"]= "";

if(!empty($id) && !empty($time) && !empty($title) && !empty($news)){
  $flag=3;
  $_SESSION["editId"]= $id;
}

// データ上書き
if(!empty($editIdCheck) && !empty($timeCheck) && !empty($titleCheck) && !empty($newsCheck)){
  $flag=4;
  $DB -> newsUpdate($editIdCheck, $timeCheck, $titleCheck, $newsCheck);
}

// データ削除
if(!empty($editDelete)){
  $flag=5;
  $DB -> newsDelete($editDelete);
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
      <li class="now"><a href="">新着情報編集</a></li>
      <li><a href="./twadd.php">つぶやき追加</a></li>
      <li><a href="./twEdit.php">つぶやき編集</a></li>
      <li><a href="./image.php">画像保存</a></li>
      <li><a href="./imageAll.php">画像一覧</a></li>
      <li class=""><a href="./imageTop.php">トップ画像一覧</a></li>
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
  <h2>【新着情報編集】</h2>

  <p style="text-align:right;">
		<a href="newsEdit.php?p=<?php echo $p-1 ?>">前のページ</a> | <a href="newsEdit.php?p=<?php echo $p+1 ?>">次のページ</a>
	</p>
  <div id="newsAdmin">
<?php
// newsデータチェック
//  $DB -> newsAllEdit($page,DATA_PER_PAGE);

  //新着情報取得(3件)
  $page=($p-1)*DATA_PER_PAGE;
  $sql_news= sprintf('SELECT * FROM News order by news_create_time desc LIMIT %d, %d ;',$page,DATA_PER_PAGE);
  $res_news=  $pdo -> query($sql_news);
  while($row= $res_news -> fetch(PDO::FETCH_ASSOC)) {
    $news_id = $row["news_id"];
    $news_create_time = $row["news_create_time"];
    $news_title = $row["news_title"]; 
    $news_text = nl2br($row["news_text"]); 
//   ヒアドキュメントで表示
echo <<<EOS
        <hr class="newsHr">
        <p class="newsAdminTime">$news_create_time</p>
        <p class="newsAdminTitle">[$news_title]</p>
        <p class="newsAdminText">$news_text</p>
        <form action="" method="get">
          <input type="hidden" name="edit" id="edit" value="$news_id">
          <input type="submit" value="編集">
        </form>

EOS;
  }
?>
  </div>

<?php


}elseif($flag==2){
?>
<main id="">
  <h2>【新着情報編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./newsEdit.php'" value="戻る"></p>
<?php
$DB -> newsEdit($edit);
?>
  </div>
<?php


}elseif($flag==3){
  $_SESSION["editId"]= intval($id);
?>

<main id="">
  <h2>【新着情報編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./newsEdit.php?edit=<?php echo $id; ?>'" value="戻る"></p>
  <form action="./newsEdit.php" method="post">
    <dl>
     <dt>投稿時間</dt>
     <dd><?php echo $time; ?></dd>
      <dt>【タイトル】</dt>
      <dd><?php echo $title; ?></dd>
      <dt>【内容】</dt>
      <dd><?php echo nl2br($news); ?></dd>
    </dl>
    <p><input type="submit" value="更新"></p>
     <dl>
      <dd><input type="hidden" id="editId" name="editId" value="<?php echo $_SESSION["editId"]; ?>"></dd>
      <dd><input type="hidden" id="timeCheck" name="timeCheck" value="<?php echo $time; ?>"></dd>
      <dd><input type="hidden" id="titleCheck" name="titleCheck" value="<?php echo $title; ?>"></dd>
      <dd><input type="hidden" name="newsCheck" id="newsCheck" value="<?php echo $news; ?>"></dd>
    </dl>
  </form>
  </div>
<?php


}elseif($flag==4){
?>
<main id="heightAdmin">
  <h2>【新着情報編集】</h2>
  <div id="newsAdmin">
  <p>編集が完了しました。</p>
  <p><input class="redButton" type="button" onclick="location.href='./newsEdit.php'" value="戻る"></p>
  </div>
<?php


}elseif($flag==5){
?>
<main id="heightAdmin">
  <h2>【新着情報編集】</h2>
  <div id="newsAdmin">
  <p>削除しました。</p>
  <p><input class="redButton" type="button" onclick="location.href='./newsEdit.php'" value="戻る"></p>
  </div>
<?php
}else{
  
}
?>
</main>
<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

