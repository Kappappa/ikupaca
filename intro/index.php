<?php
session_start();
ini_set( 'display_errors', 1);

// PDO接続
include_once("../inc/config.php");
// Class
include_once("../inc/MHClass.php");
  $m = new MHClass;
// POSTデータチェック
//  $m -> po();
//SESSIONデータチェック
//  $m -> se();
//サニタイズ
//  $m -> h($str);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>サイト紹介</title>
<link rel="shortcut icon" href="../images/faviconB.ico">
<link rel="apple-touch-icon-precomposed" href="http://nekomemo.chobi.net/_ikupaca/images/ikupaca_logo.jpg">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="../css/reset.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<!--<link rel="stylesheet" type="text/css" href="../css/admin.css">-->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
//初期化
var mapi = 1; // MAP用のナンバリング
var id ="";
var name = "";
var comment = "";
var ad = "";
var ad2= "";
var tel = "";
var blog = "";
var maps =""
var int = new Array(); 
var str=""
var description=""

function maping(id,name,ad,tel) {
  /*----- 仮の位置を定義 -----*/
  var latlng = new google.maps.LatLng(35,135);
  /*----- ベースマップのオプション定義 -----*/
  var myOptions = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  /*----- スタイルを定義 -----*/
    var styles = [
        {
            "featureType": "road.local",
            "elementType": "geometry.fill",
            "stylers": [
                { "color": "#fafafa" }
            ]
        }
    ];
    /*----- スタイル名の指定 -----*/
  var styleName = 'MyStyle';
  /*----- マップの描画 -----*/
  var map = new google.maps.Map(document.getElementById(id), myOptions);
  /*----- スタイルの適用 -----*/
    map.mapTypes.set(styleName, new google.maps.StyledMapType(styles, { name: styleName }));
    map.setMapTypeId(styleName);
  /*----- アイコンの定義 -----*/
    var icon = new google.maps.MarkerImage(
        '../images/ikupaca_logo_flag.png',
        new google.maps.Size(35,47),
        new google.maps.Point(0,0)
    );
  /*----- アイコンのオプション定義 -----*/
    var markerOptions = {
        icon: icon,
        position: latlng,
        map: map,
        title: name
    };
  /*----- マーカー描画 -----*/
  var marker = new google.maps.Marker(markerOptions);
  /*----- インフォウィンドウ ------*/
  var content = '<div class="ShowWindow">' +
    '<h2>' + name + '</h2>' +
    '<p>' + ad + '</p>' +
    '<p>' + tel + '</p>' +
    '</div>';
  var ShowWindow = new google.maps.InfoWindow({
    content: content
  });
  google.maps.event.addListener(marker, 'click', function() {
    ShowWindow.open(map, marker);
  });
  
  /*----- ジオコーディングを定義 -----*/
  var geocoder = new google.maps.Geocoder();
  /*----- ジオコーディングを実行 -----*/
  geocoder.geocode({
    'address': ad,
    'region': 'jp'
  },function(results, status){
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      marker.setPosition(results[0].geometry.location);
    }
  });
  mapi++;
}

// 紹介文 (div.intro)
function introR(int){
//  console.log(int["name"]);
  if(!int["ad2"]){int["ad2"]=""}
  if(!int["description"]){int["description"]=""}
  var str= '<dl><dt>' + int["name"] + '</dt><dd class="ad">'+int["comment"]+'</dd><dd>'+int["ad"]+int["ad2"]+'</dd><dd>'+int["tel"]+'</dd><dd>'+int["description"]+'</dd><dd class="bl">'+int["blog"]+'</dd></dl>'
  return (str);
}

</script>
</head>

<body>
<article>

<header>
    <h1 class="header">サイト紹介
<!--      <img class="logo" src="../images/ikupaca_logo.png" alt="ikupaca">-->
    </h1>
    <hr>
<!--サイトマップ-->
    <div class="navi">
     <ul>
      <li id="n2"><a href="../index.php">Home</a></li>
      <li id="n3"><a href="../profile.php">Profile</a></li>
      <li id="n0"><a href="../custommade/index.php">カスタムメイド</a></li>
      <li id="n4"><a href="../works.php">ギャラリー</a></li>
      <li id="n5"><a class="now" href="">お店紹介</a></li>
      <li id="n9"><a href="../event.php">イベント</a></li>
      <li id="n6"><a href="http://ameblo.jp/koharu-biyori-rena/" target="_blank">ブログ</a></li>
      <li id="n7"><a href="https://www.facebook.com/ikupaca" target="_blank">facebook</a></li>
      <li id="n1"><a href="https://instagram.com/IKUPACA/" target="_blank">Instagram</a></li>
      <li id="n8"><a href="../contact.php">お問合わせ</a></li>
<!--      <li><a href="">チームikupaca</a></li>-->
<!--      <li><a href="">Access</a></li>-->
    </ul>
    </div>
    <hr>

</header>
<!-- header class="header" -->

<main id="mainpage">

<h2>ikupacaは、<br>こちらのお店を応援しています！！</h2>
<img class="logo" width="60" src="../images/ikupaca_logo_flag2.png" alt="ikupaca">
<hr>

<div class="intro"> 
<script type="text/javascript">
  name = "Copain=A3(コパン)【京都】";
  comment = "宇治橋商店街にある可愛い雑貨屋さんです。";
  ad = "〒611-0021 京都府宇治市宇治壱番3";
  tel = "TEL : 0774-24-3548";
  blog = 'ブログ : <a href="http://copain1.blog78.fc2.com/" target="_blank">Copain=A3</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"tel":tel,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<ul class="fl">
  <li class="intro_app"><img width="100%" src="./images/copain1.jpg" alt="copain1"></li>
  <li class="intro_int"><img width="100%" src="./images/copain2.jpg" alt="copain2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">


<div class="intro"> 
<script type="text/javascript">
  name = "ラ・カフェケニア京都店【京都】";
  comment = "JR・地下鉄・近鉄京都駅から歩いて５分。<br>キャンパスプラザ京都の１階にあります。<br>会議・研修後のご休憩などにぜひご利用ください。";
  ad = "〒600-8216 京都府京都市下京区西洞院通塩小路下る東塩小路町939";
  tel = "TEL : 075-353-9150";
  blog = 'サイト : <a href="http://k-kenya.sakura.ne.jp/shop/shop-kyoto.html" target="_blank">ラ・カフェケニア京都店</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"tel":tel,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<ul class="fl">
<!--  写真の高さは300px-->
  <li class="intro_app"><img width="100%" src="./images/cafe_kyoto1.jpg" alt="ラカフェケニア京都店1"></li>
  <li class="intro_int"><img width="100%" src="./images/cafe_kyoto2.jpg" alt="ラカフェケニア京都店2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">

<div class="intro"> 
<script type="text/javascript">
  name = "Reos 槇島【京都】";
  comment = "親子や高齢者など地域でのコミュニティの場です。地域の農家さんたちの協力で食育実践を目指し、自家農家(Reos畑)で野菜を作っています。ランチでは主にReos畑で採れた、新鮮・無農薬野菜を使用しています。子育て支援もしております。<br>営業時間11：30～16：30(定休日：土日祝日)";
  ad = "〒611-0041 宇治市槇島町十一173-1 サンジェルマン1F";
  tel = "TEL : 0774-66-1849";
  blog = 'サイト : <a href="http://www.reos-makishima.com/index.html" target="_blank">Reos 槇島</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"tel":tel,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<ul class="fl">
<!--  写真の高さは300px-->
  <li class="intro_app"><img width="100%" src="./images/reos1.jpg" alt="Reos 槇島1"></li>
  <li class="intro_int"><img width="100%" src="./images/reos2.jpg" alt="Reos 槇島2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">


<div class="intro"> 
<script type="text/javascript">
  name = "ヘアサロン e-ne【兵庫】";
  comment = "e-neはエキテン口コミランキングで神戸1位を獲得した美容室です。<br>100坪のアジアンリゾート風の店内はゆったりとした癒しの空間です。";
  ad = "〒651-2144 兵庫県神戸市西区小山1-7-9";
  tel = "TEL : 078-921-1155";
  blog = 'サイト : <a href="http://www.e-ne.org/" target="_blank">神戸市西区ヘアサロン e-ne</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"tel":tel,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<dl>
<dd class="ad">また、e-neでは医療用wigを取り扱っております。<br>怪我や病気、抗ガン剤治療などの影響でお悩みの方の相談もお受けします。</dd>
<dd class="bl">サイト：<a href="http://www.e-ne.org/wig_top.html" target="_blank">医療用wig</a></dd>
</dl>
<dl>
<dd class="ad">e-ne美容室ikupacaページもあります。</dd>
<dd class="bl">サイト：<a href="http://www.e-ne.org/ikupaca.html" target="_blank">ikupacaページ</a></dd>
</dl>
<ul class="fl">
<!--  写真の高さは300px-->
  <li class="intro_app"><img width="100%" src="./images/hairsalon_e-ne1.jpg" alt=" ヘアサロン e-ne1"></li>
  <li class="intro_int"><img width="100%" src="./images/hairsalon_e-ne2.jpg" alt="ヘアサロン e-ne2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">

<hr class="hid">

<div class="intro"> 
<script type="text/javascript">
  name = "Ten Ants【京都】";
  comment = "アーティストと呼ばれるすべての人たちを応援する店Ten Antsが移転しました！広くなって貸しスペースなども充実です！";
  ad = "〒606-8116京都府京都市左京区一乗寺宮ノ東町47アイバハウス1階";
  ad2= "";
  tel = "TEL : 075-741-6859";
  description = 'メール : <a href="mailto:mamimumemorita@me.com">mamimumemorita@me.com<a></dd><dd class="ad">営業時間</dd>';
  description +='<dd>お店10時〜18時<br>貸しスペースは10時〜21時要相談</dd>';
  description +='<dd class="ad">定休日</dd><dd>火曜日</dd><br><dd>イベントの無い日(女性限定)<br>11時〜14時奥のスペース開放してます！赤ちゃん連れのお母さんおばあちゃんどうぞ！';
  blog = 'サイト : <a href="http://amdblo.jp/mami-101010/" target="_blank">Ten Ants</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"ad2":ad2,"tel":tel,"description":description,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<ul class="fl">
<!--  写真の高さは300px-->
  <li class="intro_app"><img width="100%" src="./images/TenAnts1.jpg" alt="TenAnts1"></li>
  <li class="intro_int"><img width="100%" src="./images/TenAnts2.jpg" alt="TenAnts2"></li>
<!--
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
-->
</ul>
</div>
<hr class="hid">

<div class="intro"> 
<script type="text/javascript">
  name = "甘さをおさえた雑貨と古道具 bitter【大阪】";
  comment = "";
  ad = "〒573-0057大阪府枚方市堤町10-24鍵屋別館1階101";
  ad2= "(入ってすぐのお店です)";
  tel = "TEL : 090-9994-9490";
  description = '</dd><dd class="ad">営業時間</dd>';
  description +='<dd>12:00〜17:00<br>貸しスペースは10時〜21時要相談</dd>';
//  description +='<dd class="ad">定休日</dd><dd>月曜日・日曜日</dd><dd>(※毎月第2日曜日の五六市の日はオープンしています)';
  description +='<dd class="ad">定休日</dd><dd>不定休（営業日カレンダーを確認下さい）</dd><dd>(※毎月第2日曜日の五六市の日はオープンしています)';
  blog = '';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"ad2":ad2,"tel":tel,"description":description,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<dl>
<dd class="ad">bitterさんのある鍵屋別館の詳しい情報。</dd>
<dd class="bl">サイト：<a href="http://www.kagiyabekkan.jp/index.html" target="_blank">鍵屋別館</a></dd>
</dl>
<dl>
<dd class="ad">bitterさんのお店情報。</dd>
<dd class="bl">サイト：<a href="http://www.hira2.jp/archives/50304590.html" target="_blank">枚方通信</a></dd>
</dl>
<ul class="fl">
<!--  写真の高さは300px-->
  <li class="intro_app"><img width="100%" src="./images/bitter1.jpg" alt="bitter1"></li>
  <li class="intro_int"><img width="100%" src="./images/bitter2.jpg" alt="bitter2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">


<div class="intro"> 
<script type="text/javascript">
  name = "HOWBI 【兵庫】";
  comment = "";
  ad = "〒675-1327兵庫県小野市市場町651";
  ad2= "";
  tel = "TEL : 090-8375-4085";
  description = '</dd><br><dd class="">神戸電鉄市場駅から徒歩7分。<br>山陽自動車道三木小野インター降りて小野方面。<br>一つ目の信号市場東を左折。<br>ローソンの信号を右折次の信号市場北の角です。<br>駐車場は歩道橋越えてすぐ左折ナルミ株の倉庫裏に11台。<br>土日祝はHOWBIすぐ裏に駐車場をご用意しております。</dd><br>';
  description += '</dd><dd class="">HOWBI(ほうび)とは<br>HOuse<br>Wood<br>BIrd<br>の頭文字をとった造語です。<br>House…落ち着く空間<br>Wood…自然な空間<br>Bird…自由な空間<br>自分へのごほうびにおくつろぎください！がコンセプトです。<br>HOWBIに来た人がイキイキパワフルである空間<br>みんなが笑顔になる空間<br>おもろい空間を作っています！</dd><br>';
  description += '</dd><dd class="ad">営業時間</dd>';
  description +='<dd>10時から17時<br>金・土は夜カフェ18時半から22時</dd>';
  description +='<dd class="ad">定休日</dd><dd>不定休（木曜日）';
  blog = '';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"ad2":ad2,"tel":tel,"description":description,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<dl>
<dd class="bl">サイト：<a href="https://www.facebook.com/HOWBI-1376252502698035/timeline" target="_blank">facebook</a></dd>
</dl>
<ul class="fl">
  <li class="intro_app"><img width="100%" src="./images/howbi1.jpg" alt="howbi1"></li>
  <li class="intro_int"><img width="100%" src="./images/howbi2.jpg" alt="howbi2"></li>
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
  </li>
</ul>
</div>
<hr class="hid">






</main>

<?php include_once("../tmp/footer.php"); ?>

<div class="pagetop" style="position:fixed;right:5px;bottom:80px;"><a href="#mainpage"><img width="80" src="../images/top.png" alt="↑"></a></div>
</article>

<script type="text/javascript">
$(document).ready(function() {
  var pagetop = $('.pagetop');
  pagetop.hide();
    $(window).scroll(function () {
       if ($(this).scrollTop() > 400) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});

</script>




</body>
</html>