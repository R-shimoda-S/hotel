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

//サニタイズ処理
$su=new SaftyUtil();

//現在の部屋の総数を取得
$ra=new RoomAll();
$roomAll=$ra->__construct();

$customerId=$_SESSION["login_id"];

$number=$su->sanitize2($_POST["number"]);
$start=$su->sanitize2($_POST["start"]);
$end=$su->sanitize2($_POST["end"]);
if ($_POST["single"]==0) {
    $single=0;
}
$single=$su->sanitize2($_POST["single"]);
if ($_POST["double"]==0) {
    $double=0;
}
$double=$su->sanitize2($_POST["double"]);
if ($_POST["quadruple"]==0) {
    $quadruple=0;
}
$quadruple=$su->sanitize2($_POST["quadruple"]);
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
        $room=$va->roomType($res);
        //各部屋種毎に予約予定の部屋数と現在の予約数を合計して
        //ホテル総数の部屋数より多くなってないかを確認するコード
        for ($i=0;$i<count($roomReserve);$i++) {
            if ($room[$i]+$roomReserve[$i]>$roomAll[$i]) {
                $_SESSION["msg"]["res"]='予約した日は部屋が埋まっております';
                header('location:index.php');
                exit();
            }
        }
        unset($_SESSION['msg']['res']);
    }
    
    //満室だった場合か空き部屋が不足していた際に予約受付を無かったことにするメソッド ここまで
    $reservationNumber=$db->numberCheck();
    //データベースにカラムがなかった場合は予約番号を10000に設定
    if ($reservationNumber==null) {
        $reservationNumber=10000;
    }
    $reservationNumber+=1;
    
    //予約情報を記録するコード
    $db->reservationInsert(
        $customerId,
        $number,
        $days,
        $roomNumber,
        $start,
        $end,
        $reservationNumber
    );
    //予約した日を記録するコード
    $db3= new ReservationDate();
    $td= new Today();
    $today= $td->__construct();
    $db3->reservationDateInsert($reservationNumber, $today);

    //予約した部屋の内訳を記録するコード
    $db4= new ReservationRoom();
    if ($single>0) {
        for ($i=0;$i<$single;$i++) {
            $roomType=1;
            $db4->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    if ($double>0) {
        for ($j=0;$j<$double;$j++) {
            $roomType=2;
            $db4->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    if ($quadruple>0) {
        for ($k=0;$k<$quadruple;$k++) {
            $roomType=3;
            $db4->reservationRoomInsert($reservationNumber, $roomType);
        }
    }
    //予約した部屋の内訳を記録するコード　ここまで
    //予約情報をセッションに保存
    $_SESSION["reserve"]=array($reservationNumber,$_SESSION["login"],$number,
    $start,$end,$single,$double,$quadruple);
    //入力内容セッションの削除
    unset($_SESSION["res"]["number"]);
    unset($_SESSION["res"]["start"]);
    unset($_SESSION["res"]["end"]);
    unset($_SESSION["res"]["single"]);
    unset($_SESSION["res"]["double"]);
    unset($_SESSION["res"]["quadruple"]);
    header('location:done.php');
    exit();
} catch (PDOException $e) {
    header('location:../error/msg.html');
    exit();
}
