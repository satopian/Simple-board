# お絵かき掲示板PHPスクリプト Petit Note
- 1スレッド1ログファイル形式のスレッド式の画像掲示板です。  
- PaintBBS NEOとChickenPaintが使えるお絵かき掲示板です。

##  'v0.9.16.x';以前のPetit Noteをご利用の方へのお願い

## 個別スレッドのファイルの編集時にファイルロックがかかっていませんでした。
このバグによりログが破損する可能性があります。
通常は編集、または書き込みが同時に行われても一瞬でも先にファイルを開いた側が他からファイルを読み込めないようにロックします。 
そのロック処理が二箇所抜けていました。
その他の機能追加が特に必要ではない方もアップデートをお願いします。    

## v0.9.8.7.2以前のPetit Noteをご利用の方へのお願い

- テーマのHTMLの｢BASIC｣ディレクトリと、index.php、functions.php、config.php、thumbnail_gd.phpの更新が必要です。  
セキュリティリスクを回避するためアップデートをお願いします。


## ダウンロード

- [リリース](https://github.com/satopian/Petit_Note/releases)から安定版をダウンロードできます。

## DEMO
- [Petit Note](https://paintbbs.sakura.ne.jp/cgi/neosample/petitnote/)  
- [イラスト投稿サイトPetit Note](https://paintbbs.sakura.ne.jp/petit/)
  
![image](https://user-images.githubusercontent.com/44894014/134553433-d50e05be-a483-4b94-a575-3cead96b6720.png)

## 履歴

## PitNoteとは
- 1スレッド1ログファイル形式のスレッド式の画像掲示板です。  
- PaintBBS NEOとChickenPaintが使えるお絵かき掲示板です。

##  22/02/12 v0.9.18.0
## 個別スレッドのファイルの編集時にファイルロックがかかっていませんでした。
このバグによりログが破損する可能性があります。
通常は編集、または書き込みが同時に行われても一瞬でも先にファイルを開いた側が他からファイルを読み込めないようにロックします。 
そのロック処理が二箇所抜けていました。
その他の機能追加が特に必要ではない方も、以下の2つのファイルの上書きアップデートをお願いします。    

### 変更があったファイル
- functions.php 
- index.php   

安定版をリリースからダウンロードできます。  
[Petit Note v0.9.18.0 リリース](https://github.com/satopian/Petit_Note/releases/tag/v0.9.18.0)


## 22/01/06 v0.9.12.5

- 編集削除時のパスワードチェック処理を変更しました。レスのログファイルのパスに加えて全体ログのパスワードをチェックするようになりました。

- レス画像から続きを描く時は、新規投稿でもレスになりました。

- レス画面に前のスレッドと次のスレッドが表示されるようになりました。

![image](https://user-images.githubusercontent.com/44894014/151515726-56ed8a8f-0073-4871-baa3-f1338d6f2f94.png)


- 続きから描くからの｢もどる｣のリンク先を該当スレッドに。  
これまでは掲示板のトップページにもどっていました。そのため｢続きを描く｣の画面がGoogle検索でヒットしても、もとのスレッドがどこにあるのかわかりませんでした。  
 
- 画像チェックの負荷を削減しました。

- テンプレートのエスケープ漏れがあってもXSSが実行されないように編集画面の変数をHTMLファイルに渡す前にエスケープしました。  

- iPadの768pxで閲覧時に画像の右側の余白がでないように調整しました。  
768px以上の幅の画像を表示する時は右側のmarginを0にフロートをnoneに。

- 入力文字列、拒絶する文字列どちらからもスペースを除去。拒絶する文字列にスペースがはいっていても機能するようになりました。  
これまでは拒絶する文字列の設定に半角スペース、全角スペースがあると、入力文字列にスペースがあっても拒絶できなくなっていました。  
これは、入力された文字列からスペースや改行をとりのぞいた文字列をチェックしているからです。  
拒絶する文字列に入っているスペースもチェック時に除去する事でこの問題を解決しました。

- 文字化け対策。投稿者名をコピーで使用する時は特殊文字を全角に。  
セキュリティを確保しながらかつ文字化けが最低限になるようにするためHTMLの特殊文字を全角に変換します。 
投稿者名をコピーの箇所のみの対応でそのほかの箇所はもとの入力文字列が表示されます。

- コメントの最小幅を350pxに。
より見やすい画面になりました。

## 2021/12/05 v0.9.9.2
- 英語対応。ブラウザの言語が日本語以外の時は、UIとエラーメッセージを英語で表示します。

### 変更があったファイル
- functions.php 
- index.php 
- picpost.php 

 template/basic/ ディレクトリのすべてのファイル(含むCSS)


### 追加されたファイル
- palette_en.txt 
(英語表示の時のためのパレット)


## 2021/11/27 v0.9.8.28

- sageにチェックが入っていなくても、レスでスレッドがあがらないようにする設定項目を追加しました。
```
//する: trueに設定するとレスがついてもスレッドがあがりません。(全てsage)。
//初期値 false

//$sage_all = true;
$sage_all = false;

```
- HTMLの文法エラーを修正しました。


## 2021/11/23 v0.9.8.26
- chiファイルアップロードペイントファイルの削除処理  
管理者投稿でChickenPaint固有ファイル、chi形式のファイルをアップロードしてキャンバスに読み込んだあとのchiファイルの削除処理が抜けていたのを修正、追加しました。  
今回の修正でアップロードから5分経過していればtempディレクトリから削除されるようになりました。この修正を行う前でも、数日経過すれば不要になったファイルは削除されていました。

- 編集削除のIDとして使っている投稿時間が重複しないように入力値を検証してエラーにする  
同じ記事ナンバーかつ同じタイムスタンプとなる可能性を完全に排除しました。  

- 画像のALT文の見直し。続きを描く時の画像にもイラストのタイトルと作者名  
画像のALT文にタイトルと作者名が入るようになりました。  

- HTMLの文法ミスを修正しました  


## 21/11/13 v0.9.8.18.2
### PaintBBS NEO v1.5.15 の右ボタン常時表示に対応
- PaintBBS NEO v1.5.15 の右ボタン常時表示に対応しました。
`neo.js`と、`paint_neo.html`のアップデートをお願いします。  
また、ブラウザの言語が日本語以外の時に表示されるPaintBBS NEOの英語表記版の半角文字列の改行が意図通りに行われずレイアウトがくずれていたのを修正しました。  
`paint_neo.html`のアップデートをお願いします。

v0.9.8.18.1に更新したファイルが入っていなかったため、改めて更新をお願いします。  


## 21/11/13 v0.9.8.18.1
### picpost.php save.php
- 簡易的なCSRF対策を行いました。  
`picpost.php` `save.php` と、`index.php`のアップデートをお願いします。

- ~~PaintBBS NEO v1.5.15 の右ボタン常時表示に対応しました。~~
~~`neo.js`と、`paint_neo.html`のアップデートをお願いします。~~  
~~また、ブラウザの言語が日本語以外の時に表示されるPaintBBS NEOの英語表記版の半角文字列の改行が意図通りに行われずレイアウトがくずれていたのを修正しました。~~  
~~`paint_neo.html`のアップデートをお願いします。~~


## 21/11/08 v0.9.8.16
### index.php
- Descriptionが長くなりすぎる問題に対応しました。  
これまではスレッドの親のコメント全文がDescriptionに入っていました。

## 21/11/03 v0.9.8.12

- config.phpに新規設定項目追加  
- コメント欄に投稿可能な最大文字数を設定できるようになりました。 
- 投稿できる画像の幅と高さを設定できるようになりました。サイズ超過の時は設定したサイズの範囲内になるように自動的に縮小します。  
index.phpとthumbnail_gd.phpを同時に更新する必要があります。
thumbnail_gd.phpのバージョンが古い時は、バージョンが古いというエラーメッセージがでます。通常通り起動していれば更新に成功しています。

- save.phpを更新しました。ChickenPaintによる投稿の時に画像の幅と高さのサイズ違反をチェックするようになりました。
- picpost.phpを更新しました。PaintBBSNEOによる投稿の時に幅と高さのサイズ違反をチェックするようになりました。
- template/basic/ ディレクトリの index.css を更新しました。長い英数字の時に文字列がコンテナを突き抜けて横に長く表示されてしまう問題を解決しました。

## 21/10/29 v0.9.8.9
- 重大バグ修正 urlの長さチェックを追加しました  
- エラーメッセージurlが長すぎますを追加しました。  

## 21/10/29 v0.9.8.7.2  
ログファイルを外部から直接開かれる事が無いよいうにパーミッションを600にしているログファイルですが、さらに`.htaccess`というファイルを追加して、拡張子がlogのファイルを外部から開けないようにしました。
`.htaccess`を`index.php`と同じディレクトリにアップロードします。

## 21/10/27 v0.9.8.7.1
- 著作リンクを変更しました。templateのリンク先が変わっただけです。  
新url [https://paintbbs.sakura.ne.jp/](https://paintbbs.sakura.ne.jp/petit/)


## 21/10/22 v0.9.8.7
- csv(tsv)としてログファイルを読み込んでいたため、ダブルクォートが入力された時にデータが壊れていました。  
重大なバグですので、アップデートが必要です。

## 21/10/13 v0.9.8.3
- お絵かきアプリの幅と高さのcookieが正しく処理されていなかったのを修正しました。
高さのcookieが反映されていませんでした。
- 画像のファイルサイズが1MBを超えている時は幅と高さが範囲内でもサムネイルを表示する形に変更。
GIFアニメのアップロードを行っても表示が重くならないように。

- 削除時に記事がチェックされていない時はエラー表示にする。
これまでは、記事削除の最終確認のチェックを入れ忘れていた時に何も起こりませんでした。

- 読み込みだけの処理なのにfopenの"r+"で開いている箇所があったのを"r"修正しました。

- 指定日数を超える古い記事の編集禁止。
古いスレッドを閉じる処理はありましたが、編集はできていました。
古い記事の編集はロックされますが、削除はできます。
また管理者は古い記事の編集と削除どちらもできます。

## 21/10/13 v0.9.7.3 
- 新しいスレッドを行末に追加する仕様を変更し行頭に。従来の`alllog.log`を逆順に。  
[v0.9.7で仕様変更、v0.9.6.3以前のalllog.log(全体ログ)の変換が必要になりました。 · Issue #6 · satopian/Petit_Note](https://github.com/satopian/Petit_Note/issues/6)  
ログファイルの変換が必要になりました。  
上記リンク先にログファイルの変換方法の詳細をまとめました。お手数をおかけしますがよろしくお願いいたします。  


## 21/10/11 v0.9.6.3

- 管理者編集モードで編集に失敗するバグを修正。
- 最下部の｢管理｣メニューが2重に表示されるバグを修正。
- 管理パス、第2パス未設定時にはパス不一致とする処理を追加。


## 21/10/11 v0.9.6.1

- 名前の入力を必須にする、しないを設定できるようにしました。
- sage機能を追加しました。
- config.phpに新規設定項目。第2パスワードを使って管理者である事を再確認する処理を追加。 

## 21/10/09 v0.9.3.3

- セキュリティ対策。
- ログイン時にsessionIDを再発行してsession固定攻撃対策。
- 編集･削除時にcsrfによる処理が行われないようにトークンをセット。  
これまでは、削除の時にはトークンがセットされていませんでした。
- sessionのクッキーの範囲を掲示板のカレントディレクトリに限定。  
これまでは複数設置したPetit Noteのモードが同時に変更されていました。  
操作する人は同じ人とはいえ、他のディレクトリのアプリに影響がでるのはよくない事なので、アプリのカレントディレクトリ別のsession IDとクッキーを使用する形に変更しました。

## 21/10/06 v0.8.1

- 日記モードで使用していても画像でレスができる状態だったため、レスで画像アップロードを使う･使わないを設定できるようにしました。

## 21/09/23 v0.7.5

- 編集時にタイトル欄を空にした時にも｢無題｣と入るようにした。レスの題名をスレッドの親のタイトルにRe:を付けたものに。
- レスの時は親のタイトルを自動で入れる。ただし掲示板には表示されない。外部プログラム使用時に必要。
- お絵かきコメントのJavaScriptの修正。
レスでお絵かきの時に題名欄が表示されないようにする工夫ですが、動作していれば従来通りでも問題ありません。 

## 21/09/23 v0.6

- 記事の編集･削除。続きを描く、管理者認証マークの表示。カタログ機能。投稿者名の名前で記事の一覧。メール通知機能。  
ログファイルの拡張に区切をつけて、ログファイルの形式をいったん確定。

## 21/09/06 v0.02
- 投稿時のパスワードをパスワードハッシュで保存。
- ユーザー削除機能を追加しました。
- 日記モードができました。
- 日記モードの時は、スレ立てができるのは管理者のみになり、フォームを偽装して投稿してもエラーになります。
- 管理者削除と日記モードログインのための管理者ログインページができました。

## 21/09/03 v0.01
- ~~続きを描く機能はありませんが、~~ NEOとChickenPaintで絵を描いて投稿する事ができます。
- 管理者モードにログインすると記事の削除が可能になります。
- ~~ユーザーのパスワード入力欄はまだないので、ユーザーによる編集や削除もできません。~~
- 合言葉機能を使えば、合言葉を知っている人しか投稿できなくなります。入力フォームもでません。
- 1スレッドに投稿できるレスの数を超えると入力フォームが消えます。さらにフォームを偽装して投稿してもエラーになります。
- レスがついたスレッドが一番上に表示される仕様。
- 古いスレッド判定も投稿順ではなく、最新レス順です。
- レスポンシブデザイン。スマホ･タブレットに対応しています。
- HTMLファイルを外部化して、1枚のHTMLファイルとして扱う事ができるため、ユーザーによるデザインの変更が容易です。
