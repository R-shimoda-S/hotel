<?php

session_start();
session_regenerate_id();

require_once('../class/config/Config_calendar.php');
require_once('../class/config/Config_today.php');
require_once('../class/db/Base.php');
require_once('../class/db/CalendarVacancy.php');
require_once('../vacancy/Vacancy.php');
require_once('../class/room/RoomAll.php');
require_once('../class/util/SaftyUtil.php');

//ログインされているかの確認
if (isset($_SESSION["login"])) {
    $loginFlag=true;
} else {
    $loginFlag=false;
}
if ($loginFlag==false) {
    $_SESSION['msg']['login']='miss';
    header('location:../index.php');
}

//今日の日付を取得
$day= new Today();
$today=$day->__construct();
//現在の部屋の総数を取得
$ra=new RoomAll();
$roomAll=$ra->__construct();
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body{
            background-color:gainsboro;
        }
        .room{
            margin:5px;
        }
        .vacancy{
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
            <div class="title mx-auto">
            <h2>予約画面</h2>
            </div>
        </div>
    </div>
    <!-- エラーメッセージ -->
    <?php if (isset($_SESSION["msg"]["res"])):?>
    <div class="container error">
        <div class="row">
            <div class="alert mx-auto alert-danger" role="alert">
                <?php echo $_SESSION["msg"]["res"];?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <!-- エラーメッセージ ここまで-->

    <form action="check.php" method="post">
    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>人数</p>
            </div>
            <div class="mx-auto col-8 col-sm-6">
                <input type="text" class="number" id="number" name="number" size="20"
                value="<?php if (!empty($_SESSION["res"]["number"])) {
    echo $_SESSION["res"]["number"];
}?>">
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
                <input type="date" class="start" id="start" name="start"  size="20"
                value="<?php if (!empty($_SESSION["res"]["start"])) {
    echo $_SESSION["res"]["start"];
}?>">
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
                <input type="date" class="end" id="end" name="end" size="20"
                value="<?php if (!empty($_SESSION["res"]["end"])) {
    echo $_SESSION["res"]["end"];
}?>">
            </div>
        </div>
    </div>

    <div class="vacancy">
        <div class="row">
            <div class="col-4 text-right">
                <p>〇 空室あり △ 空室僅か ✕ 満室</p>
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
          <div class="col-1 col-lg-2">
  
          </div>
          <div class="col-10 col-lg-8">
          　<table bgcolor="#eeffff" class="table table-bordered">
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
                <tr>
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
                $room=$va->roomType($res);
                ?>
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
            <div class="col-1 col-lg-2">
  
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

    <div class="container form">
        <div class="row">
            <div class=" col-1 col-sm-1 col-lg-2">
            </div>
            <div class=" col-3 col-sm-5 col-lg-4 text-sm-right">
                <p>ご希望のお部屋</p>
            </div>
            <div class=" mx-auto col-8 col-sm-6">
                <div class="room">シングル <input type="text" class="single" id="single" name="single" size="10" placeholder="半角数字"
                value="<?php if (!empty($_SESSION["res"]["single"])) {
                    echo $_SESSION["res"]["single"];
                }?>">部屋<br/></div>
                <div class="room">ダブル　 <input type="text" class="double" id="double" name="double" size="10" placeholder="半角数字"
                value="<?php if (!empty($_SESSION["res"]["double"])) {
                    echo $_SESSION["res"]["double"];
                }?>">部屋<br/></div>
                <div class="room">４人部屋 <input type="text" class="quadruple" id="quadruple" name="quadruple" size="10" placeholder="半角数字"
                value="<?php if (!empty($_SESSION["res"]["quadruple"])) {
                    echo $_SESSION["res"]["quadruple"];
                }?>">部屋</div>
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <input type="hidden" name="token" value="<?= SaftyUtil::generateToken() ?>">
            <button type="submit" class="btn btn-light ">確認</button>
            </div>
        </div>
    </div>
    </form>
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