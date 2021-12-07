<?php
require_once('../class/util/SaftyUtil.php');

session_start();
session_regenerate_id();

if (isset($_SESSION["login"])) {
    $loginFlag=true;
} else {
    $loginFlag=false;
}
if ($loginFlag==false) {
    $_SESSION['msg']['login']='miss';
    header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body{
            background-color:gainsboro;
        }
        .title{
            padding-top:10px;
        }
        .form{
            padding-right:10px;
        }
        .btn{
            margin-top:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="title mx-auto">
            <h2>ログイン画面</h2>
            </div>
        </div>
    </div>

    <!-- エラーメッセージ -->
    <?php if (isset($_SESSION["msg"]["res_login"])):?>
    <div class="container error">
        <div class="row">
            <div class="alert mx-auto alert-danger" role="alert">
                <?php echo $_SESSION["msg"]["res_login"]?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <!-- エラーメッセージ ここまで-->

    <form action="login_action.php" method="POST">
    <div class="container contain">
        <div class="row">
            <div class="col-4">
            </div>
            <div class="form col-4">
                <p>予約番号</p>
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row">
            <div class="input mx-auto">
                <input type="text"class="number" id="number" name="number" size="45">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="form col-4">
                <p>メールアドレス</p>
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row">
            <div class="input mx-auto">
                <input type="text"class="mail" id="mail" name="mail" size="45">
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <div class="mx-auto">
            <input type="hidden" name="token" value="<?= SaftyUtil::generateToken() ?>">
            <button type="submit" class="btn btn-light">決定</button>
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