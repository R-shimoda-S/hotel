<?php
session_start();
session_regenerate_id();

require_once('../class/config/Config_prefecture.php');

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
        .form{
            text-align: left;
        }
    </style>
    	
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="title mx-auto">
            <h2>会員登録画面</h2>
            </div>
        </div>
    </div>

    <!-- エラーメッセージ -->
    <?php if (isset($_SESSION['msg']['mail'])):?>
    <div class="container error">
        <div class="row">
            <div class="alert mx-auto alert-danger" role="alert">
                <?php echo $_SESSION['msg']['mail']?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <!-- エラーメッセージ ここまで-->

    <form action="check.php" method="POST">
    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class=" col-3">
                <p>メールアドレス</p>
            </div>
            <div class="mx-auto col-8">
                <input type="email" class="mail" id="mail" name="mail" size="50"
                value="<?php if (!empty($_SESSION["mail"])) {
    echo $_SESSION["mail"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class="mx-auto col-1">
            </div>
            <div class="mx-auto col-3">
                <p>パスワード</p>
            </div>
            <div class="mx-auto col-8">
                <input type="text" class="pass" id="pass" name="pass"
                value="<?php if (!empty($_SESSION["pass"])) {
    echo $_SESSION["pass"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class="mx-auto col-1">
            </div>
            <div class="mx-auto col-3">
                <p>パスワード再度入力</p>
            </div>
            <div class="mx-auto col-8">
                <input type="password" class="pass2" id="pass2" name="pass2"
                value="<?php if (!empty($_SESSION["pass2"])) {
    echo $_SESSION["pass2"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-3">
                <p>氏名</p>
            </div>
            <div class="mx-auto col-8">
                <input type="text" class="name" id="name" name="name"
                value="<?php if (!empty($_SESSION["name"])) {
    echo $_SESSION["name"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>郵便番号</p>
            </div>
            <div class="mx-auto col-8">
                <input type="text" class="postal_code" id="postal_code" name="postal_code" size="20"
                value="<?php if (!empty($_SESSION["postal_code"])) {
    echo $_SESSION["postal_code"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>都道府県</p>
            </div>
            <div class="mx-auto col-3">
                <select name="prefecture">
                    <?php foreach ($prefecture as $key=> $value) {?>
                    <option value="<?php echo $value;?>"
                    <?php if (!empty($_SESSION["prefecture"])&&$_SESSION["prefecture"]==$value):?>
                    <?php echo " selected"?>
                    <?php endif ?>>
                    <?php echo $value;?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mx-auto col-2">
                <p>市町村</p>
            </div>
            <div class="mx-auto col-3">
                <input type="text" class="city_name" id="city_name" name="city_name" size="20"
                value="<?php if (!empty($_SESSION["city_name"])) {
    echo $_SESSION["city_name"];
}?>">
            </div>

        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>番地</p>
            </div>
            <div class="mx-auto col-3">
                <input type="text" class="address" id="address" name="address" size="10"
                value="<?php if (!empty($_SESSION["address"])) {
    echo $_SESSION["address"];
}?>">
            </div>
            <div class="mx-auto col-2">
                <p>建物</p>
            </div>
            <div class="mx-auto col-3">
                <input type="text" class="building" id="building" name="building" size="20"
                value="<?php if (!empty($_SESSION["building"])) {
    echo $_SESSION["building"];
}?>">
            </div>

        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>電話番号</p>
            </div>
            <div class="mx-auto col-8">
                <input type="text" class="tel" id="tel" name="tel" size="20"
                value="<?php if (!empty($_SESSION["tel"])) {
    echo $_SESSION["tel"];
}?>">
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>秘密の質問</p>
            </div>
            <div class="mx-auto col-8">
                <select id="question" name="question">
                <option value="0">選択下さい。</option>
                <option value="1" <?php if (!empty($_SESSION["question"]) && $_SESSION["question"] == "1") {
    echo 'selected';
} ?>>貴方の小学校名は？</option>
                <option value="2"<?php if (!empty($_SESSION["question"]) && $_SESSION["question"] == "2") {
    echo 'selected';
} ?>>貴方の親の出身地は？</option>
                <option value="3"<?php if (!empty($_SESSION["question"]) && $_SESSION["question"] == "3") {
    echo 'selected';
} ?>>好きな音楽名は？</option>
                </select>
            </div>
        </div>
    </div>

    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class="mx-auto col-3">
                <p>秘密の質問の答え</p>
            </div>
            <div class="mx-auto col-8">
                <input type="text" class="answer" id="answer" name="answer" size="20"
                value="<?php if (!empty($_SESSION["answer"])) {
    echo $_SESSION["answer"];
}?>">
            </div>
        </div>
    </div>


    <div class="container botton">
        <div class="row">
            <button type="submit" class="btn btn-light mx-auto">確認</button> 
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