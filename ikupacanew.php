<?php
// PDO接続
include_once("./inc/config.php");
include_once("./inc/pdoClass.php");
$DB = new DB();

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
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>ikupacaのNEW</title>
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
.twimage{
  width:85%;
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
  <div id="tweets">
  <h2>[ikupacaのNEW]</h2>
<?php
// NEWのデータ
  $DB -> tw(100);
?>
  </div>
<?php include_once("./tmp/footer.php"); ?>
</main>
</body>
</html>