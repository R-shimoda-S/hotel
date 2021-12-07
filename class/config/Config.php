<?php
 /**
 * 設定クラス
 */
class Config
{
    /** データベース関連 **/

    /** @var string 接続データベース名 */
    const DB_NAME = 'hotel';

    /** @var string データベースホスト名 */
    const DB_HOST = 'localhost';

    /** @var string データベース接続ユーザー名 */
    const DB_USER = 'root';

    /** @var string データベース接続パスワード */
    const DB_PASS = '';


    /** ワンタイムトークン **/

    /** @var int openssl_random_pseudo_bytes()で使用する文字列の長さ */
    const RANDOM_PSEUDO_STRING_LENGTH = 32;


    /** メッセージ関連 **/

    /** @var string ワンタイムトークンが一致しないとき */
    const MSG_INVALID_PROCESS = '不正な処理が行われました。';

    /** @var string ワンタイムトークンが一致しないとき */
    const MSG_USER_LOGIN_TRY_TIMES_OVER ='一定回数以上ログインに失敗しました';

    /** @var string アドレスかパスワードが間違ってるとき */
    const MSG_USER_LOGIN_MATCH_ERROR ='メールアドレスかパスワードが間違っています';

    /** @var string 日付が不適切な時 */
    const MSG_DAY_ERROR ='正しい日付を入力してください';

    /** @var string 日付が不適切な時 */
    const MSG_ROOM_ERROR='全ての部屋数が0もしくは未入力になっています';

    /** @var string 日付が不適切な時 */
    const MSG_EMPTY_ERROR='未入力の箇所があります';
}
