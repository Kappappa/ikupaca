<?php
session_start();
ini_set( 'display_errors', 1);

// PDO接続
include_once("../inc/config.php");
include_once("../inc/pdoClass.php");
$DB = new DB();

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

// Class
//include_once("../inc/MHClass.php");
//  $m = new MHClass;
// POSTデータチェック
//  $m -> po();
// SESSIONデータチェック
//  $m -> se();
// サニタイズ
//  $m -> h($str);

// 画像投稿チェック
/* アップロードがあったとき */
if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error'])) {
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

            // INSERT処理
            $stmtImg = $pdo->prepare('INSERT INTO imageTable(name,type,raw_data,thumb_data,date) VALUES(?,?,?,?,?)');
            $stmtImg->execute([
                $_FILES['upfile']['name'],
                $info[2],
                file_get_contents($_FILES['upfile']['tmp_name']),
                ob_get_clean(), // バッファからデータを取得してクリア
                (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('Y-m-d H:i:s')	// NOW()で代用可能か？
            ]);
          
//            $msgs[] = ['green', 'ファイルは正常にアップロードされました'];
// Commit
            $pdo->commit();
// 送信完了フラグ
            $flag=2;
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


// 画像投稿チェック
/* アップロードがあったとき */
if (isset($_FILES['topfile']['error']) && is_int($_FILES['topfile']['error'])) {
  $table= 'topImage';
  $file= $_FILES['topfile'];
  $flag= $DB -> topImageInsert($table,$file);
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
      <li class="now"><a href="./image.php">画像保存</a></li>
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
<main id="heightAdmin">
  <h2>【一般画像追加】</h2>
  <form enctype="multipart/form-data" action="" method="post">
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="upfile"></p><br>
    <p><input type="submit" value="送信"></p>
  </form>
<hr>
  <h2>【トップ画像追加】</h2>
  <p><input class="blueButton" type="button" onclick="location.href='./imageTop.php'" value="トップ画像一覧"></p>
  <form enctype="multipart/form-data" action="" method="post">
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="topfile"></p><br>
    <p><input type="submit" value="送信"></p>
  </form>
  
<?php
}elseif($flag==2){
?>
<main id="heightAdmin">
  <h2>【画像追加】</h2>
  <p>送信が完了しました</p>
  <p><input class="redButton" type="button" onclick="location.href='./image.php'" value="戻る"></p>
<?php
}else{
?>
<main id="heightAdmin">
  <h2>【Error】</h2>
  <p><input class="redButton" type="button" onclick="location.href='./image.php'" value="戻る"></p>
<?php
}
?>
</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

