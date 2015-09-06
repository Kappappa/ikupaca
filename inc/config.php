<?php
header("Content-Type:text/html;charset=utf-8"); 
//ini_set( 'display_errors', 1 );
// local用
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234'); 
define("DB_NAME","ikupaca"); 

// 管理者
define("ADMIN","admin");
define("PASS","1234");

$option = array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // デフォルトのエラー発生時の処理方法を指定
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // SELECT 等でデータを取得する際の型を指定
  PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    // SELECT した行数を取得する関数 rowCount() が使える
  PDO::ATTR_EMULATE_PREPARES => false,
    // MySQLネイティブのプリペアドステートメント機能の代わりにエミュしたものを使う設定
  PDO::ATTR_STRINGIFY_FETCHES => false
    // 取得時した内容を文字列型に変換するかのオプション,int型も文字列扱い
);

// PDO接続
$dsn = 'mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8';
try {
	$pdo = new PDO($dsn, DB_USER, DB_PASS, $option);
} catch (PDOException $e){
	http_response_code(500);
	echo $e->getMessage();
  print("err");
}
?>