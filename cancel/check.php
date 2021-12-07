<?php

require_once('../class/util/SaftyUtil.php');

session_start();
session_regenerate_id();

$session=$_SESSION["customer"]["res"];
$session_room=$_SESSION["room"]["res"];
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
            <p><?php echo $session[0]["number_of_people"]?>人</p>
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
            <p><?php echo $session[0]["lodging_start_day"]?></p>
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
            <p><?php echo $session[0]["lodging_finish_day"]?></p>
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
            <p><?php echo $session[0]["days"]?></p>
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
                <div class="room">シングル <?php echo $session_room[0]?> 部屋<br/></div>
                <div class="room">ダブル　 <?php echo $session_room[1]?> 部屋<br/></div>
                <div class="room">４人部屋 <?php echo $session_room[2]?> 部屋</div>
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <h3>上記の入力内容をキャンセルしてよろしいですか</h3>
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <form action="action.php" method="post">
            <input type="hidden" name="token" value="<?= SaftyUtil::generateToken() ?>">
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
                <a href="/hotel/index.php">戻る</a>
            </div>
            <div class="col-1 col-sm-6">
            </div>
    </div>
</body>
</html>