<?php
//  更新:: 2016_10_31
//  容量:: 34.2 MB /100MB
session_start();
//// SESSIONを削除
//$_SESSION = array();
//session_destroy();

ini_set( 'display_errors', true);
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();
include_once('./inc/uno.class.php');
$UNO= new Uno();
// 表示のみ($flag:1)
$image_flag= array(1);
$topOnImages= $UNO-> selectTopImages(1,$image_flag,4);

// ディレクトリ内のサイズ計算
function dir_size($dir){
  $total_size = 0;
  $handle = opendir($dir);
  while ($file = readdir($handle)) {
    if ($file != '..' && $file != '.' && !is_dir($dir.'/'.$file)) {
      $total_size +=  filesize($dir.'/'.$file); 
    } else if (is_dir($dir.'/'.$file) && $file != '..' && $file != '.') {
      $total_size += dir_size($dir.'/'.$file);
    }
  }
  closedir($handle);
  return $total_size;
}
$i= number_format(dir_size('./')*1.25/1048576,1);

// Class
include_once("./inc/MHClass.php");
$m = new MHClass;

// 表示用画像
if (isset($_GET['id'])) {
	try {
			$stmt = $pdo->prepare('SELECT type, raw_data FROM tw WHERE id = ? LIMIT 1');
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
}elseif(isset($_GET['calendar'])){
  try {
			$stmt = $pdo->prepare('SELECT type, raw_data FROM calendarTable WHERE id = ? LIMIT 1');
			$stmt->bindValue(1, $_GET['calendar'], PDO::PARAM_INT);
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

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ikupaca</title>
  <meta name="keywords" content="ikupaca">
  <meta name="description" content="ikupacaワールドへようこそ。京都宇治を拠点に活動中。カラフルを大切にbabyからご長寿まで愛されるような作品を日々ハンドメイドしております。合言葉はクレイジーゴナクレイジー！"> 
  
<!--  検索させない！-->
<!--  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">-->
  
  <link rel="shortcut icon" href="./images/faviconB.ico">
  <link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script type="text/javascript" src="./js/jquery.js"></script>
  <script src="js/jquery.bxslider.min.js"></script>
<!--  <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>-->
  <script type="text/javascript">
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                auto: true,
            });
        });
</script>
  
</head>

<body>
<article>
  <header>
    <h1 class="header">ikupaca<img class="logo" src="./images/ikupaca_logo.png" alt="ikupaca"></h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li id="n2"><a class="now" href="">Home</a></li>
      <li id="n3"><a href="./profile.php">Profile</a></li>
      <li id="n0"><a href="./custommade/index.php">カスタムメイド</a></li>
      <li id="n4"><a href="./works.php">ギャラリー</a></li>
      <li id="n5"><a href="./intro/index.php">お店紹介</a></li>
      <li id="n9"><a href="./event.php">イベント</a></li>
      <li id="n6"><a href="http://ameblo.jp/koharu-biyori-rena/" target="_blank">ブログ</a></li>
      <li id="n7"><a href="https://www.facebook.com/ikupaca" target="_blank">facebook</a></li>
      <li id="n1"><a href="https://instagram.com/IKUPACA/" target="_blank">Instagram</a></li>
      <li id="n8"><a href="./contact.php">お問合わせ</a></li>
<!--      <li><a href="">チームikupaca</a></li>-->
<!--      <li><a href="">Access</a></li>-->
    </ul>
    </div>
    <hr>

  </header>
  <!-- header class="header" -->

  <div class="wrapper">
    <div class="content">
     
      <div class="images">
        <ul class="bxslider">
<?php
// 表示
if($topOnImages){
  foreach($topOnImages as $key => $val){
//    $ViewImage= "./admin/".$val["file_name"];
    $ViewImage= "./topimages/".$val["file_name"];
    $id= $val["id"];
    echo '<li><img src="'.$ViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></li>'.PHP_EOL;
  }
}else{
  echo "画像はありません";
}
?>
<!--
          <li><img src="./screen_images/S__87629978.jpg" title="" alt=""></li>
          <li><img src="./screen_images/S__87629979.jpg" title="" alt=""></li>
          <li><img src="./screen_images/S__87629980.jpg" title="" alt=""></li>
-->
<!--
          <li><img src="./screen_images/20150918_2646.jpg" title="" alt=""></li>
          <li><img src="./screen_images/20150918_2728.jpg" title="" alt=""></li>
          <li><img src="./screen_images/20150918_2734.jpg" title="" alt=""></li>
-->

<!--
          <li><img src="./topimages/index1.jpg" title="1" alt="写真1"></li>
          <li><img src="./topimages/index2.jpg" title="2" alt="写真2"></li>
          <li><img src="./topimages/index3.jpg" title="3" alt="写真3"></li>
          <li><img src="./topimages/index4.jpg" title="4" alt="写真4"></li>
-->
<!--
          <li><img src="./topimages/index5.jpg" title="5" alt="写真5"></li>
          <li><img src="./topimages/index6.jpg" title="6" alt="写真6"></li>
-->
<?php
// ON画像があればココに表示_flagで識別
//$sqlImg=$pdo ->prepare("SELECT * FROM topImage WHERE flag=1 ORDER BY id DESC");
//$sqlImg->execute();
//while($rowImg = $sqlImg -> fetch(PDO::FETCH_ASSOC)){
//  if($rowImg){
//    $img=	sprintf(
//      '<li><img src="data:%s;base64,%s" alt="%s" style="width:auto;"></li>',
//      image_type_to_mime_type($rowImg['type']), //画像タイプ取得
//      base64_encode($rowImg['raw_data']), //画像データをbase64 方式によりエンコード
//      $m->h($rowImg['name']));
//    print $img.PHP_EOL;
//  }else{
//  print "No_Image";
//  }
//}
?>

        </ul>
        <!--slide show-->
      </div>
      <!--images-->

<!--
    <div class="sidebar">
      <dl>
          <dt><a href="http://ameblo.jp/koharu-biyori-rena/" target="_blank">【ブログはこちら】</a></dt>
          <dd>いくぱかの手芸な毎日<br>クレイジーゴナクレイジー</dd>
          <hr>
          <dt><a href="https://www.facebook.com/ikupaca" target="_blank">【facebookはこちら】</a></dt>
          <dd></dd>
          <hr>
          <dt><a href="https://instagram.com/IKUPACA/" target="_blank">【Instagram】</a></dt>
          <dd></dd>
          <hr>
          <dt><a href="./intro/index.php">※ サイト紹介 ※</a></dt>
          <dd></dd>
          <hr>
          <dt><a href="./contact.php">【お問い合わせ】</a></dt>
          <dd></dd>
          <hr>
      </dl>
    </div>
-->
    <!-- div class="sidebar" -->

      
      <div id="con">
       
        <div id="news">
          <h2>[ 新着情報 ] <span class="all"><a href="./news.php">->全件表示</a></span></h2>
<?php
// newsデータチェック
  $DB -> news(5);
?>
</div>

<!-- calendar -->
<div id="calend">
<h2>[おみせカレンダー]</h2>
<div class="linking">
<?php
  $DB -> calendar(1);
?>
</div>
</div>
<!-- calendar -->

        <!--news-->
<!--<a href="./inc/pdo/create_add_table.php">create_add_table</a>-->
        <div id="tweets">
          <h2>[ ikupacaのNEW ] <span class="all"><a href="./ikupacanew.php">->全件表示</a></span></h2>
<?php
// tweetデータチェック
  $DB -> tw(2);
?>
        </div>
        <!--tweets-->
        
      </div>
      <!--con-->
      
    </div>
    <!-- div class="content" -->

  </div>
  <!-- div class="wrapper" -->

<?php include_once("./tmp/footer.php"); ?>
    <p class="mb"><?= $i."MB / 100MB"; ?></p>
</article>
</body>
</html>