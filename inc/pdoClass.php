<?php
/** -------------------------------------------------------------
 *  pdo_Class
 *  author: M.Hayashida
 *  Date: 2015/08/29
 -------------------------------------------------------------- */

/* ----------------------------------------------
 *		使用方法
 ----------------------------------------------*/
/*
[呼び出し]
  include_once("./inc/pdoClass.php");
  $DB = new DB();

  // news3件
  $DB -> news(3);
*/

/* ----------------------------------------------
 *		エラー表示
 ----------------------------------------------*/
ini_set('display_errors',true);
include_once("config.php");

/* ----------------------------------------------
 *		PDO接続
 ----------------------------------------------*/
function pdoSESSION(){
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

	$dsn = 'mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8';
	try {
		return $pdo = new PDO($dsn, DB_USER, DB_PASS, $option);
	//	echo'DBに接続しました';
	} catch (PDOException $e){
		echo $e->getMessage();
		print("err");
	}
}

class DB
{

function __construct(){
/* コンストラクタ */
}

/* ----------------------------------------------
 *		news::新着情報
 ----------------------------------------------*/
public function news($cnt)
{
  if($cnt==""){
    return NULL;
  }
  $cnt=intval($cnt);
  // PDO接続
  $pdo = pdoSESSION();
  try {
    $pdo->beginTransaction();
    //新着情報取得(7日間はnew画像追加)
    $sql_news= sprintf('SELECT * FROM News order by news_create_time desc LIMIT %d ;',$cnt);
    $res_news=  $pdo -> query($sql_news);
   $pdo->commit();
  } catch (Exception $e) {
    $pdo->rollBack();
    echo "接続に失敗しました。" . $e->getMessage();
  }
  while($row= $res_news -> fetch(PDO::FETCH_ASSOC)) {
  //  $news_id = $row["news_id"];
    $news_create_time = $row["news_create_time"];
    $news_text = nl2br($row["news_text"]);
    $news_title = nl2br($row["news_title"]);
    $timer= (strtotime(date('Y-m-d')) - strtotime($news_create_time))/ (60 * 60 * 24);
    $new_image="";
    if($timer<7){
      $new_image='<img src="./images/new.gif" alt="new">';
    }
  // ヒアドキュメントで表示
echo <<<EOS
        <hr class="newsHr">
        <p class="newsTime">$news_create_time $new_image</p>
        <p class="newsTitle">[$news_title]</p>
        <p class="newsText">$news_text</p>

EOS;
  }
}

/* ----------------------------------------------
 *		paging::ページング
 ----------------------------------------------*/
public function paging($page,$table)
{
  if($page=="" || $table==""){
    return NULL;
  }
  $page= intval($page);
  // PDO接続
  $pdo = pdoSESSION();
  
  //新着情報追加
  $sql = "SELECT COUNT(*) AS n FROM ".$table.";";
  $res = $pdo -> query($sql);
  $row= $res -> fetch(PDO::FETCH_ASSOC);
  return ceil($row["n"]/$page);
}

/* ----------------------------------------------
 *		newsAllEdit::新着情報一覧表示(エラー；；；；；)
 ----------------------------------------------*/
public function newsAllEdit($p,$dataPerPage)
{
  if($dataPerPage==""){
    return NULL;
  }
  $p=intval($p);
//  $dataPerPage=intval($dataPerPage);
  $dataPerPage=10;
//  $page= ($p-1)*$dataPerPage;
  $page= 1;
  // PDO接続
  $pdo = pdoSESSION();

  $sql_newsAllEdit= sprintf('SELECT * FROM News order by news_create_time desc LIMIT %d, %d ;',$page,$dataPerPage);
  $res_newsAllEdit=  $pdo -> query($sql_newsAllEdit);
  while($row= $res_newsAllEdit -> fetch(PDO::FETCH_ASSOC)) {
    $news_id = $row["news_id"];
    $news_create_time = $row["news_create_time"];
    $news_title = $row["news_title"]; 
    $news_text = nl2br($row["news_text"]); 
  //   ヒアドキュメントで表示
echo <<<EOS
        <hr class="newsHr">
        <p class="newsAdminTime">$news_create_time</p>
        <p class="newsAdminTitle">[$news_title]</p>
        <p class="newsAdminText">$news_text</p>
        <form action="" method="get">
          <input type="hidden" name="edit" id="edit" value="$news_id">
          <input type="submit" value="編集">
        </form>

EOS;
    }
}


/* ----------------------------------------------
 *		newsEdit::新着情報表示
 ----------------------------------------------*/
public function newsEdit($edit)
{
  if($edit==""){
    return NULL;
  }
  $edit=intval($edit);
  // PDO接続
  $pdo = pdoSESSION();

  $sql_newsEdit= sprintf('SELECT * FROM News WHERE news_id = %d order by news_create_time desc;',$edit);
  $res_newsEdit=  $pdo -> query($sql_newsEdit);
  $row= $res_newsEdit -> fetch(PDO::FETCH_ASSOC);
    $news_id = $row["news_id"];
    $news_create_time = $row["news_create_time"];
    $news_title = $row["news_title"]; 
    $news_text = $row["news_text"]; 
  //   ヒアドキュメントで表示
echo <<<EOS
        <form action="./newsEdit.php" method="post">
        <dl>
          <dd class="newsAdminTime"><input type="text" name="news_create_time" id="news_create_time" value="$news_create_time"></dd>
          <dd class="newsAdminTitle"><input type="text" name="news_title" id="news_title" value="$news_title"></dd>
          <dd class="newsAdminText"><textarea rows="10" name="news" id="textAdmin">$news_text</textarea></dd>
        </dl>
          <p><input type="hidden" name="edit" id="edit" value="$news_id"></p>
          <p><input type="submit" value="確認"></p>
        </form>
        <form action="./newsEdit.php" method="post">
          <p><input class="redButton" type="submit" value="削除"></p>
          <p><input type="hidden" name="editDelete" id="editDelete" value="$news_id"></p>
        </form>

EOS;
}

/* ----------------------------------------------
 *		news_INSERT::新着情報追加
 ----------------------------------------------*/
public function newsInsert($time, $title, $news)
{
  if($time=="" || $title =="" || $news==""){
    return NULL;
  }
  // PDO接続
  $pdo = pdoSESSION();

  //新着情報追加
  $sql = $pdo -> prepare("INSERT INTO News (news_create_time , news_title , news_text) VALUES (:time, :title , :news);");
  $sql-> bindParam(':time', $time, PDO::PARAM_STR);
  $sql->bindParam(':title', $title, PDO::PARAM_STR);
  $sql->bindParam(':news', $news, PDO::PARAM_STR);

  $sql->execute(); 
  return NULL;
}


/* ----------------------------------------------
 *		news_UPDATE::新着情報更新
 ----------------------------------------------*/
public function newsUpdate($id, $time, $title, $news)
{
  if($id=="" || $time=="" || $title =="" || $news==""){
    return NULL;
  }
  // PDO接続
  $pdo = pdoSESSION();

  //情報更新
  $sql = $pdo -> prepare("UPDATE News SET news_create_time= :time , news_title= :title , news_text= :news where news_id= :id ;");
  $sql-> bindParam(':id', $id, PDO::PARAM_STR);
  $sql-> bindParam(':time', $time, PDO::PARAM_STR);
  $sql->bindParam(':title', $title, PDO::PARAM_STR);
  $sql->bindParam(':news', $news, PDO::PARAM_STR);

  $sql->execute(); 
  return NULL;
}


/* ----------------------------------------------
 *		news_DELETE::新着情報削除
 ----------------------------------------------*/
public function newsDelete($editDelete)
{
if($editDelete==""){
    return NULL;
  }
  $editDelete=intval($editDelete);
  // PDO接続
  $pdo = pdoSESSION();
  
//  DELETE FROM News WHERE news_id = 5;
  $sql_newsDelete=sprintf("DELETE FROM News WHERE news_id= %d ;",$editDelete);
  $pdo -> query($sql_newsDelete);
//  print "OK";
  return NULL;
}

/* ----------------------------------------------
 *		tw_INSERT::新着情報追加
 ----------------------------------------------*/
public function twInsert($time, $title, $text)
{
  if($time=="" || $title =="" || $text==""){
    return NULL;
  }
  // PDO接続
  $pdo = pdoSESSION();

  //新着情報追加
  $sql = $pdo -> prepare("INSERT INTO tw (time , title , text) VALUES (:time, :title , :text);");
  $sql-> bindParam(':time', $time, PDO::PARAM_STR);
  $sql->bindParam(':title', $title, PDO::PARAM_STR);
  $sql->bindParam(':text', $text, PDO::PARAM_STR);

  $sql->execute(); 
  return NULL;
}

/* ----------------------------------------------
 *		tw::つぶやき
 ----------------------------------------------*/
public function tw($cnt)
{
  if($cnt==""){
    return NULL;
  }
  $cnt=intval($cnt);
  // PDO接続
  $pdo = pdoSESSION();
  try {
    $pdo->beginTransaction();
    
    $sql_tw= sprintf('SELECT * FROM tw order by time desc LIMIT %d ;',$cnt);
    $res_tw=  $pdo -> query($sql_tw);
    $pdo->commit();
    
  } catch (Exception $e) {
    $pdo->rollBack();
    echo "接続に失敗しました。" . $e->getMessage();
  }
  while($row= $res_tw -> fetch(PDO::FETCH_ASSOC)) {
    $time = $row["time"];
    $text = nl2br($row["text"]);
    $title = nl2br($row["title"]);
    $timer= (strtotime(date('Y-m-d')) - strtotime($time))/ (60 * 60 * 24);
    $new_image="";
    if($row['name']){
      $img=	sprintf(
             '<a class="tw_img" href="?id=%d" target="_blank"><img src="data:%s;base64,%s" alt="%s" /> </a>',
             $row['id'],
             image_type_to_mime_type($row['type']),	//	画像タイプ取得
             base64_encode($row['thumb_data']),	//	画像データをbase64 方式によりエンコード
             $row['name']
          );
    }else{
      $img="";
    }
    
    if($timer<7){
      $new_image='<img src="./images/new.gif" alt="new">';
    }
  // ヒアドキュメントで表示
echo <<<EOS
        <hr class="newsHr">
        <p class="newsTime">$time $new_image</p>
        <p class="newsTitle">[$title]</p>
        <p class="newsText">$text</p>
        <p>$img</p>

EOS;
  }
}

/* ----------------------------------------------
 *		imageId::画像添付用ID取得
 ----------------------------------------------*/
public function imageId($timeCheck)
{
  if($timeCheck==""){
    return NULL;
  }
  // PDO接続
  $pdo = pdoSESSION();
  try {
    $pdo->beginTransaction();
    $sql_tw= sprintf('SELECT * FROM tw WHERE time = "%s";',$timeCheck);
    $res_tw=  $pdo -> query($sql_tw);
    $row= $res_tw -> fetch(PDO::FETCH_ASSOC);
    $pdo->commit();
    return intval($row["id"]);
  } catch (Exception $e) {
    $pdo->rollBack();
    echo "接続に失敗しました。" . $e->getMessage();
  }
}

/* ----------------------------------------------
 *		twEdit::つぶやき表示
 ----------------------------------------------*/
public function twEdit($edit,$table_name,$self)
{
  if($edit=="" || $table_name=="" || $self=""){
    return NULL;
  }
  $edit=intval($edit);
  // PDO接続
  $pdo = pdoSESSION();

  $sql_Edit= sprintf('SELECT * FROM %s WHERE id = %d order by time desc;',$table_name,$edit);
  $res_Edit=  $pdo -> query($sql_Edit);
  $row= $res_Edit -> fetch(PDO::FETCH_ASSOC);
    $edit_id = $row["id"];
    $edit_time = $row["time"];
    $edit_title = $row["title"]; 
    $edit_text = $row["text"]; 
  //   ヒアドキュメントで表示
echo <<<EOS
        <form action="$self" method="post">
        <dl>
          <dd class=""><input type="text" name="time" id="time" value="$edit_time"></dd>
          <dd class=""><input type="text" name="title" id="title" value="$edit_title"></dd>
          <dd class=""><textarea rows="10" name="text" id="textAdmin">$edit_text</textarea></dd>
        </dl>
          <p><input type="hidden" name="edit" id="edit" value="$edit_id"></p>
          <p><input type="submit" value="確認"></p>
        </form>
        <form action="$self" method="post">
          <p><input class="redButton" type="submit" value="削除"></p>
          <p><input type="hidden" name="editDelete" id="editDelete" value="$edit_id"></p>
        </form>

EOS;
}



/* ----------------------------------------------
 *		edit_UPDATE::新着情報更新
 ----------------------------------------------*/
public function editUpdate($id, $time, $title,$text,$table_name)
{
  if($id=="" || $time=="" || $title =="" || $text=="" || $table_name==""){
    return NULL;
  }
  // PDO接続
  $pdo = pdoSESSION();
  //情報更新
  $sql = $pdo -> prepare("UPDATE " .$table_name. " SET time= :time , title= :title , text= :text WHERE id= :id ;");
//  $sql = $pdo -> prepare("UPDATE tw SET time= :time , title= :title , text= :text WHERE id= :id ;");
  $sql-> bindParam(':id', $id, PDO::PARAM_STR);
  $sql-> bindParam(':time', $time, PDO::PARAM_STR);
  $sql->bindParam(':title', $title, PDO::PARAM_STR);
  $sql->bindParam(':text', $text, PDO::PARAM_STR);
//  $sql->bindParam(':table', $table_name, PDO::PARAM_STR);

  $sql->execute(); 
  return NULL;
}


/* ----------------------------------------------
 *		edit_DELETE::新着情報削除
 ----------------------------------------------*/
public function editDelete($editDelete,$table_name)
{
if($editDelete==""){
    return NULL;
  }
  $editDelete=intval($editDelete);
  // PDO接続
  $pdo = pdoSESSION();
  
//  DELETE FROM News WHERE news_id = 5;
  $sql_editDelete=sprintf("DELETE FROM %s WHERE id= %d ;",$table_name,$editDelete);
  $pdo -> query($sql_editDelete);
//  print "OK";
  return NULL;
}
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  





}













  




?>