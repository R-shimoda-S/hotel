<?php
/**
 * 予約日設定関連のデータベースクラス
 */

class ReservationDate extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function reservationDateInsert(
        $reservationNumber,
        $date
    ) {
        //SQL文の準備
        $sql='insert into reservation_dates (reservation_id,reservation_date) 
        values(?,?)';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $reservationNumber, PDO::PARAM_STR);
        $stmt->bindValue(2, $date, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

    public function reservationDateUpdate(
        $date,
        $reservationNumber
    ) {
        //SQL文の準備
        $sql='update reservation_dates set reservation_date=? where reservation_id=?';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $date, PDO::PARAM_STR);
        $stmt->bindValue(2, $reservationNumber, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

}
