# Petit Note
- 1スレッド1ログファイル形式のスレッド式の画像掲示板です。  
- PaintBBS NEOとChickenPaintが使えるお絵かき掲示板です。
- まだログファイルの形式が定まっていないため、ウェブに設置して使わないでください。 予期せぬエラー、ログ消失が発生しても何もできません。  

 ![image](https://user-images.githubusercontent.com/44894014/132039172-ddda46c8-f2f8-454e-a05d-6892b98acbce.png)
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
- 続きを描く機能はありませんが、NEOとChickenPaintで絵を描いて投稿する事ができます。
- 管理者モードにログインすると記事の削除が可能になります。
- ユーザーのパスワード入力欄はまだないので、ユーザーによる編集や削除もできません。
- 合言葉機能を使えば、合言葉を知っている人しか投稿できなくなります。入力フォームもでません。
- 1スレッドに投稿できるレスの数を超えると入力フォームが消えます。さらにフォームを偽装して投稿してもエラーになります。
- レスがついたスレッドが一番上に表示される仕様。
- 古いスレッド判定も投稿順ではなく、最新レス順です。
- レスポンシブデザイン。スマホ･タブレットに対応しています。
- HTMLファイルを外部化して、1枚のHTMLファイルとして扱う事ができるため、ユーザーによるデザインの変更が容易です。
