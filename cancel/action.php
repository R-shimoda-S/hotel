<?php

session_start();
session_regenerate_id();

require_once('../class/db/Base.php');
require_once('../class/db/Reservation.php');
require_once('../class/db/ReservationDate.php');
require_once('../class/db/ReservationRoom.php');
require_once('../vacancy/Vacancy.php');
require_once('../class/config/Config_today.php');
require_once('../class/room/RoomAll.php');
require_once('../class/util/SaftyUtil.php');

// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./login.php');
    exit();
}

//現在の部屋の総数を取得
$ra=new RoomAll();
$roomAll=$ra->__construct();

//入力した予約番号を受け取る。
$reservationNumber=$_SESSION["number"]["res"];
//データベース作成のインスタンスより前の所でtry/catchで囲む
try {
    //以前まで予約した部屋のキャンセルフラグを立てる
    $db= new Reservation();
    $db->reservationCancel($reservationNumber);
    $db2= new ReservationRoom();
    $db2->reservationRoomCancel($reservationNumber);
    
    header('location:done.html');
    exit();
} catch (PDOException $e) {
    header('location:../error/msg.html');
    exit();
}
