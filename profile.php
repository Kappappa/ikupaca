<?php
//ログオフ
session_start();
//// SESSIONを削除
//$_SESSION = array();
//session_destroy();

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
<!--  <meta name="keywords" content="ikupaca">-->
<!--  <meta name="description" content="ikupacaワールドへようこそ。京都宇治を拠点に活動中。カラフルを大切にbabyからご長寿まで愛されるような作品を日々ハンドメイドしております。合言葉はクレイジーゴナクレイジー！"> -->
  
<!--  検索させない！-->
  <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
  
  <link rel="shortcut icon" href="./images/faviconB.ico">
  <link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script type="text/javascript" src="./js/jquery.js"></script>
  
</head>

<body>
<article>
  <header>
    <h1 class="header">ikupaca<img class="logo" src="./images/ikupaca_logo.png" alt="ikupaca"></h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li id="n2"><a href="./index.php">Home</a></li>
      <li id="n3"><a class="now" href="./profile.php">Profile</a></li>
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
      <div id="p_con">

        <h2 id="p_back">Profile</h2>
        
        <div id="pr">
        <img class="profile" src="./images/profile.jpg" alt="profile">
<!--        <p>京都宇治を拠点に活動しています。<br>二児の母。<br>カラフルを大切にベビーからご長寿まで愛されるようなものを日々ハンドメイドしています。<br>合言葉は<span class="ki">クレイジーゴナクレイジー</span>。<br>夢中になるとまらないという意味です。<br>そんなikupacaワールドを皆さんと体感し合いたいです。<br>不思議なアイテム、取り揃えております。</p>-->
        
        <p>ikupacaワールドへようこそ。
<br>京都宇治を拠点に活動中。
          <br>カラフルを大切にベイビーからご長寿まで愛されるような作品を日々手作りしております。ikupacaのオリジナルキャラクター<span class="ki">「にぎ夫さん&にぎねこ」</span>をはじめ、優しさは手から生まれる。をコンセプトに１つ１つこだわりの布とパーツ、そして手刺繍で作られています。
<br>手作りならではの温かさ、癒し、愛着。ikupacaならではのゆるさ、カラフル、クレイジーを、皆様にも感じていただきたいです。</p>
       </div>
<!--       div#pr-->
       
      </div>
<!--   div class="p_con"-->
    </div>
    <!-- div class="content" -->

  </div>
  <!-- div class="wrapper" -->

<?php include_once("./tmp/footer.php"); ?>
</article>
</body>
</html>