<?php

session_start();
session_regenerate_id();

require_once('../class/whitespace/IsNullorWhitespace.php');
require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/util/SaftyUtil.php');

$su=new SaftyUtil();

$flag=true;
$flag2=true;

//入力値をサニタイズ処理
$mail=$su->sanitize2($_POST["mail"]);
$pass=$su->sanitize2($_POST["pass"]);
$pass2=$su->sanitize2($_POST["pass2"]);
$name=$su->sanitize2($_POST["name"]);
$prefecture=$_POST["prefecture"];
$city_name=$su->sanitize2($_POST["city_name"]);
$address=$su->sanitize2($_POST["address"]);
$building=$su->sanitize2($_POST["building"]);
$question=$_POST["question"];
$answer=$su->sanitize2($_POST["answer"]);

//入力値をセッションに保存
$_SESSION["mail"]=$su->sanitize2($_POST["mail"]);
$_SESSION["pass"]=$su->sanitize2($_POST["pass"]);
$_SESSION["pass2"]=$su->sanitize2($_POST["pass2"]);
$_SESSION["name"]=$su->sanitize2($_POST["name"]);
$_SESSION["prefecture"]=$_POST["prefecture"];
$_SESSION["city_name"]=$su->sanitize2($_POST["city_name"]);
$_SESSION["address"]=$su->sanitize2($_POST["address"]);
$_SESSION["building"]=$su->sanitize2($_POST["building"]);
$_SESSION["question"]=$_POST["question"];
$_SESSION["answer"]=$su->sanitize2($_POST["answer"]);
$_SESSION["postal_code"]=$su->sanitize2($_POST["postal_code"]);
$_SESSION["tel"]=$su->sanitize2($_POST["tel"]);

//空白を判断する
$isNullorWhitespace=new IsNullorWhitespace();
$functionName=$isNullorWhitespace->is_nullorwhitespace($name);
$functionPostalCode=$isNullorWhitespace->is_nullorwhitespace($_POST["postal_code"]);
$functionCityName=$isNullorWhitespace->is_nullorwhitespace($city_name);
$functionAddress=$isNullorWhitespace->is_nullorwhitespace($address);
$functionBuilding=$isNullorWhitespace->is_nullorwhitespace($building);
$functionTel=$isNullorWhitespace->is_nullorwhitespace($_POST["tel"]);
$functionAnswer=$isNullorWhitespace->is_nullorwhitespace($answer);

$error=array();
//入力値を判断する
if ($mail==null) {
    $flag=false;
    array_push($error, 'メールアドレス');
}
if ($pass==null) {
    $flag=false;
    array_push($error, 'パスワード');
}
if ($pass2==null) {
    $flag=false;
    array_push($error, '再度入力');
}
if ($functionName||$name==null) {
    $flag=false;
    array_push($error, '名前');
}
if ($functionPostalCode||$_POST["postal_code"]==null) {
    $flag=false;
    array_push($error, '郵便番号');
}
if ($_POST["prefecture"]=="選択下さい。") {
    $flag=false;
    array_push($error, '都道府県');
}
if ($functionCityName||$city_name==null) {
    $flag=false;
    array_push($error, '市町村');
}
if ($functionAddress||$address==null) {
    $flag=false;
    array_push($error, '番地');
}
if ($functionBuilding||$building==null) {
    $building="空白";
}
if ($functionTel||$_POST["tel"]==null) {
    $flag=false;
    array_push($error, '電話番号');
}
if ($_POST["question"]=="0") {
    $flag=false;
    array_push($error, '秘密の質問');
}
if ($functionAnswer||$answer==null) {
    $flag=false;
    array_push($error, '秘密の質問の答え');
}

if ($pass!==$pass2) {
    $flag2=false;
}
//同じメールアドレスが存在しているかどうかの確認
try {
    $db= new Users();
    $check=$db->mailCheck($mail);
    if (!empty($check)) {
        $_SESSION['msg']['mail']="既にそのメールアドレスは使われています";
        header('location:index.php');
        exit();
    }
} catch (PDOException $e) {
    header('location:../error/msg.html');
    exit();
}
if ($flag==false) {
    foreach ($error as $key=>$value) {
        $ems=$ems."「".$value."」";
    }
    $_SESSION['msg']['mail']=$ems."が未入力です";
    header('location:index.php');
    exit();
}
if ($flag2==false) {
    $_SESSION['msg']['mail']="パスワードが間違っています";
    header('location:index.php');
    exit();
}

$postal_code=str_replace(array('-', 'ー', '−', '―', '‐'), '', $_POST["postal_code"]);
$tel=str_replace(array('-', 'ー', '−', '―', '‐'), '', $_POST["tel"]);

if (preg_match("/^[0-9]+$/", $postal_code)==false||preg_match("/^[0-9]+$/", $tel)==false) {
    $_SESSION['msg']['mail']="数字で入力してください";
    header('location:index.php');
    exit();
}
unset($_SESSION['msg']['mail']);
?>


<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
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
            <h2>入力確認画面</h2>
            </div>
        </div>
    </div>

    <form action="action.php" method="POST">
    <div class="container form">
        <div class="row">
            <div class=" col-1">
            </div>
            <div class=" col-3">
                <p>メールアドレス</p>
            </div>
            <div class="mx-auto col-8">
               <p><?php echo $mail?></p>
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
                非公開
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
            <p><?php echo $name?></p>
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
            <p><?php echo $postal_code;?></p>
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
            <p><?php echo $_POST["prefecture"];?></p>
            </div>
            <div class="mx-auto col-2">
                <p>市町村</p>
            </div>
            <div class="mx-auto col-3">
            <p><?php echo $city_name;?></p>
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
            <p><?php echo $address;?></p>
            </div>
            <div class="mx-auto col-2">
                <p>建物</p>
            </div>
            <div class="mx-auto col-3">
            <p><?php echo $building;?></p>
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
            <p><?php echo $tel;?></p>
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
                <?php if ($_POST["question"]==1):?>
                <p>貴方の小学校名は？</p>
                <?php elseif ($_POST["question"]==2):?>
                <p>貴方の親の出身地は？</p>
                <?php else :?>
                <p>好きな音楽は？</p>
                <?php endif; ?>
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
            <p><?php echo $answer;?></p>
            </div>
        </div>
    </div>

    <div class="container botton ">
        <div class="row">
        
            <input type="hidden" name="mail" value=<?php echo $mail;?>>
            <input type="hidden" name="pass" value=<?php echo $_POST["pass"];?>>
            <input type="hidden" name="name" value=<?php echo $name;?>>
            <input type="hidden" name="postal_code" value=<?php echo $postal_code;?>>
            <input type="hidden" name="prefecture" value=<?php echo $_POST["prefecture"];?>>
            <input type="hidden" name="city_name" value=<?php echo $city_name;?>>
            <input type="hidden" name="address" value=<?php echo $address;?>>
            <input type="hidden" name="building" value=<?php echo $building;?>>
            <input type="hidden" name="tel" value=<?php echo $tel;?>>
            <input type="hidden" name="question" value=<?php echo $_POST["question"];?>>
            <input type="hidden" name="answer" value=<?php echo $answer;?>>
            <button type="submit" class="btn btn-light mx-auto ">確定</button>
            </form>
        </div>
    </div>
    

    <div class="container toplink">
        <div class="row">
            <div class="col-1 col-sm-2 col-md-3 col-xl-4">
            </div> 
            <div class="col-10 col-sm-4">
                <a href="index.php">戻る</a>
            </div>
            <div class="col-1 col-sm-6">
            </div>
    </div>
</body>
</html>