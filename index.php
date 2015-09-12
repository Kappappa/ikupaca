<?php
//ログオフ
session_start();
// SESSIONを削除
$_SESSION = array();
session_destroy();

ini_set( 'display_errors', true);
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();

// Class
include_once("./inc/MHClass.php");

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
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ikupaca</title>
  <meta name="keywords" content="ikupaca">
  <meta name="description" content="ikupacaワールドへようこそ。京都宇治を拠点に活動中。カラフルを大切にbabyからご長寿まで愛されるような作品を日々ハンドメイドしております。合言葉はクレイジーゴナクレイジー！"> 
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
      <li class="now"><a href="">Home</a></li>
      <li><a href="">作品紹介</a></li>
      <li><a href="">チームikupaca</a></li>
      <li><a href="">Profile</a></li>
      <li><a href="">Access</a></li>
    </ul>
    </div>
    <hr>

  </header>
  <!-- header class="header" -->

  <div class="wrapper">
    <div class="content">
     
      <div class="images">  
        <ul class="bxslider">
          <li><img src="./images/p1.jpg" title="1" alt="写真1"></li>
          <li><img src="./images/p2.jpg" title="2" alt="写真2"></li>
          <li><img src="./images/p3.jpg" title="3" alt="写真3"></li>
          <li><img src="./images/p4.jpg" title="4" alt="写真4"></li>
        </ul>
        <!--slide show-->
      </div>
      <!--images-->

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
          <dt><a href="./admin/index.php">今だけ管理画面</a></dt>
          <dd></dd>
      </dl>
    </div>
    <!-- div class="sidebar" -->

      
      <div id="con">
       
        <div id="news">
          <h2>[ 新着情報 ]</h2>
<?php
// newsデータチェック
  $DB -> news(3);
?>
        </div>
        <!--news-->

        <div id="tweets">
          <h2>[ つぶやき ]</h2>
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
</article>
</body>
</html>