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

//現在の部屋の総数を取得
$ra=new RoomAll();
$roomAll=$ra->__construct();

//入力した予約番号を受け取る。
$reservationNumber=$_SESSION["number"]["res"];

$customerId=$_SESSION["login_id"];

$number=$_POST["number"];
$start=$_POST["start"];
$end=$_POST["end"];
if ($_POST["single"]==0) {
    $single=0;
}
$single=$_POST["single"];
if ($_POST["double"]==0) {
    $double=0;
}
$double=$_POST["double"];
if ($_POST["quadruple"]==0) {
    $quadruple=0;
}
$quadruple=$_POST["quadruple"];
$days=$_POST["days"];
$roomReserve=array($single,$double,$quadruple);
$roomNumber=$single+$double+$quadruple;

//データベース作成のインスタンスより前の所でtry/catchで囲む
try {
    $db=new Reservation();
    $db2=new Vacancy();
    //満室だった場合か空き部屋が不足していた際に予約受付を無かったことにするメソッドを作成
    $start2=new Datetime($start);
    $end2=new Datetime($end);
    //終点より1日多くする事で終点までの日付ループさせる
    $end2->add(new DateInterval('P1D'));
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start2, $interval, $end2);
    foreach ($period as $date) {
        $dayDeta=$date->format('Y-m-d');
        $va=new Vacancy();
        $res=$va->vacancy($dayDeta);
        //削除実行
        $res = array_diff($res, array($reservationNumber));
        //indexを詰める
        $res = array_values($res);
        $room=$va->roomType($res);
        //各部屋種毎に予約予定の部屋数と現在の予約数を合計して
        //ホテル総数の部屋数より多くなってないかを確認するコード
        for ($i=0;$i<count($roomReserve);$i++) {
            if ($room[$i]+$roomReserve[$i]>$roomAll[$i]) {
                $_SESSION["msg"]["res"]='予約した日は部屋が埋まっております';
                header('location:form.php');
                exit();
            }
        }
        unset($_SESSION['msg']['res']);
    }
    //満室だった場合か空き部屋が不足していた際に予約受付を無かったことにするメソッド ここまで
    $reservationNumber=$db->numberCheck();

    //以前まで予約した部屋のキャンセルフラグを立てる
    $db3= new ReservationRoom();
    $db3->reservationRoomCancel($reservationNumber);
    
    //予約情報を変更するコード
    $db->reservationUpdate(
        $number,
        $days,
        $roomNumber,
        $start,
        $end,
        $reservationNumber
    );
    //予約した日を変更するコード
    $db4= new ReservationDate();
    $td= new Today();
    $today= $td->__construct();
    $db4->reservationDateUpdate($today, $reservationNumber);

    //予約した部屋の内訳を変更するコード
    if ($single>0) {
        for ($i=0;$i<$single;$i++) {
            $roomType=1;
            $db3->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    if ($double>0) {
        for ($j=0;$j<$double;$j++) {
            $roomType=2;
            $db3->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    if ($quadruple>0) {
        for ($k=0;$k<$quadruple;$k++) {
            $roomType=3;
            $db3->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    //予約した部屋の内訳を記録するコード　ここまで
    //予約情報をセッションに保存
    $_SESSION["reserve"]=array($reservationNumber,$_SESSION["login"],$number,
    $start,$end,$single,$double,$quadruple);
    //入力内容セッションの削除
    unset($_SESSION["change"]["number"]);
    unset($_SESSION["change"]["start"]);
    unset($_SESSION["change"]["end"]);
    unset($_SESSION["change"]["single"]);
    unset($_SESSION["change"]["double"]);
    unset($_SESSION["change"]["quadruple"]);
    header('location:done.php');
    exit();
} catch (PDOException $e) {
    header('location:../error/msg.html');
    exit();
}
