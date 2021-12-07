<?php

require_once('../class/config/Config_today.php');
require_once('../class/whitespace/IsNullorWhitespace.php');
require_once('../class/util/SaftyUtil.php');

session_start();
session_regenerate_id();

// ワンタイムトークンのチェック
if (!SaftyUtil::isValidToken($_POST['token'])) {
    // エラーメッセージをセッションに保存して、リダイレクトする
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./form.php');
    exit();
}

//サニタイズ処理
$su=new SaftyUtil();

$day= new Today();
$today=$day->__construct();

$flag=true;
$flag2=true;

$number=$su->sanitize2($_POST["number"]);
$start=$su->sanitize2($_POST["start"]);
$end=$su->sanitize2($_POST["end"]);
$single=$su->sanitize2($_POST["single"]);
$double=$su->sanitize2($_POST["double"]);
$quadruple=$su->sanitize2($_POST["quadruple"]);

//入力値を保存する
$_SESSION["change"]["number"]=$su->sanitize2($_POST["number"]);
$_SESSION["change"]["start"]=$su->sanitize2($_POST["start"]);
$_SESSION["change"]["end"]=$su->sanitize2($_POST["end"]);
$_SESSION["change"]["single"]=$su->sanitize2($_POST["single"]);
$_SESSION["change"]["double"]=$su->sanitize2($_POST["double"]);
$_SESSION["change"]["quadruple"]=$su->sanitize2($_POST["quadruple"]);

//空白判定
$isNullorWhitespace=new IsNullorWhitespace();
$functionNumber=$isNullorWhitespace->is_nullorwhitespace($number);
$functionSingle=$isNullorWhitespace->is_nullorwhitespace($single);
$functionDouble=$isNullorWhitespace->is_nullorwhitespace($double);
$functionQuadruple=$isNullorWhitespace->is_nullorwhitespace($quadruple);

//未入力値を判定させる配列を作成
$error=array();
if ($functionNumber||$_POST["number"]==null) {
    $flag=false;
    array_push($error, '人数');
}
if ($_POST["start"]==null) {
    $flag=false;
    array_push($error, 'チェックイン予定日');
}
if ($_POST["end"]==null) {
    $flag=false;
    array_push($error, 'チェックアウト予定日');
}
if ($_POST["start"]>$_POST["end"]) {
    $flag2=false;
}

if ($flag==false) {
    foreach ($error as $key=>$value) {
        $ems=$ems."「".$value."」";
    }
    $_SESSION['msg']['res']=$ems."が未入力です";
    header('location:form.php');
    exit();
}

if ($flag2==false) {
    $_SESSION['msg']['res']=Config::MSG_DAY_ERROR;
    header('location:form.php');
    exit();
}

if ($today>$_POST["start"]) {
    $_SESSION["msg"]["res"]=Config::MSG_DAY_ERROR;
    header('location:form.php');
    exit();
}

//部屋数が空白の場合は0になるように判定させる
if ($functionSingle||$_POST["single"]==null) {
    $single=0;
}
if ($functionDouble||$_POST["double"]==null) {
    $double=0;
}
if ($functionQuadruple||$_POST["quadruple"]==null) {
    $quadruple=0;
}

//全ての部屋数が0の場合はエラーメッセージを表示
if ($single==0&&$double==0&&$quadruple==0) {
    $_SESSION["msg"]["res"]=Config::MSG_ROOM_ERROR;
    header('location:form.php');
    exit();
}

$day1=new DateTime($start);
$day2=new DateTime($end);

$interval= $day1->diff($day2);

$interval= $day1->diff($day2);
if (preg_match("/^[0-9]+$/", $number)==false) {
    $_SESSION["msg"]["res"]="整数で入力してください";
    header('location:form.php');
    exit();
}
if ($number<=0) {
    $_SESSION["msg"]["res"]="1以上50以下で入力してください";
    header('location:form.php');
    exit();
}
if ($number>=50) {
    $_SESSION["msg"]["res"]="1以上50以下で入力してください";
    header('location:form.php');
    exit();
}
unset($_SESSION['msg']['res']);
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約確認画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body{
            background-color:gainsboro;
        }
        .room{
            margin:5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="title mx-auto">
            <h2>予約確認画面</h2>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>人数</p>
            </div>
            <div class="mx-auto col-8 col-sm-6">
                <p><?= $number ?>人</p>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>チェックイン予定日</p>
            </div>
            <div class="mx-auto col-8 col-sm-6">
                <p><?= $start ?></p>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>チェックアウト予定日</p>
            </div>
            <div class="mx-auto col-8 col-sm-6">
            <p><?= $end ?></p>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>宿泊日数</p>
            </div>
            <div class="mx-auto col-8 col-sm-6">
                <p><?= $interval->format('%a 日') ?></p>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>ご希望のお部屋</p>
            </div>
            <div class=" mx-auto col-8 col-sm-6">
                <div class="room"><p>シングル <?= $single?>部屋</p><br/></div>
                <div class="room"><p>ダブル　 <?= $double?>部屋</p><br/></div>
                <div class="room"><p>４人部屋 <?= $quadruple?>部屋</p></div>
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <h3>上記の入力内容に変更してよろしいですか</h3>
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <form action="action.php" method="post">
            <input type="hidden" name="number" value=<?= $number?>>
            <input type="hidden" name="start" value=<?= $start?>>
            <input type="hidden" name="end" value=<?= $end?>>
            <input type="hidden" name="single" value=<?= $single?>>
            <input type="hidden" name="double" value=<?= $double?>>
            <input type="hidden" name="quadruple" value=<?= $quadruple?>>
            <input type="hidden" name="days" value=<?= $interval->format('%a 日')?>>
            <button type="submit" class="btn btn-light ">確認</button>
            </form>
            </div>
        </div>
    </div>

    <div class="container toplink">
        <div class="row">
            <div class="col-1 col-sm-2 col-md-3 col-xl-4">
            </div> 
            <div class="col-10 col-sm-4">
                <a href="form.php">戻る</a>
            </div>
            <div class="col-1 col-sm-6">
            </div>
    </div>
</body>
</html>