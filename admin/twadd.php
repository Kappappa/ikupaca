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

// text確認 && 初期化
$id="";
$time= (!empty($_POST["time"])) ? $m->h($_POST["time"]) : "";
$title= (!empty($_POST["title"])) ? $m->h($_POST["title"]) : "";
$text= (!empty($_POST["text"])) ? $m->h($_POST["text"]) : "";
$timeCheck= (!empty($_POST["timeCheck"])) ? $m->h($_POST["timeCheck"]) : "";
$titleCheck= (!empty($_POST["titleCheck"])) ? $m->h($_POST["titleCheck"]) : "";
$textCheck= (!empty($_POST["textCheck"])) ? $m->h($_POST["textCheck"]) : "";
$_SESSION["id"]= (!empty($_SESSION["id"])) ? $m->h($_SESSION["id"]) : "";
$_SESSION["pass"]= (!empty($_SESSION["pass"])) ? $m->h($_SESSION["pass"]) : "";
$_SESSION["time"]= (!empty($_SESSION["time"])) ? $m->h($_SESSION["time"]) : "";
$_SESSION["title"]= (!empty($_SESSION["title"])) ? $m->h($_SESSION["title"]) : "";
$_SESSION["text"]= (!empty($_SESSION["text"])) ? $m->h($_SESSION["text"]) : "";
$_SESSION["imageid"]= (!empty($_SESSION["imageid"])) ? $m->h($_SESSION["imageid"]) : "";
$imageid= (!empty($_POST["imageid"])) ? $m->h($_POST["imageid"]) : "";

// $flag( 1:投稿画面 2:投稿チェック画面 3:送信完了及び画像添付画面 4:画像送信完了画面)
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
if($time != "" && $title != "" && $text != "")
{
//  print "OK";
  $_SESSION["time"]= $time;
  $_SESSION["title"]= $title;
  $_SESSION["text"]= $text;
  $flag=2;
}
if($timeCheck != "" && $titleCheck != "" && $textCheck != "")
{
//  print "OK";
//INSERT
  $next= $DB -> twInsert($timeCheck, $titleCheck, $textCheck);
  $id= $DB -> imageId($timeCheck);
  $_SESSION["imageid"]=intval($id);
  $_SESSION["time"]= "";
  $_SESSION["title"]= "";
  $_SESSION["text"]= "";
  $flag=3;
}

// 画像投稿チェック
/* アップロードがあったとき */
if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && !empty($imageid)) {
    // バッファリングを開始
    ob_start();
    try {
        // $_FILES['upfile']['error'] の値を確認
        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK: // OK
                break;
            case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                throw new RuntimeException('ファイルが選択されていません', 400);
            case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
            case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
                throw new RuntimeException('ファイルサイズが大きすぎます', 400);
            default:
                throw new RuntimeException('その他のエラーが発生しました', 500);
        }
        // $_FILES['upfile']['mime']の値はブラウザ側で偽装可能なので
        // MIMEタイプを自前でチェックする
        if (!$info = @getimagesize($_FILES['upfile']['tmp_name'])) {	//	画像サイズを取得
            throw new RuntimeException('有効な画像ファイルを指定してください', 400);
        }
        if (!in_array($info[2], [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
            throw new RuntimeException('未対応の画像形式です', 400);
        }
        // サムネイルをバッファに出力
        $create = str_replace('/', 'createfrom', $info['mime']);
        $output = str_replace('/', '', $info['mime']);
        if ($info[0] >= $info[1]) {
            $dst_w = 120;
            $dst_h = ceil(120 * $info[1] / max($info[0], 1));
        } else {
            $dst_w = ceil(120 * $info[0] / max($info[1], 1));
            $dst_h = 120;
        }
        if (!$src = @$create($_FILES['upfile']['tmp_name'])) {
            throw new RuntimeException('画像リソースの生成に失敗しました', 500);
        }
        $dst = imagecreatetruecolor($dst_w, $dst_h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $dst_w, $dst_h, $info[0], $info[1]);
        $output($dst);
        imagedestroy($src);
        imagedestroy($dst);
 
// Transaction
        try {
          $pdo->beginTransaction();
          // UPDATE
        $stmtImg = $pdo->prepare('UPDATE tw SET name = ? , type = ? , raw_data = ? , thumb_data = ? WHERE id = ? ;');
        $stmtImg->execute([
          $_FILES['upfile']['name'],
          $info[2],
          file_get_contents($_FILES['upfile']['tmp_name']),
          ob_get_clean(), // buffer_clear
          $imageid
        ]);
// Commit
            $pdo->commit();
// 送信完了フラグ
            $flag=4;
          } catch (Exception $e) {
// Rollback
            $pdo->rollBack();
            echo "失敗しました。1" . $e->getMessage();
          }
      
        } catch (RuntimeException $e) {
          while (ob_get_level()) {
          ob_end_clean(); // バッファをクリア
            }
          echo "失敗しました。2" . $e->getMessage();
    //        http_response_code($e instanceof PDOException ? 500 : $e->getCode());
    //            $msgs[] = ['red', $e->getMessage()];
        }
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
      <li><a href="./tw.php">つぶやき編集</a></li>
      <li class="now"><a href="./twadd.php">つぶやき追加</a></li>
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
<main id="heightAdmin">
  <h2>【つぶやき追加】</h2>
  <form action="" method="post">
    <dl>
     <dt><label for="timeAdmin">投稿時間</label></dt>
     <dd><input type="text" id="timeAdmin" name="time" value="<?php echo date('Y/m/d H:i:s'); ?>"></dd>
      <dt><label for="titleAdmin">【タイトル】</label></dt>
      <dd><input type="text" id="titleAdmin" name="title" value="<?php echo $_SESSION["title"]; ?>"></dd>
      <dt><label for="textAdmin">【内容】</label></dt>
      <dd><textarea rows="10" id="textAdmin" name="text"><?php echo $_SESSION["text"]; ?></textarea></dd>
    </dl>
    <p><input type="submit" value="確認"></p>
  </form>
<?php
}elseif($flag==2){
?>
<main id="heightAdmin">
  <h2>【つぶやき】</h2>
   <form action="" method="post">
    <dl>
     <dt>投稿時間</dt>
     <dd><?php echo $_SESSION["time"]; ?></dd>
      <dt>【タイトル】</dt>
      <dd><?php echo $_SESSION["title"]; ?></dd>
      <dt>【内容】</dt>
      <dd><?php echo nl2br($_SESSION["text"]); ?></dd>
    </dl>
    <p><input type="submit" value="送信"></p><br>
    <p><input class="redButton" type="button" onclick="location.href='./text.php'" value="戻る"></p>
     <dl>
      <dd><input type="hidden" id="timeCheck" name="timeCheck" value="<?php echo $_SESSION["time"]; ?>"></dd>
      <dd><input type="hidden" id="titleCheck" name="titleCheck" value="<?php echo $_SESSION["title"]; ?>"></dd>
      <dd><input type="hidden" name="textCheck" id="textCheck" value="<?php echo $_SESSION["text"]; ?>"></dd>
    </dl>
  </form>

<?php
}elseif($flag==3){
?>
<main id="heightAdmin">
  <h2>【つぶやき】</h2>
  <p>送信しました。</p>

  <form enctype="multipart/form-data" action="" method="post">
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="upfile"></p><br>
    <p><input type="hidden" name="imageid" value="<?php echo $_SESSION["imageid"] ?>"></p>
    <p><input type="submit" value="送信"></p><br>
    <p><input class="redButton" type="button" onclick="location.href='./tw.php'" value="戻る"></p>
  </form>
  

<?php
}elseif($flag==4){
?>
<main id="heightAdmin">
  <h2>【つぶやき】</h2>
  <p>画像を送信しました。</p><br>
  <p><input class="redButton" type="button" onclick="location.href='./tw.php'" value="戻る"></p>
  
<?php
}else{
?>
<main id="heightAdmin">
  <h2>【Error】</h2>
  <p><input class="redButton" type="button" onclick="location.href='./tw.php'" value="戻る"></p>

<?php
}
?>
</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

