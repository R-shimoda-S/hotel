# 擬似ホテル予約システム

## PHPで制作した簡易ホテル予約システム
ホテルの予約、予約状況の確認、予約の変更・キャンセルなどが行えます。

## 機能一覧
##### ・ユーザー登録　ログイン機能
メールアドレス、パスワード、氏名、郵便番号、住所などを入力する会員登録機能。<br>
ユーザー情報を活用したログイン認証機能。
##### ・ホテルの空き状況の確認
ホテルの空き状況をカレンダー表記で閲覧できます<br>
ホテルの部屋の分類は「シングル」,「ダブル」,「4人部屋」の3種類になります。<br>
各種類の空き状況は「○」空室あり（予約割合0%~69%）,「△」空室僅か(予約割合70%~99%),「×」満室(予約割合100%)となっています。<br>
「前の月」、「次の月」リンクを選択することで、月の移動ができます。
##### ・ホテルの予約、変更、キャンセル機能
人数、チェックイン・チェックアウトの日付、予約部屋数を入力して、予約を行えます。<br>
予約ページでもホテルの空き状況を確認可能です。<br>
必要事項記入後、入力データの確認画面に移行し、予約ボタンを押すと、予約番号が発行されます。<br>
予約番号とメールアドレスを使用し、予約の変更・キャンセルができます。
## 動作環境
windows10<br>
PHP 8.0.12<br>
10.4.21-MariaDB - mariadb.org binary distribution
