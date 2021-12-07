<?php

session_start();
session_regenerate_id();

require_once('../class/util/SaftyUtil.php');

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
    <?php if (isset($_SESSION['msg']['e'])):?>
    <div class="container error">
        <div class="row">
            <div class="alert mx-auto alert-danger" role="alert">
                <?php echo $_SESSION['msg']['e']?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <!-- エラーメッセージ ここまで-->

    <form action="action.php" method="POST">
    <div class="container contain">
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
        <div class="row">
            <div class="col-4">
            </div>
            <div class="form col-4">
                <p>パスワード</p>
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row">
            <div class="input mx-auto">
                <input type="password"class="password" id="password" name="password" size="45">
            </div>
        </div>
    </div>

    <div class="container botton">
        <div class="row">
            <input type="hidden" name="token" value="<?= SaftyUtil::generateToken() ?>">
            <button type="submit" class="btn btn-light mx-auto">決定</button>
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