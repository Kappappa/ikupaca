<?php

ini_set('display_errors',true); // error表示
include_once("config.php");

class Cero{
  public $con; // MySQlへ接続用

  function __construct(){
    $option = array(
    PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=> true,
    PDO::ATTR_EMULATE_PREPARES=> false,
    PDO::ATTR_STRINGIFY_FETCHES=> false
    );
    $dsn="mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
    $this-> con= new PDO($dsn,DB_USER,DB_PASS,$option);
  }

/*----------------------------------------------
 *    $DB-> selectData($table,$dim,$where);
 *    条件込み込みSELECTして戻しまshow
/---------------------------------------------*/
  function selectData($table,$dim,$where){
    $table= $this-> tables[$table];
    $where= $this-> wheres[$where];
      $sql= "SELECT * FROM {$table} {$where} ;";
      $stmt= $this-> con-> prepare($sql);
      if(!empty($dim)){
        foreach($dim as $key => $val){
          $stmt-> bindValue(($key+1),$val,PDO::PARAM_STR);
        }
      }
      $stmt-> execute();
    while($res= $stmt-> fetch(PDO::FETCH_ASSOC)){
      $row[]= $res;
    }
    return (!empty($row)) ? $row : null;
  }

/*----------------------------------------------
 *    $DB-> insertData($table,$col,$value,$dim,$where);
 *    テーブル、カラム、引数量、値、条件
/---------------------------------------------*/
  function insertData($table,$col,$values,$dim,$where){
    if(empty($dim)) return null;
    $table= $this-> tables[$table];
    $where= $this-> wheres[$where];
    $column= $this-> column[$col];
    $values= $this-> values[$values];
    try{
      $this-> con-> beginTransaction();
      $sql= "INSERT INTO {$table} ({$column}) VALUES({$values}) {$where} ;";
      $stmt= $this-> con-> prepare($sql);
      foreach($dim as $key => $val){
        $stmt-> bindValue(($key+1),$val,PDO::PARAM_STR);
      }
      $stmt-> execute();
      $this-> con-> commit();
    } catch (Exception $e) {
      $this-> con-> rollBack();
      echo "接続に失敗しました。" . $e-> getMessage();
    }
    return null;
  }

/*----------------------------------------------
 *    $DB-> updateData($table,$cols,$value,$dim,$where);
 *    テーブル、カラム、引数量、値、条件
/---------------------------------------------*/
  function updateData($table,$col,$values,$dim,$where){
    if(empty($dim)) return null;
    $table= $this-> tables[$table];
    $where= $this-> wheres[$where];
    $cols= $this-> cols[$col];
    $values= $this-> values[$values];
    try{
      $this-> con-> beginTransaction();
      $sql= "UPDATE {$table} SET {$cols} {$where} ;";
      $stmt= $this-> con-> prepare($sql);
      foreach($dim as $key => $val){
        $stmt-> bindValue(($key+1),$val,PDO::PARAM_STR);
      }
      $stmt-> execute();
      $this-> con-> commit();
    } catch (Exception $e) {
      $this-> con-> rollBack();
      echo "接続に失敗しました。" . $e-> getMessage();
    }
    return null;
  }

/*----------------------------------------------
 *    $DB-> deleteData($table,$dim,$where);
 *    テーブル、引数量、値、条件
/---------------------------------------------*/
  function deleteData($table,$dim,$where){
    if(empty($dim)) return null;
    $table= $this-> tables[$table];
    $where= $this-> wheres[$where];
      $sql= "DELETE FROM {$table} {$where} ;";
      $stmt= $this-> con-> prepare($sql);
      foreach($dim as $key => $val){
        $stmt-> bindValue(($key+1),$val,PDO::PARAM_STR);
      }
      $stmt-> execute();
    return null;
  }



/*----------------------------------------------
 *    $DB-> variable($vari_name);
 *    変数名の取得…あまり使うことが無いと思うけど…
/---------------------------------------------*/
  function variable(&$vari_value) {
    $variable_name= "";
    $tmp= $vari_value;
    $vari_value= uniqid();

    foreach($GLOBALS as $key => $val ){
      if(is_array($val)) continue;
      if($key === "vari_value") continue;
      if($val === $vari_value ) {
        $variable_name = $key;
        break;
      }
    }
    $vari_value = $tmp;
    return $variable_name;
  }

/* ----------------------------------------------
 *		domain_check::ドメインチェック
 *    要 DOMAIN_DATA 設定
 ----------------------------------------------*/
  public function domainCheck(){
//    if( DOMAIN_DATA != parse_url($_SERVER['HTTP_REFERER'])['host']){
//      header('Location: ./index.php');
//      exit();
//    }
  }

/* ----------------------------------------------
 *		ticket_check::チケットチェック
 ----------------------------------------------*/
  public function ticketCheck(){
    $ticket_check= $_SESSION["ticket_f"].$_SESSION["ticket_e"];
    if($_SESSION["ticket_date"] != $ticket_check || empty($_SESSION["ticket_date"])){
      header('Location: ./index.php');
      exit;
    }
  }











// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// 初期化使用方法
// ──────────────────────────────────────────
/*
    $dates= array("mail","pass");
    foreach($dates as $key => $val){
      ${$val}= $DB-> p_in($val);
    }
    foreach($dates as $key => $val){
      $_SESSION[$val]= $DB-> s_in($val);
    }
*/
// ──────────────────────────────────────────

/*----------------------------------------------
 *    $DB->g_in($str);
 *    GET情報初期化
/---------------------------------------------*/
  public function g_in($str){
    return (!empty($_GET[$str])) ? $this-> h($_GET[$str]) : "";
  }
/*----------------------------------------------
 *    $DB->p_in($str);
 *    POST情報初期化
/---------------------------------------------*/
  public function p_in($str){
    return (!empty($_POST[$str])) ? $this-> h($_POST[$str]) : "";
  }
/*----------------------------------------------
 *    $DB->s_in($str);
 *    SESSION情報初期化
/---------------------------------------------*/
  public function s_in($str){
    return (!empty($_SESSION[$str])) ? $this-> h($_SESSION[$str]) : "";
  }

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


// 全データチェック
  public function all(){
    echo '<div class="container bg-success border-demo">';
    $this-> me();
    $this-> ge();
    $this-> po();
    $this-> se();
    echo '</div>';
  }
// GETデータチェック
  public function ge(){
    print  '<span style="color:#f66;">[GET]</span><br>'.PHP_EOL;
    if(!empty($_GET)){
      print_r ($_GET);
      print "<br>".PHP_EOL;
    }else{
      echo "無し<br>".PHP_EOL;
    }
  }
// POSTデータチェック
  public function po(){
    print  '<span style="color:#f66;">[POST]</span><br>'.PHP_EOL;
    if(!empty($_POST)){
      print_r($_POST);
      print "<br>".PHP_EOL;
    }else{
      echo "無し<br>".PHP_EOL;
    }
  }
// SESSIONデータチェック
  public function se(){
    print  '<span style="color:#f66;">[SESSION]</span><br>'.PHP_EOL;
    if(!empty($_SESSION)){
      print_r ($_SESSION);
      print "<br>".PHP_EOL;
    }else{
      echo "無し<br>".PHP_EOL;
    }
  }
// メモリー表示
  public function me(){
    print  '<span style="color:#f66;">[MEMORY]</span><br>'.PHP_EOL;
    print memory_get_peak_usage()."<br>".PHP_EOL;
  }

//  セッション解除
  public function unsession($session_unset){
    foreach ($session_unset as $str) {
      unset($_SESSION["{$str}"]);
    }
  }

//  サニタイズ
  public function h($str,$nl=false){
    $tmp=htmlspecialchars($str,ENT_QUOTES,"utf-8");
    if($nl) $tmp=nl2br($tmp);
    return $tmp;
  }

}


?>