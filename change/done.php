<?php
session_start();
session_regenerate_id();
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
        .top{
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container top">
        <div class="row">
            <div class=" col-12 text-center">
                <h3>予約番号　<?php echo $_SESSION["reserve"][0];?></h3>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-12 text-center">
                <h3><?php echo $_SESSION["reserve"][1];?>様 <?php echo $_SESSION["reserve"][2];?>名</h3>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-12 text-center">
                <h3>チェックイン予定日 <?php echo $_SESSION["reserve"][3];?></h3>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-12 text-center">
                <h3>ご希望のお部屋</h3>
            </div>
            <div class=" mx-auto  text-center">
                <div class="room"><p>シングル <?php echo $_SESSION["reserve"][5];?> 部屋</p><br/></div>
                <div class="room"><p>ダブル　 <?php echo $_SESSION["reserve"][6];?> 部屋</p><br/></div>
                <div class="room"><p>４人部屋 <?php echo $_SESSION["reserve"][7];?> 部屋</p></div>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-12 text-center">
                <h3>変更しました。</h3>
            </div>
        </div>
    </div>

    <div class="container toplink">
        <div class="row">
            <div class="col-1 col-sm-2 col-md-3 col-xl-4">
            </div> 
            <div class="col-10 col-sm-4">
                <a href="/hotel/index.php">トップに戻る</a>
            </div>
            <div class="col-1 col-sm-6">
            </div>
    </div>
</body>
</html>