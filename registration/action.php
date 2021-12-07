<?php


session_start();
session_regenerate_id();

require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/util/SaftyUtil.php');

$su=new SaftyUtil();

$mail=$su->sanitize2($_POST["mail"]);
$pass=$su->sanitize2($_POST["pass"]);
$name=$su->sanitize2($_POST["name"]);
$postal_code=$su->sanitize2($_POST["postal_code"]);
$prefecture=$_POST["prefecture"];
$city_name=$su->sanitize2($_POST["city_name"]);
$address=$su->sanitize2($_POST["address"]);
$building=$su->sanitize2($_POST["building"]);
$tel=$su->sanitize2($_POST["tel"]);
$question=$_POST["question"];
$answer=$su->sanitize2($_POST["answer"]);

    //暗号化処理//
    $pass= password_hash($pass, PASSWORD_DEFAULT);
    //データベース作成のインスタンスより前の所でtry/catchで囲む
    try {
        $db= new Users();
        $acountNumber=$db->acountNumber();
        if ($acountNumber==null) {
            $acountNumber=10000;
        }
        $acountNumber+=1;
        $db->newAcount(
            $mail,
            $pass,
            $name,
            $postal_code,
            $prefecture,
            $city_name,
            $address,
            $building,
            $tel,
            $question,
            $answer,
            $acountNumber
        );
        //入力内容保存を削除
        unset($_SESSION["mail"]);
        unset($_SESSION["pass"]);
        unset($_SESSION["pass2"]);
        unset($_SESSION["name"]);
        unset($_SESSION["prefecture"]);
        unset($_SESSION["city_name"]);
        unset($_SESSION["address"]);
        unset($_SESSION["building"]);
        unset($_SESSION["question"]);
        unset($_SESSION["answer"]);
        unset($_SESSION["postal_code"]);
        unset($_SESSION["tel"]);
        header('location:done.html');
    } catch (PDOException $e) {
        header('location:../error/msg.html');
    }
