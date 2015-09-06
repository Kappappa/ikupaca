<?php // create_table.php
// 設定(パス要確認)
include_once("../config.php");

/* table作成 */
//[News]
//    news_id
//    news_create_time
//    news_text
  $sql_news= 'create table if not exists News(
    news_id int not null auto_increment,
    news_create_time datetime not null,
    news_title varchar(100) not null,
    news_text text not null,
    primary key(news_id)
  )character set utf8;';
  $res_news= $pdo -> prepare($sql_news);
  $res_news -> execute();
// 初期登録
  $sql_news_insert = $pdo -> prepare("INSERT INTO News (news_create_time, news_title, news_text) VALUES (:time, :title, :text);");
  $sql_news_insert -> bindParam(':time', $time, PDO::PARAM_STR);
  $sql_news_insert -> bindParam(':title', $title,  PDO::PARAM_STR);
  $sql_news_insert -> bindParam(':text', $text, PDO::PARAM_STR);
    $time= date('Y-m-d H:i:s');
    $title= "タイトル";
    $text= "テスト";
    $sql_news_insert -> execute();

//echo "My_Do_OK.ini";
header("Location: ../../admin/news.php");
exit();
?>