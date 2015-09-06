<?php // delete_table.php
// 設定(パス要確認)
include_once("../config.php");

// table削除
$sql = $pdo -> query("DROP TABLE IF EXISTS News;");
$sql->execute(); 

header("Location: ../../admin/news.php");
exit();
?>