<?php
session_start();
ini_set( 'display_errors', 1);

// 1ページ当たりの表示数
//define("PAGING",10);

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
//$p= (empty($_GET["p"]) || $_GET["p"]<=0) ? 1 : intval($_GET["p"]);
////	最終ページを求める
//$sqlp= $pdo -> query("SELECT COUNT(*) AS n FROM topImage;");
//$rowp= $sqlp -> fetch(PDO::FETCH_ASSOC);
//$lastPage= ceil($rowp["n"]/PAGING);
//if($p>$lastPage) $p=$lastPage;
//// $ps:ページの最初
//$ps=($p-1)*PAGING;

// 表示用画像
$id=0;
if (isset($_GET['id'])) {
//  ここで OFF->ON 表示切り替え
  $id=intval($_GET["id"]);
  $sqlCheck=$pdo ->prepare("SELECT * FROM topImage WHERE id= ".$id." and flag=0;");
  $sqlCheck->execute();
  while($row = $sqlCheck -> fetch(PDO::FETCH_ASSOC)){
    if($row){
//      print "OK";
//      ここでONに！
      $DB->topImageOn(intval($row["id"]),"1");
    }else{
//      print "NG";
    }
  }
}
if (isset($_GET['idOff'])) {
//  ここで ON->OFF 表示切り替え
  $id=intval($_GET["idOff"]);
  $sqlCheck=$pdo ->prepare("SELECT * FROM topImage WHERE id= ".$id." and flag=1;");
  $sqlCheck->execute();
  while($row = $sqlCheck -> fetch(PDO::FETCH_ASSOC)){
    if($row){
//      print "OK";
//      ここでONに！
      $DB->topImageOn(intval($row["id"]),"0");
    }else{
//      print "NG";
    }
  }
}

$del_id="";
// 削除
if (isset($_POST['del'])) {
  $del_id= intval($_POST['del']);
  $sqlCheck=$pdo ->prepare("SELECT * FROM topImage WHERE id= ".$del_id." and flag=0;");
  $sqlCheck->execute();
  while($row = $sqlCheck -> fetch(PDO::FETCH_ASSOC)){
    if($row){
      $DB->topImageDelete(intval($row["id"]));
    }
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
      <li class=""><a href="./imageAll.php">画像一覧</a></li>
      <li class="now"><a href="./imageTop.php">トップ画像一覧</a></li>
    </ul>
    </div>
    <hr>
    
</header>
<!-- header class="header" -->
<?php

//はーい、分岐ですよ〜
if($flag==1){
?>
<!--<main id="heightAdmin">-->
<main>
  <h2>【トップ画像一覧】</h2>
<!--  <p style="text-align:right;">-->
  <?php
//  if(empty($_GET["p"]) || $_GET["p"]<=1){
//  echo '<a href="imageAll.php?p='.($p+1).'">次のページ</a>';
//  }else{
//  echo '<a href="imageAll.php?p='.($p-1).'">前のページ</a> | <a href="imageAll.php?p='.($p+1).'">次のページ</a>';
//  }
  ?>
<!--  </p>-->
  <p>画像をタッチでON⇄OFF切り替えします。</p>
  <p>画像の削除はOFFの時だけです。</p>
  <hr>
  <p>
  【ON】<br>
<?php
  // ON画像があればココに表示
  $sqlImg=$pdo ->prepare("SELECT * FROM topImage WHERE flag=1 ORDER BY id DESC");
//  $sqlImg->bindValue(':ps', $ps, PDO::PARAM_INT);
//  $sqlImg->bindValue(':pe', PAGING, PDO::PARAM_INT);
  $sqlImg->execute();
  while($rowImg = $sqlImg -> fetch(PDO::FETCH_ASSOC)){
    if($rowImg){
      $img=	sprintf(
           '<a href="?idOff=%d"><img width="100" src="data:%s;base64,%s" alt="%s" /> </a>',
           $rowImg['id'],
           image_type_to_mime_type($rowImg['type']),	//	画像タイプ取得
           base64_encode($rowImg['thumb_data']),	//	画像データをbase64 方式によりエンコード
           $m ->h ($rowImg['name'])
        );
      print '<span>'.$img."</span>".PHP_EOL;
    }else{
      print "No_Image";
    }
  }

?>
</p>
<hr>
  <p>【OFF】</p>
<?php
  // OFF画像があればココに表示
//  $sqlImg=$pdo ->prepare("SELECT * FROM topImage ORDER BY id DESC LIMIT :ps , :pe ;");
  $sqlImg=$pdo ->prepare("SELECT * FROM topImage WHERE flag=0 ORDER BY id DESC;");
//  $sqlImg->bindValue(':ps', $ps, PDO::PARAM_INT);
//  $sqlImg->bindValue(':pe', PAGING, PDO::PARAM_INT);
  $sqlImg->execute();
  while($rowImg = $sqlImg -> fetch(PDO::FETCH_ASSOC)){
    if($rowImg){
      $img=	sprintf(
           '<a href="?id=%d"><img width="100" src="data:%s;base64,%s" alt="%s" /> </a>',
          $rowImg['id'],
          image_type_to_mime_type($rowImg['type']),	//	画像タイプ取得
          base64_encode($rowImg['thumb_data']),	//	画像データをbase64 方式によりエンコード
          $m ->h ($rowImg['name'])
        );
      $del= sprintf('
           <form action="" method="post">
           <input type="hidden" name="del" id="del" value=%d>
           <input class="redButton" type="submit" value="削除">
           </form>',
          $rowImg['id']
                   );
                    
      print '<p><span>'.$img."</span></p>".PHP_EOL.$del.PHP_EOL."<hr><br>".PHP_EOL;
    }else{
      print "No_Image";
    }
  }
  
}
?>

</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

