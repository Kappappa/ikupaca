# ikupaca  
----  
ikupaca    
author: Kappappa  
Date: 2015/08/24  
----  
    適当に  
    ゆるく  
    のんびり  
ゆったり開発中…  

###サイト使用量  
> 2015-12-06_05:26  
> 30.8MB / 100MB  

---  
  
  
## 進捗　　

### 2016-01-23  
年末から年始のタイミングで少し作成


### 2015-12-17  
少し更新
> ./inc/admin/pdoClass.php  

addInsert()  紹介サイト追加  
addSelect()  紹介サイト一覧表示  
addEdit()    選んで参照  

次は、選んだのをUPDATE  
addUpdate()の予定  

そして削除DELETE  
addDelete()予定  



### 2015-12-06  
calendarをDB化  
紹介サイトをDB化  
`テーブル作成`  
`管理画面で制御`  

> ./inc/admin/image.php  
> ./inc/admin/pdoClass.php  

紹介サイトは…
１０月中旬に構想を練ってて過去ログにあった…   
*DB_addAccess*
このままではちょっとアレなんで、要打ち合わせ。

打ち合わせ終了  
#### DB_addAccess  
> id             : int(10)      : ID  
> date           : datetime     : 日付  
> site_name      : varchar(255) : サイト名  
> site_comment   : text         : サイト紹介  
> ad_id          : int(11)      : 郵便番号  
> ad             : varchar(255) : 住所  
> tel            : int(11)      : 電話番号  
> site           : varchar(255) : サイト名  
> url            : varchar(255)   : サイトURL  
> name           : varchar(255) : ファイル名  
> type           : tinyint(2)   : IMAGETYPE定数  
> raw_data       : mediumblob   : 原寸大データ  
> thumb_data     : blob         : サムネイルデータ  
> flag           : tinyint(2)   : 使用:1,不使用:0  

### 2015-12-05
calendar追加（画像）

### 2015-11-15
作品紹介を登録制に…
  -> admin/image.php  
  -> works.php  

### 2015-10-18  
この１ヶ月ほど進捗状況更新出来てないが…  
トップ画像の登録(複数OK)と画像のON/OFF切り替え及び削除機能追加  

#### DB_topImage  
> id         : int(10)      : ID  
> name       : varchar(255) : ファイル名  
> date       : datetime     : 日付  
> flag       : tinyint(2)   : 使用:1,不使用:0  
> type       : tinyint(2)   : IMAGETYPE定数  
> raw_data   : mediumblob   : 原寸大データ  
> thumb_data : blob         : サムネイルデータ  

あとmarkdownでの記述で記録していこうかと。  

本日の予定は、サイト紹介をDB作成まで。  

#### DB_addAccess  
> id             : int(10)      : ID  
> date           : datetime     : 日付  
> name           : varchar(255) : サイト名  
> comment        : text         : サイト紹介  
> ad_id          : int(11)      : 郵便番号  
> ad             : varchar(255) : 住所  
> tel            : int(11)      : 電話番号  
> category       : varchar(255) : カテゴリー  
> site           : varchar(255) : サイト名  
> url            : tinyint(2)   : サイトURL  
> app_name       : varchar(255) : 外観画像名  
> app_type       : tinyint(2)   : IMAGETYPE定数  
> app_raw_data   : mediumblob   : 原寸大データ  
> app_thumb_data : blob         : サムネイルデータ  
> int_name       : varchar(255) : 内観画像名  
> int_type       : tinyint(2)   : IMAGETYPE定数  
> int_raw_data   : mediumblob   : 原寸大データ  
> int_thumb_data : blob         : サムネイルデータ  

今後の予定は、DBへ登録した分の表示を切り替え。  
表示したいところだけをWHILEでまわして表示。  

そんな感じでよろしくメカドック！！！  

### 2015-09-18
#### トップページ変更  
背景色変更(クリーム色)
> -> background-color: rgba(255, 238, 180, 0.75);  
> -> background-color: rgb(255, 254, 241);  

どっちが良いか検討中…
>４カラム -> 3カラム  
>headerのカテゴリをカラフルに  

#### profileサイト作成
> 写真追加  
>レイアウト変更  

#### 作品紹介

---  
###### これより下はmarkdown方式知らなかったので…  
###### 視認性皆無…(苦笑)  
###### また気が向いたら直します…  
---  

2015-09-17
　・profileサイト作成。
　・トップページ、一時解放
　　:: 再度工事中。
　・サイトカラー確認
　・スタイルシート変更
　・お問い合わせ転送先変更
　　-> ikupaca@gmail.com
　・トップページ変更
　　:: スクリーン画像差し替え
　　:: header変更
　　:: 背景色変更
　　:: ４カラム -> 3カラム(途中)

2015-09-16
　・サイト紹介更新。
　　順次追加。
　　サイトが下に長くなったので、トップに戻るボタン追加

2015-09-15
　・サイト紹介更新。
 　　Copain=A3さんの外観と店内写真を追加


2015-09-13
　・つぶやき編集画面作成
　　-> ./admin/twadd.php

2015-09-12
　・トップページにサイト紹介リンク付与
　　# index.php
　・サイト紹介ページ作成
　　# ./intro/index.php
 　　地図表示(JavaScript、google Map APIを使用)
　　-> 地図上のピンをににの画像に置き換え
　　-> 画像をタップすると説明文を表示
　・Gitによるバージョン管理
　　-> https://github.com/Kappappa/ikupaca

2015-09-11
　・サイト紹介フォルダー作成(./intro)

2015-09-09
　[紹介サイト]
　・コンテ確認

2015-09-06 04:03:21
　[変更及び追加情報]
　・この新着情報の内容入力が250文字まででした。
　　-> 無制限に変えています。
　　# DB::News
　　# varchar(250) -> text
　　-> それに伴い、以前のデータを削除しています。
　　# 別ファイルに内容は保管しています。

　・投稿フォームを追加しました
　　-> すぐに使用出来ます。
　　-> 要メールアドレス登録
　　　# 現状は私のアドレスを登録
　　　# 即変更が可能です

2015-09-05
　・予定…
　　つぶやき投稿画面及び編集(削除)画面
　　画像の削除(無くても別に…)
　　問い合わせフォーム

2015-09-05 03:00:00
　[画像が追加出来ない]
　・写真サイズを200KB程度にするとエラー回避。
　・一度スクショしてから添付。

2015-09-04
・画像登録エラー対応
　　transaction -> commit を追加

2015-09-03 10:24:03
　[Webフォントについて]
　・開発時はデフォルト設定とし、一時的に解除しています。
　　:: 通信量低減及び通信速度向上の為

2015-09-02 08:19:10
　・ログイン画面にCookie追加
　　　管理画面へ遷移する際に入力がわずらわしかったのでデータ保存を各端末に埋め込んでます。
　　　当該端末で２週間ログインが無ければ自動的に消えます。

2015-09-02 02:03:59
　・画像保存及び一覧作成
　　　一時的に画像を保管しておくところです。
　　　今のところ削除出来るようには出来ていません。
　　　# ./admin/image.php
　　　# ./admin/imageAll.php

2015/09/01 07:51:23
・新着情報にタイトルデータを付与するのを忘れt…
修正しました。
・新着情報に[new]追加
1週間で自動的に無くなります。

2015-08-31 12:38:45
　・新着情報編集を追加。
　　　新着情報を編集及び削除が可能になりました。
　・Webフォントを試用。
　　　やはり文字の表示が遅く思います。

20150830
　・新着情報の追加及び編集画面作成
　　# ./admin/news.php
　　# ./admin/newsEdit.php

20150829
　・管理画面及び設定ファイル作成
　　# ./inc/admin/config.php
　　# ./inc/admin/pdoClass.php

20150825_0300
　・サイト設置
　　　気付いたのが 0130 であったため return null ってます
　　　-> 朝に確認事項とともに要連絡
　・管理画面ログイン実装
　・新着情報_投稿画面 -> 着手

20150824_2250
　・おおまかなHome画面作成
　・リンク貼り付け(遷移ではなく別窓対応)
　・アイコン作成(タブ画像&スマホ登録画像)
　・Home画面での画像スライドショー機能実装

[依頼]
　・keywords -> 確認 -> OK
　・description -> 確認 -> OK
　・サイトカラーの選択 -> 確認中
　・header画像について -> 未確認 = "ステッチの付与について"

[予定]
　・作品紹介はHTMLファイルで…
　・新着情報は文字のみ
　・つぶやきは写真付き(1枚)
　・管理画面は"./admin/index.php"でログインする


//----------------------------------------------
//   初期構想
//----------------------------------------------

・Top画面(PHP)
　リンク
　作品紹介(HTML? PHP?)
　チームikupaca(HTML)
　プロフィール(HTML)
　アクセス(HTML)

　新着情報(PHP && PDO->MySQL)
　つぶやき(PHP && PDO->MySQL)

・リンク
　アメブロ
　Facebook
　Instagram

・管理画面
　ログイン画面
　　_新着情報編集画面 [news]
　　　ID(連番) news_id
　　　日付 news_create_time
　　　タイトル news_title
　　　内容 news_text

　　_つぶやき編集画面 [tw]
　　　ID(連番) id [int(10)]
　　　日付 time [datetime]
　　　タイトル title [varchar(100)]
　　　内容 text [text]
　　　画像名 name [varchar(255)]
　　　画像タイプ type [tinyint(2)]
　　　生データ raw_data [mediumblob]
　　　サムネイル画像 thumb_data [blob]
