<?php

include_once('./inc/uno.class.php');
$DB= new Uno();
// テーブル追加
$DB->tableCreate();

// 表示のみ($flag:1)
$image_flag= array(1);
$topOnImages= $DB-> selectTopImages(1,$image_flag,4);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>fileMove</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="./css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script type="text/javascript" src="./js/jquery.js"></script>
  <script src="./js/jquery.bxslider.min.js"></script>
<!--  <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>-->
  <script type="text/javascript">
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                auto: true,
            });
        });
</script>
</head>
<body>
  <header>
    <h1>test</h1>
    <p></p>
  </header>
  <main>
    <p><a href="./admin/">admin</a></p>
    
    
  <div class="wrapper">
    <div class="content">
     
      <div class="images">
        <ul class="bxslider">
<?php
// 表示
if($topOnImages){
  foreach($topOnImages as $key => $val){
//    $ViewImage= "./admin/".$val["file_name"];
    $ViewImage= "./top/".$val["file_name"];
    $id= $val["id"];
    echo '<li><img src="'.$ViewImage.'" alt="top'.$id.'" title="topImage'.$id.'"></li>'.PHP_EOL;
  }
}else{
  echo "画像はありません";
}
?>
        </ul>
      </div>
      
    </div>
  </div>
    
    
    
    
    
  </main>
  <footer>
    <p></p>
  </footer>
</body>
</html>