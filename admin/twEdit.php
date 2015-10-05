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
$lastPage= $DB -> paging(DATA_PER_PAGE, "tw");
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

$self= $_SERVER['PHP_SELF']; // このファイル名
$table_name= 'tw'; // 使用テーブル名を指定

$id= (!empty($_POST["edit"])) ? $m->h($_POST["edit"]) : "";
$edit_image= (!empty($_POST["edit_image"])) ? $m->h($_POST["edit_image"]) : "";
$edit_imageAdd= (!empty($_POST["edit_imageAdd"])) ? $m->h($_POST["edit_imageAdd"]) : "";
$imageDelete= (!empty($_POST["imageDelete"])) ? $m->h($_POST["imageDelete"]) : "";

$time= (!empty($_POST["time"])) ? $m->h($_POST["time"]) : "";
$title= (!empty($_POST["title"])) ? $m->h($_POST["title"]) : "";
$text= (!empty($_POST["text"])) ? $m->h($_POST["text"]) : "";

$editIdCheck= (!empty($_POST["editId"])) ? $m->h($_POST["editId"]) : "";
$timeCheck= (!empty($_POST["timeCheck"])) ? $m->h($_POST["timeCheck"]) : "";
$titleCheck= (!empty($_POST["titleCheck"])) ? $m->h($_POST["titleCheck"]) : "";
$textCheck= (!empty($_POST["textCheck"])) ? $m->h($_POST["textCheck"]) : "";

$editDelete= (!empty($_POST["editDelete"])) ? $m->h($_POST["editDelete"]) : "";
$_SESSION["editId"]= "";

// 画像…
$imageid= (!empty($_POST["imageid"])) ? $m->h($_POST["imageid"]) : "";
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



if(!empty($id) && !empty($time) && !empty($title) && !empty($text)){
  $flag=3;
  $_SESSION["editId"]= $id;
}

// データ上書き
if(!empty($editIdCheck) && !empty($timeCheck) && !empty($titleCheck) && !empty($textCheck)){
  $flag=4;
  $DB -> editUpdate($editIdCheck, $timeCheck, $titleCheck, $textCheck,$table_name);
}

// データ削除
if(!empty($editDelete)){
  $flag=5;
  $DB -> editDelete($editDelete,$table_name);
}

// 画像編集
if(!empty($edit_image)){
  $flag=6;
}

// 画像追加
if(!empty($edit_imageAdd)){
  $flag=7;
}

// 画像削除
if(!empty($imageDelete)){
  $flag=5;
  $DB -> imageDelete($imageDelete,$table_name);
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
      <li class="now"><a href="./twEdit.php">つぶやき編集</a></li>
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
  <h2>【つぶやき編集】</h2>

  <p style="text-align:right;">
		<a href="twEdit.php?p=<?php echo $p-1 ?>">前のページ</a> | <a href="twEdit.php?p=<?php echo $p+1 ?>">次のページ</a>
	</p>
  <div id="newsAdmin">
<?php
// newsデータチェック
//  $DB -> newsAllEdit($page,DATA_PER_PAGE);

  // 情報取得
  $page=($p-1)*DATA_PER_PAGE;
  $sql= sprintf('SELECT * FROM tw order by time desc LIMIT %d, %d ;',$page,DATA_PER_PAGE);
  $res=  $pdo -> query($sql);
  while($row= $res -> fetch(PDO::FETCH_ASSOC)) {
    $sql_id = $row["id"];
    $sql_time = $row["time"];
    $sql_title = $row["title"];
    $sql_text = nl2br($row["text"]);

  if(!empty($row["name"])){
    $edit_image_name = $row["name"];
    $edit_imageType = image_type_to_mime_type($row["type"]);
    $edit_image_thumb_data = base64_encode($row["thumb_data"]);
    
    $img=	sprintf('<dd><img width="100" src="data:%s;base64,%s" alt="%s" ></dd>',
      $edit_imageType,	//	画像タイプ取得
      $edit_image_thumb_data,	//	画像データをbase64 方式によりエンコード
      $row['name']
    );
    
    $imgEdit=	sprintf('<form action="" method="post">
<dl>
<input type="hidden" name="edit_image" id="edit_image" value="%d">
<dd><input type="submit" value="画像編集"></dd>
</dl>
</form>',$sql_id);
    
  }else{
    $img= "";
    $imgEdit= 	sprintf('<form action="" method="post">
<dl>
<input type="hidden" name="edit_imageAdd" id="edit_imageAdd" value="%d">
<dd><input type="submit" value="画像追加"></dd>
</dl>
</form>',$sql_id);
  }

//   ヒアドキュメントで表示
echo <<<EOS
<hr class="">
<dl>
<dd class="newsAdminTime">$sql_time</dd>
<dd class="newsAdminTitle">[$sql_title]</dd>
<dd class="newsAdminText">$sql_text</dd>
$img
</dl>
<form action="" method="get">
<dl>
<input type="hidden" name="edit" id="edit" value="$sql_id">
<dd><input type="submit" value="編集"></dd>
</dl>
</form>
$imgEdit
EOS;
  }
?>
  </div>

<?php


}elseif($flag==2){
?>
<main id="">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php'" value="戻る"></p>
<?php
$DB -> twEdit($edit,$table_name,$self);
?>
  </div>
<?php


}elseif($flag==3){
  $_SESSION["editId"]= intval($id);
?>

<main id="">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php?edit=<?php echo $id; ?>'" value="戻る"></p>
  <form action="./twEdit.php" method="post">
    <dl>
     <dt>投稿時間</dt>
     <dd><?php echo $time; ?></dd>
      <dt>【タイトル】</dt>
      <dd><?php echo $title; ?></dd>
      <dt>【内容】</dt>
      <dd><?php echo nl2br($text); ?></dd>
    </dl>
    <p><input type="submit" value="更新"></p>
     <dl>
      <dd><input type="hidden" id="editId" name="editId" value="<?php echo $_SESSION["editId"]; ?>"></dd>
      <dd><input type="hidden" id="timeCheck" name="timeCheck" value="<?php echo $time; ?>"></dd>
      <dd><input type="hidden" id="titleCheck" name="titleCheck" value="<?php echo $title; ?>"></dd>
      <dd><input type="hidden" name="textCheck" id="textCheck" value="<?php echo $text; ?>"></dd>
    </dl>
  </form>
  </div>
<?php


}elseif($flag==4){
?>
<main id="heightAdmin">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p>編集が完了しました。</p>
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php'" value="戻る"></p>
  </div>
<?php


}elseif($flag==5){
?>
<main id="heightAdmin">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p>削除しました。</p>
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php'" value="戻る"></p>
  </div>
<?php


}elseif($flag==6){

  $sql= sprintf('SELECT * FROM tw WHERE id= %d ;',$edit_image);
  $res=  $pdo -> query($sql);
  while($row= $res -> fetch(PDO::FETCH_ASSOC)) {
    $sql_id = $row["id"];
    $sql_time = $row["time"];
    $sql_title = $row["title"];
    $sql_text = nl2br($row["text"]);

    if(!empty($row["name"])){
      $edit_image_name = $row["name"];
      $edit_imageType = image_type_to_mime_type($row["type"]);
      $edit_image_thumb_data = base64_encode($row["thumb_data"]);

      $img=	sprintf('<p><img width="100" src="data:%s;base64,%s" alt="%s" ></p>',
        $edit_imageType,	//	画像タイプ取得
        $edit_image_thumb_data,	//	画像データをbase64 方式によりエンコード
        $row['name']
      );
    }else{
      header("Location: ../index.php");
      exit();
    }
  }


?>
<main id="">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php'" value="戻る"></p>
  </div>
    <dl>
      <dd>画像編集</dd>
      <dd><?php echo $img; ?></dd>
  </dl>

  <form enctype="multipart/form-data" action="" method="post">
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="upfile"></p><br>
    <p><input type="hidden" name="imageid" value="<?php echo $edit_image ?>"></p>
    <p><input type="submit" value="変更"></p><br>
  </form>

  <form action="" method="post">
    <dl>
      <dd><input type="hidden" name="imageDelete" id="imageDelete" value="<?php echo $edit_image; ?>"></dd>
      <dd><input class="redButton" type="submit" value="削除"></dd>
    </dl>
  </form>
<?php


}elseif($flag==7){
?>
<main id="">
  <h2>【つぶやき編集】</h2>
  <div id="newsAdmin">
  <p><input class="redButton" type="button" onclick="location.href='./twEdit.php'" value="戻る"></p>
  </div>
  <p>画像追加</p>

  <form enctype="multipart/form-data" action="" method="post">
    <p><legend>画像ファイルを選択<br>(GIF, JPEG, PNGのみ対応)</legend><input type="file" name="upfile"></p><br>
    <p><input type="hidden" name="imageid" value="<?php echo $edit_imageAdd ?>"></p>
    <p><input type="submit" value="変更"></p><br>
  </form>

<?php
}else{
  
}
?>
</main>
<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>

