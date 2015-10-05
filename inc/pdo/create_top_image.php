<?php // create_top_image.php
// 設定(パス要確認)
include_once("../config.php");

$sql_image= 'CREATE TABLE IF NOT EXISTS topImage (
id int(10) unsigned NOT NULL auto_increment COMMENT "ID",
name varchar(255) NOT NULL COMMENT "ファイル名",
date datetime NOT NULL COMMENT "日付",
flag tinyint(2) NOT NULL COMMENT "使用:1 不使用:0",
type tinyint(2) NOT NULL COMMENT "IMAGETYPE定数",
raw_data mediumblob NOT NULL COMMENT "原寸大データ",
thumb_data blob NOT NULL COMMENT "サムネイルデータ",
primary key(id)
)  CHARSET=utf8 ;';
$res_image= $pdo -> prepare($sql_image);
$res_image -> execute();

//echo "My_Do_OK.ini";
header("Location: ../../admin/index.php");
exit();
?>