<?php // create_blog_table.php
// 設定(パス要確認)
include_once("../config.php");

$sql_image= 'CREATE TABLE IF NOT EXISTS image (
id int(10) unsigned NOT NULL COMMENT "ID",
name varchar(255) NOT NULL COMMENT "ファイル名",
type tinyint(2) NOT NULL COMMENT "IMAGETYPE定数",
raw_data mediumblob NOT NULL COMMENT "原寸大データ",
thumb_data blob NOT NULL COMMENT "サムネイルデータ",
date datetime NOT NULL COMMENT "日付"
)  CHARSET=utf8 ;';
$res_image= $pdo -> prepare($sql_image);
$res_image -> execute();

//echo "My_Do_OK.ini";
header("Location: ../../admin/news.php");
exit();
?>