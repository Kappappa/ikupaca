<?php
ini_set( 'display_errors', 1);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>Plan</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
</head>
<body>
<article>
<main>

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

</main>
</article>
</body>
</html>