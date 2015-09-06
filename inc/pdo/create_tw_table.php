<?php // create_tw_table.php
// 設定(パス要確認)
include_once("../config.php");

/* table作成 */
/*
  つぶやき編集画面 [tw]
              ID(連番) id [int(10)]
              日付 time [datetime]
              タイトル title [varchar(100)]
              内容 text [text]
              画像名 name [varchar(255)]
              画像タイプ type [tinyint(2)]
              生データ raw_data [mediumblob]
              サムネイル画像 thumb_data [blob]
*/
  $sql= 'create table if not exists tw(
    id int NOT NULL AUTO_INCREMENT COMMENT "ID",
    time datetime NOT NULL COMMENT "日付",
    title varchar(100) NOT NULL COMMENT "タイトル",
    text text NOT NULL COMMENT "つぶやき内容",
    name varchar(255) NOT NULL COMMENT "ファイル名",
    type tinyint(2) NOT NULL COMMENT "IMAGETYPE定数",
    raw_data mediumblob NOT NULL COMMENT "原寸大データ",
    thumb_data blob NOT NULL COMMENT "サムネイルデータ",
    primary key(id)
  )character set utf8;';
  $res= $pdo -> prepare($sql);
  $res -> execute();
// 初期登録
  $time= date('Y-m-d H:i:s');
  $title= "タイトル";
  $text= "テスト";
  $sql_insert = $pdo -> prepare("INSERT INTO tw (time, title, text) VALUES (:time, :title, :text);");
  $sql_insert -> bindParam(':time', $time, PDO::PARAM_STR);
  $sql_insert -> bindParam(':title', $title,  PDO::PARAM_STR);
  $sql_insert -> bindParam(':text', $text, PDO::PARAM_STR);  
  $sql_insert -> execute();

//echo "My_Do_OK.ini";
header("Location: ../../admin/news.php");
exit();

?>