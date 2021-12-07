<?php
/**
 * 予約関連のデータベースクラス
 */

class Reservation extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function numberCheck()
    {
        //SQLの準備
        $sql='select reservation_number from reservations order by id desc limit 1';
        $stmt =$this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function reservationInsert(
        $customerId,
        $people,
        $days,
        $roomNumber,
        $startDay,
        $finishDay,
        $reservationNumber
    ) {
        //SQL文の準備
        $sql='insert into reservations (customer_id,number_of_people,days,
        reservation_room_number,lodging_start_day,lodging_finish_day,
        reservation_number) values(?,?,?,?,?,?,?)';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $customerId, PDO::PARAM_INT);
        $stmt->bindValue(2, $people, PDO::PARAM_INT);
        $stmt->bindValue(3, $days, PDO::PARAM_INT);
        $stmt->bindValue(4, $roomNumber, PDO::PARAM_STR);
        $stmt->bindValue(5, $startDay, PDO::PARAM_STR);
        $stmt->bindValue(6, $finishDay, PDO::PARAM_STR);
        $stmt->bindValue(7, $reservationNumber, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

    public function reservationUpdate(
        $people,
        $days,
        $roomNumber,
        $startDay,
        $finishDay,
        $reservationNumber
    ) {
        //SQL文の準備
        $sql='update reservations set number_of_people=?,days=?,
        reservation_room_number=?,lodging_start_day=?,lodging_finish_day=?
        where reservation_number=?';
        //SQL文の？の数値を代入
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $people, PDO::PARAM_INT);
        $stmt->bindValue(2, $days, PDO::PARAM_INT);
        $stmt->bindValue(3, $roomNumber, PDO::PARAM_STR);
        $stmt->bindValue(4, $startDay, PDO::PARAM_STR);
        $stmt->bindValue(5, $finishDay, PDO::PARAM_STR);
        $stmt->bindValue(6, $reservationNumber, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

    public function reservationIdCheck($number)
    {
        //SQL文の準備
        $sql='select * from reservations WHERE reservation_number=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $number, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function reservationCancel($number)
    {
        //SQL文の準備
        $sql='update reservations set cancel = 1 WHERE reservation_number=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $number, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
    }

    public function cusNum($number)
    {
        //SQL文の準備
        $sql='select customer_id from reservations WHERE reservation_number=? and not cancel=1 and lodging_start_day >= CURDATE()';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(1, $number, PDO::PARAM_STR);
        // SQLを実行する
        $stmt->execute();
        //結果を返却する
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}
