<?php

//*
 /*部屋総数を求めるクラス
 */
require_once('C:\xampp\htdocs\hotel\class\db\Base.php');
require_once('C:\xampp\htdocs\hotel\class\db\CalendarVacancy.php');

class RoomAll
{
    public function __construct()
    {
        try {
            $db=new CalendarVacancy();
            $roomAll=$db->roomAll();
            $single=0;
            $double=0;
            $quadruple=0;
            foreach ($roomAll as $key=>$value) {
                foreach ($value as $value2) {
                    if ($value2==1) {
                        $single+=1;
                    } elseif ($value2==2) {
                        $double+=1;
                    } else {
                        $quadruple+=1;
                    }
                }
            }
            $roomAll=["0"=>$single,"1"=>$double,"2"=>$quadruple];
            return $roomAll;
        } catch(PDOException $e){
            header('location:/hotel/error/msg.html');
            exit();
        }
    }
}
