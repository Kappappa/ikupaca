<?php // delete_image_table.php
// 設定(パス要確認)
include_once("../config.php");

// table削除
$sql = $pdo -> query("DROP TABLE IF EXISTS imageTable;");
$sql->execute(); 

header("Location: ../../admin/index.php");
exit();
?>