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
<script type="text/javascript">
//初期化
var mapi = 1; // MAP用のナンバリング
var id ="";
var name = "";
var comment = "";
var ad = "";
var tel = "";
var blog = "";
var maps =""
var int = new Array(); 
var str=""

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
        title: 'Copain=A3'
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
  var str= '<dl><dt>' + int["name"] + '</dt><dd class="ad">'+int["comment"]+'</dd><dd>'+int["ad"]+'</dd><dd>'+int["tel"]+'</dd><dd class="bl">'+int["blog"]+'</dd></dl>'
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
      <li class="now"><a href="">サイト紹介</a></li>
      <li><a href="../index.php">Home</a></li>
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
  name = "Copain=A3(コパン)";
  comment = "宇治橋商店街にある雑貨屋さんです。";
  ad = "〒611-0021 京都府宇治市宇治壱番3";
  tel = "TEL : 0774-24-3548";
  blog = 'ブログ : <a href="http://copain1.blog78.fc2.com/" target="_blank">Copain=A3</a>';
  
  id ="map_basic"+ mapi;
  maps = '<div id="'+id+'" style="width: 100%; height: 300px;"></div>';
  int = {"name":name,"comment":comment,"ad":ad,"tel":tel,"blog":blog}; 
  document.write(introR(int));int="";
</script>
<ul class="fl">
  <li class="intro_map">
<script type="text/javascript">
document.write(maps);
maping(id,name,ad,tel);
</script>
</li>
<!--  写真の高さは300px-->
<!--  <li class="intro_app"><img width="100%" height="300px" src="../images/bg.jpg" alt="test"></li>-->
  <li class="intro_app"><img width="100%" src="../images/bg.jpg" alt="test"></li>
  <li class="intro_int"><img width="100%" src="../images/bg.jpg" alt="test"></li>
</ul>
</div>
<hr class="hid">







</main>

<?php include_once("../tmp/footer.php"); ?>
</article>
</body>
</html>