<?php
/**
 * 会員関連のデータベースクラス
 */

class Users extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function acountNumber()
    {
        //SQL文の準備
        $sql='select membership_id from customers order by id desc limit 1';
        $stmt =$this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function newAcount(
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
    ) {
        //SQL文の準備
        $sql='insert into customers (password,membership_id,name,post_code,
        prefecture,city_name,address,building_name,mail_address,question,answer,
        tel) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)';
        $stmt =$this->dbh->prepare($sql);
        $stmt->bindValue(1, $pass, PDO::PARAM_STR);
        $stmt->bindValue(2, $acountNumber, PDO::PARAM_INT);
        $stmt->bindValue(3, $name, PDO::PARAM_STR);
        $stmt->bindValue(4, $postal_code, PDO::PARAM_STR);
        $stmt->bindValue(5, $prefecture, PDO::PARAM_STR);
        $stmt->bindValue(6, $city_name, PDO::PARAM_STR);
        $stmt->bindValue(7, $address, PDO::PARAM_STR);
        $stmt->bindValue(8, $building, PDO::PARAM_STR);
        $stmt->bindValue(9, $mail, PDO::PARAM_STR);
        $stmt->bindValue(10, $question, PDO::PARAM_INT);
        $stmt->bindValue(11, $answer, PDO::PARAM_STR);
        $stmt->bindValue(12, $tel, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

    public function loginCheck($mail)
    {
        //SQL文の準備
        $sql='select password from customers WHERE mail_address=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $mail, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mailCheck($mail)
    {
        //SQL文の準備
        $sql='select * from customers WHERE mail_address=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $mail, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectName($mail)
    {
        //SQL文の準備
        $sql='select name,membership_id from customers WHERE mail_address=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $mail, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cusMail($mail)
    {
        //SQL文の準備
        $sql='select mail_address from customers WHERE membership_id=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $mail, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}
