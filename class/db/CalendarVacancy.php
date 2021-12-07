<?php
/**
 * 空室状況表示関連のデータベースクラス
 */

class CalendarVacancy extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    //現在の日付以降の予約を確認するメソッド
    public function vacancyDate()
    {
        //SQL文の準備
        $sql='select lodging_start_day,lodging_finish_day,reservation_number
         from reservations Where lodging_start_day and not cancel=1
         and lodging_finish_day >= CURDATE()';
        $stmt = $this->dbh->prepare($sql);
        // SQLを実行する
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //予約されている部屋の種類を判別するメソッド
    public function roomJudge($value)
    {
        //SQL文の準備
        $sql='select room_type_id from reservation_rooms 
        Where reservation_id = ? and not cancel=1';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $value, PDO::PARAM_INT);
        // SQLを実行する
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //現在ホテルにある部屋の総数を判別するメソッド
    public function roomAll()
    {
        //SQL文の準備
        $sql='select room_type_id from rooms where 1';
        $stmt = $this->dbh->prepare($sql);
        //SQLを実行する
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
