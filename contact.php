<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>contact</title>
<meta name="Description" content="">
<meta name="Keywords" content="">
<link rel="stylesheet" type="text/css" href="./css/reset.css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/admin.css">
<style type="text/css">
*{
  font-size: 0.6rem;  
}
body{
    width:100%;
}
#formWrap {
	width:700px;
	margin:0 auto;
	color:#555;
	line-height:1.3;
	font-size:0.8rem;
}
table.formTable{
	width:90%;
	margin:0 auto;
	border-collapse:collapse;
}
table.formTable td,table.formTable th{
	border:3px solid #ccc;
	padding:5px;
  font-size: 0.8rem;  
}
table.formTable th{
	width: 30%;
	font-weight:normal;
	background:#efefef;
	text-align:left;
}
option{
  padding:  0.5rem;
}
  
input[type="text"] {
  padding:  3px;
  font-size: 0.8rem;
}
  
  

@media (max-width: 700px) {

#formWrap {
	width:380px;
  font-size: 0.7rem;
}
  
table.formTable td,table.formTable th{
	border:1px solid #ccc;
	padding:5px;
  font-size: 0.6rem;  
}
table.formTable th{
	width: 35%;
	font-weight:normal;
	background:#efefef;
	text-align:left;
}

  
  
}
</style>
</head>
<body>
<div id="formWrap">

<main>
  <header>
    <h1 class="header">ikupaca</h1>
    <hr>
  </header>
  <br>
  <h3>[お問い合わせ]</h3><br>
  <p>下記フォームに必要事項を入力後、<br>　確認ボタンを押してください。</p>
  <form method="post" action="post.php">
    <table class="formTable">
      <tr>
        <th>ご用件</th>
        <td><select name="ご用件">
            <option value="">選択してください</option>
            <option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
            <option value="リンクについて">リンクについて</option>
          </select></td>
      </tr>
      <tr>
        <th>お名前</th>
        <td><input size="20" type="text" name="お名前" /> <br>※必須</td>
      </tr>
      <tr>
        <th>電話番号<br>（半角）</th>
        <td><input size="30" type="text" name="電話番号" /></td>
      </tr>
      <tr>
        <th>Mailbr<br>（半角）</th>
        <td><input size="30" type="text" name="Email" /><br> ※必須</td>
      </tr>
      <tr>
        <th>性別</th>
        <td><input type="radio" id="m" name="性別" value="男" /> <label for="m">男</label>　
          <input type="radio" id="f" name="性別" value="女" /> <label for="f">女</label> </td>
      </tr>
      <tr>
        <th>サイトを知った<br>きっかけ</th>
        <td><input name="サイトを知ったきっかけ[]" id="fr" type="checkbox" value="友人・知人" /> <label for="fr">友人・知人</label>　
          <input name="サイトを知ったきっかけ[]" id="en" type="checkbox" value="検索エンジン" /> <label for="en">検索エンジン</label></td>
      </tr>
      <tr>
        <th>お問い合わせ内容<br /></th>
        <td><textarea name="お問い合わせ内容" cols="50" rows="5"></textarea><br>※必須</td>
      </tr>
    </table>
    <br>
    <p align="center">
      <input type="submit" value="確認">
    </p><br>
    <p align="center">
      <input class="redButton" type="button" onclick="location.href='./index.php'" value="   戻る   ">
    </p>
  </form>
</main>
<!--  <p>※IPアドレスを記録しております。いたずらや嫌がらせ等はご遠慮ください</p>-->

</div>
<br><br><br>
</body>
</html>