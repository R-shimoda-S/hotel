<?php

session_start();
session_regenerate_id();

require_once('../class/db/Base.php');
require_once('../class/db/Reservation.php');
require_once('../class/db/Users.php');
require_once('../vacancy/Vacancy.php');
require_once('../class/db/CalendarVacancy.php');
require_once('../class/util/SaftyUtil.php');
require_once('../class/whitespace/IsNullorWhitespace.php');

// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./form.php');
    exit();
}

$su=new SaftyUtil();

$number=$su->sanitize2($_POST["number"]);
$mail=$su->sanitize2($_POST["mail"]);

$isNullorWhitespace=new IsNullorWhitespace();
$functionNumber=$isNullorWhitespace->is_nullorwhitespace($number);
$functionMail=$isNullorWhitespace->is_nullorwhitespace($mail);

if ($functionNumber||$number==null) {
    $_SESSION["msg"]["res_login"]=Config::MSG_EMPTY_ERROR;
    header('location:login.php');
    exit();
}
if ($functionMail||$mail==null) {
    $_SESSION["msg"]["res_login"]=Config::MSG_EMPTY_ERROR;
    header('location:login.php');
    exit();
}
//予約番号からメールアドレスを取得するメソッド
try {
    $db=new Reservation();
    $db2=new Users();
    $db3=new CalendarVacancy();
    $cusNum=$db->cusNum($number);
    $cusMail=$db2->cusMail($cusNum);
   
    if ($cusMail==$mail) {
        $_SESSION["customer"]["res"]=$db->reservationIdCheck($number);
        //予約番号から部屋数を割り出す
        $room=$db3->roomJudge($number);
        $single=0;
        $double=0;
        $quadruple=0;
        foreach ($room as $key=>$value) {
            foreach ($value as $value2) {
                if ($value2==1) {
                    $single+=1;
                } elseif ($value2==2) {
                    $double+=1;
                } else {
                    $quadruple+=1;
                }
            }
        }
        $roomSum=["0"=>$single,"1"=>$double,
        "2"=>$quadruple];
        $_SESSION["room"]["res"]=$roomSum;
        $_SESSION["number"]["res"]=$number;
        //予約番号から部屋数を割り出す--ここまで
        unset($_SESSION["msg"]["res_login"]);
        header('location:check.php');
        exit();
    } else {
        $_SESSION["msg"]["res_login"]=Config::MSG_USER_LOGIN_MATCH_ERROR;
        header('location:login.php');
        exit();
    }
} catch (PDOException $e) {
    header('location:../error/msg.html');
    exit();
}
