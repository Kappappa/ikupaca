<?php

session_start();
include_once('../inc/uno.class.php');
$DB= new Uno();

//管理者チェック
if($_SESSION["id"]==ADMIN && $_SESSION["pass"]==PASS){
//  $flag=1;
}else{
//管理者でなければセッション破棄
//  header("Location: ../index.php");
//  exit();
}
// 初期化
$f_name_path= "";
$date= date('YmdHis');
$id= "";

//----------------------------------------------
//ファイルチェック
//----------------------------------------------
$_SESSION["file"]= (!empty($_SESSION["file"])) ? $DB->h($_SESSION["file"]) : "";//画像ファイル
if (isset($_FILES['file']['error']) && is_int($_FILES['file']['error'])) {
  try {
  // $_FILES['file']['error'] の値を確認
    switch ($_FILES['file']['error']) {
      case UPLOAD_ERR_OK: // OK
        break;
      case UPLOAD_ERR_NO_FILE:   // ファイル未選択
        throw new RuntimeException('ファイルが選択されていません');
      case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
      case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
        throw new RuntimeException('ファイルサイズが大きすぎます');
      default:
        throw new RuntimeException('その他のエラーが発生しました');
    }

    $f= !empty($_FILES['file']) ? $DB->h(!empty($_FILES['file'])) : "";
    $f_type= !empty($_FILES['file']['type']) ? substr($DB->h($_FILES['file']['type']),-3) : "";
    $f_name= !empty($_FILES['file']['tmp_name']) ? $DB->h($_FILES['file']['tmp_name']) : "";
    if(!empty($f)){
      if($f_type=="png" || $f_type=="jpg" || $f_type=="gif" || $f_type=="peg"){
        if($f_type=="peg"){$f_type="jpg";}
//        imagesファイルに画像を入れる
        $f_name_path= $date.'.'.$f_type;
        $f_name_path_in= '../topimages/'.$f_name_path;
        move_uploaded_file($f_name,$f_name_path_in);
//        DBへ登録
        $DB-> insertImageData($f_name_path);
      }else{
        echo "失敗";
      }
    }
    
  } catch (RuntimeException $e) {
    $file_msg= ['red', $e->getMessage()];
  }
}

// 表示切り替え
if(!empty($_GET["on"])){
//  Off -> On
  $id= intval($_GET["on"]);
  $flag= "1";
  $DB-> updateImageData($id,$flag);
}elseif(!empty($_GET["off"])){
//  On -> Off
  $id= intval($_GET["off"]);
  $flag= "0";
  $DB-> updateImageData($id,$flag);
}

$image_flag= array(0);
// 非表示のみ($flag:0)
$topOffImages= $DB-> selectTopImages(1,$image_flag,4);
// 表示のみ($flag:1)
$image_flag= array(1);
$topOnImages= $DB-> selectTopImages(1,$image_flag,4);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>topImages</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/admin.css">
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
 
 
  <main>
    <h2>画像登録</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <dl>
<!--        <dt><label for="file">file :</label></dt>-->
        <dd><input type="file" name="file"></dd>
      </dl>
      <p><input type="submit"></p>
    </form>
    
    <hr>
    
    <h3>[On]</h3>
    <p>
<?php
// 表示
if($topOnImages){
  foreach($topOnImages as $key => $val){
    $ViewImage= $val["file_name"];
    $id= $val["id"];
//    echo '<a href="./index.php?off='.$id.'"><img height="100" src="'.$ViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></a>';
    echo '<a href="./topimages.php?off='.$id.'"><img height="100" src="../topimages/'.$ViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></a>';
  }
}else{
  echo "画像はありません";
}
?>
    </p>  
    <h3>[Off]</h3>
    <p>
<?php
// 非表示
if($topOffImages){
  foreach($topOffImages as $key => $val){
    $noViewImage= $val["file_name"];
    $id= $val["id"];
//    echo '<a href="./index.php?on='.$id.'"><img height="100" src="'.$noViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></a>';
    echo '<a href="./topimages.php?on='.$id.'"><img height="100" src="../topimages/'.$noViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></a>';
  }
}else{
  echo "画像はありません";
}
?>
    </p>
    
  </main>
<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>