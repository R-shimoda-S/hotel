<?php

 session_start();
 session_regenerate_id();

require_once('class/config/Config_calendar.php');
require_once('class/config/Config_today.php');
require_once('class/util/SaftyUtil.php');
require_once('class/db/Base.php');
require_once('class/db/CalendarVacancy.php');
require_once('vacancy/Vacancy.php');
require_once('class/room/RoomAll.php');

 //エラーメッセージのリセット
if (isset($_SESSION['msg']['e'])) {
    unset($_SESSION['msg']['e']);
}
if (isset($_SESSION['msg']['mail'])) {
    unset($_SESSION['msg']['mail']);
}
if (isset($_SESSION['msg']['res'])) {
    unset($_SESSION['msg']['res']);
}

//予約変更時の入力内容セッションの削除
unset($_SESSION["change"]["number"]);
unset($_SESSION["change"]["start"]);
unset($_SESSION["change"]["end"]);
unset($_SESSION["change"]["single"]);
unset($_SESSION["change"]["double"]);
unset($_SESSION["change"]["quadruple"]);
//今日の日付を取得
$day= new Today();
$today=$day->__construct();
//現在の部屋の総数を取得
$ra=new RoomAll();
$roomAll=$ra->__construct();

//ワンタイムトークンの作成
$token = SaftyUtil::generateToken();
?>


<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body{
            background-color:gainsboro;
        }
        .user{
            padding-top :20px;
            text-align: center;
        }
        .title{
            padding-top :10px;
            text-align: center;
        }
        .login{
            text-align: right;
            padding-top :10px;
        }
        .botton{
            padding :10px 0px;
        }
        .registration{
            padding :5px;
        }
        .room{
            padding-top: 10px;
            margin-bottom: -20px;
        }
        tr *:nth-child(2){
            color:#ff6969;
        }
        tr *:last-child{
            color:#0ba9ea;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="user col-3">
                <?php if (isset($_SESSION['login'])):?>
                  <p><?php echo $_SESSION['login'];?>様</p>
                <?php endif ?>
            </div>
            <div class="title col-6">
                <h2>ホテル予約システム</h2>
            </div>
            <div class="login col-3">
                <a href="login/index.php">ログイン　</a><br/>
                <?php if (isset($_SESSION['login'])):?>
                <a href="logout/logout.php">ログアウト</a>
                <?php endif ?>
            </div>      
        </div>
    </div>

    <!-- エラーメッセージ -->
    <?php if (isset($_SESSION['msg']['login'])):?>
    <div class="container error">
        <div class="row">
            <div class="alert mx-auto alert-danger" role="alert">
                ログインされていません
            </div>
        </div>
    </div>
    <?php endif ?>
    <!-- エラーメッセージ ここまで-->

    <div class="room">
        <div class="row">
            <div class="col-4 text-right" >
                <p>〇 空室あり  △ 空室僅か　✕ 満室</p>
                <p>S:シングル　D:ダブル　4:4人部屋</p>
            </div>
            <div class="col-4 text-center">
                <h3>空き状況</h3>
            </div>
            <div class="col-4 ">
            </div>
        </div>
    </div>

    <div class="calander">
      <div class="row">
        <div class="col-1">

        </div>
        <div class="col-10">
        　<table bgcolor="#eeffff" class="table table-bordered ">
            <thead>
              <tr>
                <th scope="col"><?= $dt->format('y年n月')?></th>
                <th scope="col">日</th>
                <th scope="col">月</th>
                <th scope="col">火</th>
                <th scope="col">水</th>
                <th scope="col">木</th>
                <th scope="col">金</th>
                <th scope="col">土</th>
              </tr>
            </thead>
            <tbody>
            <!--対応する月の週分ループさせる条件式 --> 
            <?php for ($i =0;$i<$weeks;$i++):?>
            <tr> 
                <th scope="row">第<?php echo $j++; ?>週</th>
            <!-- 1週分ループさせる条件式-->
                <?php for ($day =0;$day<7;$day++):?>
            <td>
            <!-- 初週の1日より早い曜日を表示させない条件式-->
                <?php if ($i==0 && $day>= $startDayOfTheWeek):?>
                <!-- 現在の予約状況を調べる条件式-->
                <?php
                if ($date<10) {
                    $dayDeta=$dt->format('Y-m').'-0'.$date;
                } else {
                    $dayDeta=$dt->format('Y-m').'-'.$date;
                }
                $va=new Vacancy();
                $res=$va->vacancy($dayDeta);
                $room=$va->roomType($res);
                ?>
                <!-- ここまで-->
                <?php echo $date++;?>
                <?php if ($today<=$dayDeta): ?>
                &emsp;<?php $va->roomVacancy($room, $roomAll);?>
                <?php endif?>
            <!-- ここまで-->
            <!-- 月末以降表記させない条件式-->
                <?php elseif ($i>0&& $date<=$monthDays):?>
                <!-- 現在の予約状況を調べる条件式-->
                <?php
                if ($date<10) {
                    $dayDeta=$dt->format('Y-m').'-0'.$date;
                } else {
                    $dayDeta=$dt->format('Y-m').'-'.$date;
                }
                $va=new Vacancy();
                $res=$va->vacancy($dayDeta);
                $room=$va->roomType($res);?>
                <!-- ここまで-->
                <?php echo $date++;?>
                <?php if ($today<=$dayDeta): ?>
                &emsp;<?php $va->roomVacancy($room, $roomAll);?>
                <?php endif?>
            <!-- ここまで-->
            </td>
            <!-- 1週分ループさせる条件式　ここまで-->
                    <?php endif ?>
                <?php endfor ?>
            </tr>
            <!--対応する月の週分ループさせる条件式 ここまで-->
            <?php endfor ?>
            </tbody>
          </table>
          </div>
          <div class="col-1">

        　</div>
    　</div>
    </div>
    
        <div class="navi">
            <div class="row">
                <div class="col-4 text-right">
                    <p><a href="./?month=<?= $month - 1 ?>">&lt;&lt;前の月</a></p>
                </div>
                <div class="col-4 text-center">
                <p><a href="./">今月</a></p>
                </div>
                <div class="col-4 text-left">
                <p><a href="./?month=<?= $month + 1 ?>">次の月&gt;&gt;</a></p>
                </div>
            </div>
        </div>

    <div class="container">
        <div class="row">
            <div class="botton mx-auto">
            <form action="reservation/index.php" method="get">
                <button type="submit" class="btn btn-outline-primary">予約</button>
            </form>
            </div>
        </div>
        <div class="row">
            <div class="botton mx-auto ">
            <form action="change/login.php" method="get">
                <button type="submit" class="btn btn-outline-primary">変更</button>
            </form>
            </div>
        </div>
        <div class="row">
            <div class="botton mx-auto ">
            <form action="cancel/login.php" method="get">
                <button type="submit" class="btn btn-outline-primary">キャンセル</button>
            </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="registration  mx-auto ">
                <h3>初めてのご利用の方はこちら</h3>
            </div>
        </div>
        <div class="row">
            <div class=" mx-auto ">
                <h3>↓</h3>
            </div>
        </div>
        <div class="row">
            <div class="registration  mx-auto ">
                <a href="registration/index.php">会員登録へ</a>
            </div>
        </div> 
    </div>



    
</body>
</html>