<?php
/**
 * 予約部屋関連のデータベースクラス
 */

class ReservationRoom extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function reservationRoomInsert(
        $reservationNumber,
        $roomType
    ) {
        //SQL文の準備
        $sql='insert into reservation_rooms (reservation_id,room_type_id) 
        values(?,?)';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $reservationNumber, PDO::PARAM_STR);
        $stmt->bindValue(2, $roomType, PDO::PARAM_INT);
        // SQLを実行する
        $stmt->execute();
    }

    public function reservationRoomCancel(
        $reservationNumber
    ) {
        //SQL文の準備
        $sql='update reservation_rooms set cancel=1 where  
        reservation_id=?';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $reservationNumber, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

}
