<?php
session_start();
ini_set( 'display_errors', 1);

// 1ページ当たりの表示数
define("PAGING",10);

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

//	ページング設定
$p= (empty($_GET["p"]) || $_GET["p"]<=0) ? 1 : intval($_GET["p"]);
//	最終ページを求める
$sqlp= $pdo -> query("SELECT COUNT(*) AS n FROM imageTable;");
$rowp= $sqlp -> fetch(PDO::FETCH_ASSOC);
$lastPage= ceil($rowp["n"]/PAGING);
if($p>$lastPage) $p=$lastPage;
// $ps:ページの最初
$ps=($p-1)*PAGING;

// 表示用画像
if (isset($_GET['id'])) {
	try {
			$stmt = $pdo->prepare('SELECT type, raw_data FROM imageTable WHERE id = ? LIMIT 1');
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

// $flag( 1:一覧表示画面)
$flag=0;

//管理者チェック
if($_SESSION["id"]==ADMIN && $_SESSION["pass"]==PASS){
  $flag=1;
}else{
//管理者でなければセッション破棄
  header("Location: ../index.php");
  exit();
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
      <li><a href="./image.php">画像保存</a></li>
      <li class="now"><a href="./imageAll.php">画像一覧</a></li>
    </ul>
    </div>
    <hr>
    
</header>
<!-- header class="header" -->
<?php

//はーい、分岐ですよ〜
if($flag==1){
?>
<main id="heightAdmin">
  <h2>【画像一覧】</h2>
  <p style="text-align:right;">
  <?php
  if(empty($_GET["p"]) || $_GET["p"]<=1){
  echo '<a href="imageAll.php?p='.($p+1).'">次のページ</a>';
  }else{
  echo '<a href="imageAll.php?p='.($p-1).'">前のページ</a> | <a href="imageAll.php?p='.($p+1).'">次のページ</a>';
  }
  ?>
  </p>
  <p id="imageP">
<?php
  // 画像があればココに表示
  $sqlImg=$pdo ->prepare("SELECT * FROM imageTable ORDER BY id DESC LIMIT :ps , :pe ;");
  $sqlImg->bindValue(':ps', $ps, PDO::PARAM_INT);
  $sqlImg->bindValue(':pe', PAGING, PDO::PARAM_INT);
  $sqlImg->execute();
  while($rowImg = $sqlImg -> fetch(PDO::FETCH_ASSOC)){
    if($rowImg){
      $img=	sprintf(
           '<a href="?id=%d" target="_blank"><img width="80" src="data:%s;base64,%s" alt="%s" /> </a>',
           $rowImg['id'],
           image_type_to_mime_type($rowImg['type']),	//	画像タイプ取得
           base64_encode($rowImg['thumb_data']),	//	画像データをbase64 方式によりエンコード
           $m ->h ($rowImg['name'])
        );
      print '<span>'.$img."</span>";
    }else{
      print "No_Image";
    }
  }
  
}
?>
  </p>

</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

