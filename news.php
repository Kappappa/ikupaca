<?php
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();

// Class
include_once("./inc/MHClass.php");
$m = new MHClass;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>news</title>
<meta name="Description" content="">
<meta name="Keywords" content="">
<link rel="stylesheet" type="text/css" href="./css/reset.css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/admin.css">
<style type="text/css">
*{
  font-size: 0.6rem;  
}
body{
    width:100%;
}
#formWrap {
	width:95%;
  padding: 1rem;
	margin:0 auto;
	color:#555;
	line-height:1.3;
	font-size:0.8rem;
}
.newsTime{
  padding: 0.2rem 0 0 0;
}
.newsTitle{
  padding: 0.2rem 0 0 1.5rem;
}
.newsText{
  padding: 0.2rem 0 0.5rem 2.5rem;
}
@media (max-width: 700px) {

#formWrap {
	width:100%;
  padding:0.5rem;
  font-size: 0.7rem;
}
  
}
</style>
</head>
<body>
<div id="formWrap">

<main>
  <header>
    <h1 class="header"><a href="./">ikupaca</a></h1>
    <hr><br>
  </header>
  
  <div id="news">
  <h2>[新着情報]</h2>
<?php
// newsデータチェック
  $DB -> news(100);
?>
  </div>
<?php include_once("./tmp/footer.php"); ?>
</main>
</body>
</html>