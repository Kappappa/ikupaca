<?php // create_add_table.php
// 設定(パス要確認)
include_once("../config.php");

$sql_image= 'CREATE TABLE addTable (
id int(10) unsigned NOT NULL auto_increment COMMENT "ID",
date datetime NOT NULL COMMENT "日付",
site_name varchar(255) NOT NULL COMMENT "サイト名",
site_comment text NOT NULL COMMENT "サイト紹介",
ad_id varchar(10) NOT NULL  COMMENT "郵便番号",
ad varchar(255) NOT NULL COMMENT "住所",
tel varchar(30) COMMENT "電話番号",
site varchar(255) COMMENT "サイト名",
url varchar(255) COMMENT "サイトURL",
name varchar(255) COMMENT "ファイル名",
type tinyint(2) COMMENT "IMAGETYPE定数",
raw_data mediumblob COMMENT "原寸大データ",
thumb_data blob COMMENT "サムネイルデータ",
flag tinyint(2) NOT NULL COMMENT "使用:1,不使用:0",
primary key(id)
)  CHARSET=utf8 ;';
$res_image= $pdo -> prepare($sql_image);
$res_image -> execute();

//echo "My_Do_OK.ini";
header("Location: ../../admin/index.php");
exit();
?>
