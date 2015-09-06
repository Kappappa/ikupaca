<?php
/** -------------------------------------------------------------
 *  HayashidaMasaruClass
 *  author: M.Hayashida
 *  Date: 2015/07/05
 -------------------------------------------------------------- */

/* ----------------------------------------------
 *		使用方法
 ----------------------------------------------*/
/*
[呼び出し]
  include_once('./MHClass.php');
  $m = new MHClass;
  // POSTデータチェック
  $m -> po();

[リスト]
・Mail::任意のアドレスから送信(要送信元変更)
  $m -> toMail($address,$title,$str);
・表示::ブラウザにvar_dump
  $m -> varDump($var);
・表示::ブラウザにphpファイル全部
  $m -> srcCode($page);
・表示::カレンダー
  $m -> calendar($year,$month);
・確認::メールアドレス
  $m -> isMail($mail);
・確認::パスワードチェック
  $m -> isPass($pass);
・デバッグ::ログファイル作成及び追記
  $m -> debugAdd($file,$str);
・表示::ログファイル表示(パス要確認)
  $m -> debugParam($file);
・POSTデータチェック
  $m -> po();
・SESSIONデータチェック
  $m -> se();
・FILESデータチェック
  $m -> fi();
・サニタイズ
  $m -> h($str);
・サニタイズ(無ければemptyをreturn)
  $m -> haveData($sessionStr);
・
  $m -> ;
*/


/* ----------------------------------------------
 *		設定
 ----------------------------------------------*/
//$con=include_once("con.php");
/* ----------------------------------------------
 *		エラー表示
 ----------------------------------------------*/
//ini_set('display_errors',true);

class MHClass
{
//public $con;		//DBコネクト

function __constract()
{
  // コンストラクタ
}


/* ----------------------------------------------
 *		Mail::任意のアドレスから送信(要送信元変更)
 ----------------------------------------------*/
public  function toMail($address,$title,$str){
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
// 要送信元変更
   if(mb_send_mail($address,$title,$str,"From: info@gmail.ne.jp")){
//   if(mb_send_mail("hayashida.akademeia@gmail.com","たいとる","本文","From: info@gmail.ne.jp")){
    return "メールが送信されました。";
  } else {
    return "メールの送信に失敗しました。";
  }
}

/* ----------------------------------------------
 *		表示::ブラウザにvar_dump
 ----------------------------------------------*/
public  function varDump($var){
  highlight_string("<?php\n" . var_export($var, true)."\n?>");print "<br>";
}

/* ----------------------------------------------
 *		表示::ブラウザにphpファイル全部
 ----------------------------------------------*/
public function srcCode($page){
  //ini_set('highlight.bg', '#6ff;'); // 背景色??? 変わらない(´･_･`)
  ini_set('highlight.default', '#99f;'); // ソース
  ini_set('highlight.html', '#ccc;'); // HTML
  ini_set('highlight.comment', '#3c3;'); // コメント
  ini_set('highlight.string', '#c66;'); // クォートで囲んだ文字列
  ini_set('highlight.keyword', '#f0c;'); // キーワード
//  highlight_file("test.php");
  highlight_file($page);
}

/* ----------------------------------------------
 *		表示::カレンダー
 ----------------------------------------------*/
public function calendar($year,$month){
			$youbi = array("日","月","火","水","木","金","土");
			$y = $year;
			$m = $month;
			$d = 1;
			$dn =mktime(0,0,0,$m,$d,$y);
			$dE = date("t",$dn);
			print('<table border="1" style="background-color:#fff;"><tr>');
			print("<th colspan=\"7\">".$y."-".$m."</th></tr><tr>");
			for($i=0;$i<7;$i++){
				print("<th>".$youbi[$i]."</th>\n");
				if($i==6){
					print("</tr><tr>");
				}
			}
			for($in=0;$in<date("w",$dn);$in++){
				print("<td></td>\n");
			}
			for($j=1;$j<=$dE;$j++){
				if(date("w",mktime(0,0,0,$m,$j,$y))==6){
					print("<td>".$j."</td>\n</tr>\n<tr>\n");
				}else{
					print("<td>".$j."</td>");
				}
			}
			for($in=0;$in<(7-((date("w",$dn)+$dE)%7));$in++){
				print("<td></td>\n");
			}
			print('</table>');
}


/* ----------------------------------------------
 *		確認::メールアドレス
 ----------------------------------------------*/
public function isMail($mail){
	$i="/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
	if(preg_match($i, $mail)){
    return TRUE;
  }else{
    return FALSE;
  }
}

/* ----------------------------------------------
 *		確認::パスワードチェック
 ----------------------------------------------*/
public function isPass($pass){
	if(ctype_alnum($pass)){
		if(6<=mb_strlen($pass) && mb_strlen($pass)<=8){
			return NULL;
		}else{
			return "パスワードが6~8文字以外です";
		}
	}else if(!empty($pass)){
		return "パスワードに英数字以外が含まれています！";
	}
}

/* ----------------------------------------------
 *		デバッグ::ログファイル作成及び追記
 ----------------------------------------------*/
public function debugAdd($file,$str){
  $time= date('Y/m/d  H:i:s');
//  $a=  "/*-------------------------------------*/ \n";
//  $a=  "";
//  $fp = fopen($file, "a");
//  fwrite($fp, $time."\n　".$str."\n".$a);
//  fclose($fp);

$timeF= date('Ymd');
$year= date('Y');
$dir = './debug/'.$year;
$file= $dir."/".$timeF.$file;
$fd="";
$cnt= 0;

// ディレクトリの有無確認
if (file_exists($dir)) {
//    echo $dir." が存在します";
} else {
//    echo $dir." は存在しません";
  mkdir($dir, 0755, true);
}
// 行数を取得
if(@!file($file)){
  $cnt=1;
}else{
  $fd= file($file);
  $cnt += (sizeof($fd)+1);
}
//print $cnt;

// ファイルをオープンして既存のコンテンツを取得
$current = @file_get_contents($file);
// 新しいデータをファイルに追加
$current = $cnt." : ".$time."  ".$str."\n".$current;
// 結果をファイルに書き出す
file_put_contents($file, $current);
  
}

/* ----------------------------------------------
 *		表示::ログファイル表示(パス要確認)
 ----------------------------------------------*/
public function debugParam($file){
  $fp = fopen($file, "r");
  while ($line = fgets($fp)) {
    echo "$line<br>";
  }
  fclose($fp);
}

/************************
*  POSTデータチェック
*************************/
public function po(){
    print  '<span style="color:#f66;">[POST]</span><br>'.PHP_EOL;
  if(!empty($_POST)){
    print_r($_POST);
    print "<br>".PHP_EOL;
//    var_dump($_POST);
//    MHclass::varDump($_POST);
  }else{
    echo "無し<br>".PHP_EOL;
  }
}

/************************
*  SESSIONデータチェック
*************************/
public function se(){
  print  '<span style="color:#f66;">[SESSION]</span><br>'.PHP_EOL;
  if(!empty($_SESSION)){
    print_r ($_SESSION);
//    MHclass::varDump($_SESSION);
  }else{
    echo "無し<br>".PHP_EOL;
  }
}

/************************
*  FILESデータチェック
*************************/
public function fi(){
    print  '<span style="color:#f66;">[FILES]</span><br>'.PHP_EOL;
  if($_FILES){
    print_r($_FILES);
    print "<br>".PHP_EOL;
  }
}

/************************
 *	サニタイズ
*************************/
public function h($str){
	return htmlspecialchars($str,ENT_QUOTES);
}

public function haveData($sessionStr){
  return (!empty($sessionStr)) ? htmlspecialchars($sessionStr,ENT_QUOTES) : "";
}



}
?>