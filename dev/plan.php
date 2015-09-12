<?php
ini_set( 'display_errors', 1);
// PDO接続
include_once("../inc/config.php");



?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>Plan</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="../css/reset.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<style type="text/css">
body{width:90%}
main{padding:1rem;}
</style>
</head>
<body>
<article>
<main>
<header><h2 class="header">ikupaca_log</h2><hr></header><br>
<?php

// ファイルを読み込み専用でオープンする
$fp = fopen('./plan.txt', 'r');
// 終端に達するまでループ
while (!feof($fp)) {
  // ファイルから一行読み込む
  $line = fgets($fp);
  // 読み込んだ行を出力する
  print $line;
  // <br>の出力
  print "<br>\n";
}
// ファイルをクローズする
fclose($fp);

?>

<?php include_once("../tmp/footer.php"); ?>

</main>
</article>
</body>
</html>