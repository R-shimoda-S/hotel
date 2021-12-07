<?php

session_start();
session_regenerate_id();

require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/util/SaftyUtil.php');

// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['e']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./index.php');
    exit();
}

if (isset($_SESSION['login_failure']) && $_SESSION['login_failure'] >= 3) {
    $_SESSION['msg']['e']  = Config::MSG_USER_LOGIN_TRY_TIMES_OVER;
    header('Location: ./index.php');
    exit();
}

$su =new SaftyUtil();

$mail = $su->sanitize2($_POST["mail"]);
$pass = $su->sanitize2($_POST["password"]);

  try {
      //メールアドレスからパスワードの確認）
      //データベース作成のインスタンスより前の所でtry/catchで囲む
      $db = new Users();
      $loginCheck = $db->loginCheck($mail);
      //暗号化されたパスワードを照らし合わせる
      if (password_verify($pass, $loginCheck[0]["password"])==true) {
          //名前の取得
          $userName = $db->selectName($mail);
          //ログイン情報をセッションに保存
          $_SESSION["login"] = $userName[0]["name"];
          $_SESSION["login_id"] = $userName[0]["membership_id"];
          //エラー関連のセッション削除
          unset($_SESSION['msg']['e']);
          unset($_SESSION['msg']['login']);
          unset($_SESSION['login_failure']);
          //トップページに転送
          header('location:../index.php');
          exit();
      } else {
          $_SESSION['msg']['e'] = Config::MSG_USER_LOGIN_MATCH_ERROR;
          // ログイン失敗回数を保存する
          if (isset($_SESSION['login_failure'])) {
              $_SESSION['login_failure']++;
          } else {
              $_SESSION['login_failure'] = 1;
          }
          header('location:index.php');
          exit();
      }
  } catch (Exception $e) {
      header('location:../error/msg.html');
      exit();
  }
