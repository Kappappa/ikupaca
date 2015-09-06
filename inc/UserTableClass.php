<?php
/** -------------------------------------------------------------
 *  ./inc/UserTableClass.php
 *  author: M.Hayashida
 *  Date: 2015/08/04
 -------------------------------------------------------------- */

include_once('../inc/config.php');

// PDO接続
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

/* ----------------------------------------------
 *		ここから
 ----------------------------------------------*/
class UserTable
{

function __constract()
{
	//コンストラクタ
}

// test
function test(){
  print "UserTableClass";
}

/* ----------------------------------------------
 *		ログインチェック_mailとpass_(PDO)
 ----------------------------------------------*/
function UserTableWho($email,$pass){
	//引数判定
	if($email == "" || $pass == ""){
		return NULL;
	}

	// PDO接続
	$pdo = pdoSESSION();

	//データ取得
	$sql = $pdo -> prepare ("SELECT * FROM tofuUser WHERE email= :email and password= :pass ;");
	$sql->bindParam(':email', $email, PDO::PARAM_STR);
	$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql->execute();
	$row = $sql -> fetch(PDO::FETCH_ASSOC);
	if($row){
    // ログインチェックOK
		return 1;
	}else{
    // ログインチェックNG
		return 0;
	}
}

/* ----------------------------------------------
 *		ユーザーチェック_mail_(PDO)
 ----------------------------------------------*/
function UserTableUserCheck($name){
	//引数判定
	if($name == ""){
		return NULL;
	}

	// PDO接続
	$pdo = pdoSESSION();

	//データ取得
	$sql = $pdo -> prepare ('SELECT * FROM tofuUser WHERE name= :name ;');
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->execute();
	$row = $sql -> fetch(PDO::FETCH_ASSOC);
	if($row){
    // DBに無いからOK
		return 1;
	}else{
    // DBに無いからNG
		return 0;
	}
}

/* ----------------------------------------------
 *		新規User追加_insert_(PDO)
 ----------------------------------------------*/
public function UserTableInsert($name){
	//引数判定
	if($name == ""){
		return NULL;
	}
  
	// PDO接続
	$pdo = pdoSESSION();
  
	//SQL
  $sql = $pdo -> prepare('INSERT INTO tofuUser(name,flag,createdate,movepoint,maxmovepoint) VALUES(:name , 1 , NOW(),5,5);');
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->execute();
}

/* ----------------------------------------------
 *		ID参照_select_userData_(PDO)
 ----------------------------------------------*/
public function UserTableSelectID($email,$pass){
	if($email == "" || $pass==""){
		return NULL;
	}
  
  // PDO接続
	$pdo = pdoSESSION();
  
  // SQL
	$sql=$pdo -> prepare("SELECT * FROM tofuUser WHERE email=:email and password= :pass;");
	$sql->bindParam(':email', $email, PDO::PARAM_STR);
	$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql->execute();
  $row = $sql -> fetch(PDO::FETCH_ASSOC);

	if(!$row){
		return NULL;
	}else{
    return $row;
  }
}

/* ----------------------------------------------
 *		キャラクタ所持確認_select_userData_(PDO)
 ----------------------------------------------*/
public function UserTableCharCheck($id){
	if($id == ""){
		return NULL;
	}
  
  // PDO接続
	$pdo = pdoSESSION();
  
  // 初期化
  $data= array();
  
  // SQL
	$sql=$pdo -> prepare("SELECT * FROM tofuParam WHERE userid= :id;");
	$sql->bindParam(':id', $id, PDO::PARAM_STR);
	$sql->execute();
  while($row = $sql -> fetch(PDO::FETCH_ASSOC)){
    $data[]= $row;
  }
  
	if(!$data){
		return NULL;
	}else{
    return $data;
  }
}

/* ----------------------------------------------
 *		キャラクタ確認_select_userData_(PDO)
 ----------------------------------------------*/
public function UserTableCharData($id){
	if($id == ""){
		return NULL;
	}
  
  // PDO接続
	$pdo = pdoSESSION();
  
  // SQL
	$sql=$pdo -> prepare("SELECT * FROM tofuChar WHERE charid= :id;");
	$sql->bindParam(':id', $id, PDO::PARAM_STR);
	$sql->execute();
  $row = $sql -> fetch(PDO::FETCH_ASSOC);
    
	if(!$row){
		return NULL;
	}else{
    return $row;
  }
}

/* ----------------------------------------------
 *		User確認_select_userData_(PDO)
 ----------------------------------------------*/
public function UserTableUserData($id){
	if($id == ""){
		return NULL;
	}
  
  // PDO接続
	$pdo = pdoSESSION();
  
  // SQL
	$sql=$pdo -> prepare("SELECT * FROM tofuUser WHERE id= :id;");
	$sql->bindParam(':id', $id, PDO::PARAM_STR);
	$sql->execute();
  $row = $sql -> fetch(PDO::FETCH_ASSOC);
    
	if(!$row){
		return NULL;
	}else{
    return $row;
  }
}
  
/* ----------------------------------------------
 *		追加_insert_enemy(PDO)
 ----------------------------------------------*/
public function AdminInsertEnemy($enemyname,$attribute,$hp,$atc,$def,$speed,$secret_id,$secret_name,$ex,$money,$recipeid,$material_id,$rank,$enemyimg){
  
	//引数判定
	if($enemyname == "" || $attribute == "" || $hp== "" || $atc== "" || $def== "" || $speed== "" || $secret_id== "" || $secret_name== "" || $ex== "" || $money== "" || $recipeid== "" || $material_id== "" || $rank== ""){
		return NULL;
	}
  
	// PDO接続
	$pdo = pdoSESSION();
  
	//SQL
  $sql = $pdo -> prepare('INSERT INTO tofuEnemy(enemyname,attribute,hp,atc,def,speed,secret_id,secret_name,ex,money,recipeid,material_id,rank,enemyimg) VALUES(:enemyname , :attribute,:hp,:atc,:def,:speed,:secret_id,:secret_name,:ex,:money,:recipeid,:material_id,:rank,:enemyimg);');
	$sql->bindParam(':enemyname', $enemyname, PDO::PARAM_STR);
	$sql->bindParam(':attribute', $attribute, PDO::PARAM_STR);
	$sql->bindParam(':hp', $hp, PDO::PARAM_STR);
	$sql->bindParam(':atc', $atc, PDO::PARAM_STR);
	$sql->bindParam(':def', $def, PDO::PARAM_STR);
	$sql->bindParam(':speed', $speed, PDO::PARAM_STR);
	$sql->bindParam(':secret_id', $secret_id, PDO::PARAM_STR);
	$sql->bindParam(':secret_name', $secret_name, PDO::PARAM_STR);
	$sql->bindParam(':ex', $ex, PDO::PARAM_STR);
	$sql->bindParam(':money', $money, PDO::PARAM_STR);
	$sql->bindParam(':recipeid', $recipeid, PDO::PARAM_STR);
	$sql->bindParam(':material_id', $material_id, PDO::PARAM_STR);
	$sql->bindParam(':rank', $rank, PDO::PARAM_STR);
	$sql->bindParam(':enemyimg', $enemyimg, PDO::PARAM_STR);
	$sql->execute();
  
  return "Class OK:";
}

/* ----------------------------------------------
 *		追加_insert_(PDO)
 ----------------------------------------------*/
public function AdminTableInsert($name,$email,$pass){
	//引数判定
	if($name == "" || $email == "" || $pass == ""){
		return NULL;
	}
  
	// PDO接続
	$pdo = pdoSESSION();
  
	//SQL
  $sql = $pdo -> prepare('INSERT INTO tofuUser(name,password,email,flag,createdate) VALUES(:name , :pass , :email , 1 , NOW());');
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->bindParam(':email', $email, PDO::PARAM_STR);
	$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql->execute();
}


/* ----------------------------------------------
 *		変更_update set
 ----------------------------------------------*/
public function UserTableUpdate($where){
	//引数判定
	if($where == ""){
		return NULL;
	}

	//データ取得
	$cols="";
	$values="";
	$param="";
	$c="";
	$v="";

	$cols="where ".mysql_real_escape_string($where[0][0])."=".intval($where[0][1]);
for($cnt=1;$cnt<count($where);$cnt++){
	$c=mysql_real_escape_string($where[$cnt][0]);
	$v=mysql_real_escape_string($where[$cnt][1]);
	$param=mysql_real_escape_string($where[$cnt][2]);
	if($param=="string"){$v='"'.$v.'"';}
	$values=($cnt==1) ? $c."=".$v : $values.",".$c."=".$v;
}
	//SQL
	$sqlU="update UserTable set ".$values.",updatedate=NOW() ".$cols.";";
	mysql_query($sqlU);
	return NULL;
}

/* ----------------------------------------------
 *		削除_delete
 ----------------------------------------------*/
function UserTableDelete($idDelete){
	//引数判定
	if($idDelete == ""){
		return NULL;
	}
	//データ取得
	$idDelete=intval($idDelete);
	$where= " where userid=".$idDelete.";";
	//SQL
	$sqlD="delete from UserTable".$where;
	mysql_query($sqlD);
	return NULL;
}

/* ----------------------------------------------
 *		メール重複チェック_mailだけ
 ----------------------------------------------*/
function UserTableCheck($email){
	//引数判定
	if($email == ""){
		return NULL;
	}
	//データ取得
	$email=mysql_real_escape_string($email);
	//SQL
	$sql=mysql_query('select 1 from UserTable where email="'.$email.'";');
	$row=mysql_fetch_assoc($sql);
	if($row){
		return 1;
	}else{
		return 0;
	}
}

/* ----------------------------------------------
 *		登録チェック
 ----------------------------------------------*/
public function UserTableInsertCheck($email,$pass){
	if($email == ""){
		return NULL;
	}
	$email=mysql_real_escape_string($email);
	$pass=mysql_real_escape_string($pass);
	$sql='select * from UserTable where email="'.$email.'" and password="'.$pass.'";';
//			$fp = fopen("./sql.txt", "a");
//			fwrite($fp, $sql."\n");
//			fclose($fp);
	$result = mysql_query($sql);
	if(!$result){
		return NULL;
	}
	while($row= mysql_fetch_assoc($result)){
		$date=$row["userid"];
	}
	return $date;
}


}

?>