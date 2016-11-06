<?php
// cero!!!
include_once("cero.class.php");

class Uno extends Cero{
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// いろいろ変数
// ──────────────────────────────────────────
  public $con; // MySQlへ接続用

/*
$this-> selectData($table,$dim,$where);
$this-> insertData($table,$col,$value,$dim,$where);
$this-> updateData($table,$col,$value,$dim,$where);
$this-> deleteData($table,$dim,$where);
*/


/* テーブル */
  public $tables= array("error"
                        ,"topimg"   // 1: topimg
                       );
  
/* カラム名 INSERT*/
  public $column= array("error"
    ,"file_name, flag"       // 1: $file_name, $flag
                      );
/* カラム名 UPDATE*/
  public $cols= array(
    "error"
    ,"flag = ? "      // 1: $flag
                      );
  
/* 値の数 */
  public $values= array("error"       // 0
                      ,"?"            // 1
                      ,"?,?"          // 2
                      ,"?,?,?"        // 3
                      ,"?,?,?,?"      // 4
                      ,"?,?,?,?,?"    // 5
                      ,"?,?,?,?,?,?"  // 6
                      );
  
/* 条件 */
  public $wheres= array("error"
    ,""                                     // 1: No WHERE
    ,"WHERE id = ?"                         // 2: id
    ,"WHERE pass = ? AND email = ?"         // 3: $pass,$mail
    ,"WHERE flag = ?"                       // 4: $flag
                      );

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  function __construct(){
		parent::__construct();
  }

/*----------------------------------------------
 *    $DB-> selectTopImages($table,$where)
 *    登録している画像をピックアップ
/---------------------------------------------*/
  function selectTopImages($table,$dim,$where){
    $res= $this-> selectData($table,$dim,$where);
    return (!empty($res)) ? $res : null;
  }
/*----------------------------------------------
 *    $DB-> insertImageData($f_name_path);
 *    画像の登録
/---------------------------------------------*/
  function insertImageData($f_name_path){
    if(empty($f_name_path)) return null;
    $flag= "0";
    $dim= array($f_name_path,$flag);
    $this-> insertData(1,1,2,$dim,1);
  }
/*----------------------------------------------
 *    $DB-> updateImageData($id,$flag);
 *    画像の表示切り替え
/---------------------------------------------*/
  function updateImageData($id,$flag){
    if(empty($id)) return null;
    $dim= array($flag,$id);
    $this-> updateData(1,1,1,$dim,2);
  }


/*----------------------------------------------
 *    $DB-> tableCreate();
 *    table
/---------------------------------------------*/
  function tableCreate(){
    try{
      $this-> con-> beginTransaction();
      $sql= "CREATE TABLE IF NOT EXISTS `topimg` (
        `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
        `file_name` varchar(255) NOT NULL COMMENT 'ファイル名',
        `flag` int(11) NOT NULL COMMENT '0:非表示,1:表示',
         primary key(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $stmt= $this-> con-> prepare($sql);
      $stmt-> execute();
      $this-> con-> commit();
    } catch (Exception $e) {
      $this-> con-> rollBack();
      echo "接続に失敗しました。" . $e-> getMessage();
    }
    return null;
  }




}
?>