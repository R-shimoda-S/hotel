<?php
/**
 * 空室状況表示関連のクラス
 */

class Vacancy
{
    public function __construct()
    {
    }
    /** カレンダーテーブルのデータ内に記載された
     *  日付に予約が存在するどうか判定するメソッド
     */
    public function vacancy($dayDeta)
    {
        $db=new CalendarVacancy();
        $reservation=$db->vacancyDate();
        $res=array();
        //var_dump($reservation);
        foreach ($reservation as $key=>$value) {
            $start=$reservation[$key]["lodging_start_day"];
            $end=$reservation[$key]["lodging_finish_day"];
            //echo $end;
            //存在した予約の予約番号を判定する
            if ($start<=$dayDeta&&$dayDeta<=$end) {
                array_push($res, $reservation[$key]["reservation_number"]);
            }
            //存在した予約の予約番号を判定する ここまで
        }
        if (isset($res)) {
            return $res;
        } else {
            return null;
        }
    }
 
    //予約番号から予約部屋の種類を判別するメソッド
    public function roomType($res)
    {
        $db=new CalendarVacancy();
        if ($res==null) {
            $single=0;
            $double=0;
            $quadruple=0;
        } else {
            $roomType=array();
            foreach ($res as $key=>$value) {
                $room=$db->roomJudge($value);
                array_push($roomType, $room);
            }
            //判別した部屋の合計する
            $single=0;
            $double=0;
            $quadruple=0;
            foreach ($roomType as $key=>$value) {
                foreach ($value as $value2) {
                    foreach ($value2 as $value3) {
                        if ($value3==1) {
                            $single+=1;
                        } elseif ($value3==2) {
                            $double+=1;
                        } else {
                            $quadruple+=1;
                        }
                    }
                }
            }
        }
        $roomSum=["0"=>$single,"1"=>$double,
        "2"=>$quadruple];
        return $roomSum;
    }
    //予約されている部屋の合計が、ホテルの部屋数に対する比率を判別し
    //表示させるマークを確定させるメソッド
    public function roomVacancy($room, $roomAll)
    {
        //各部屋種の割合を求める
        $i=0;
        foreach ($room as $value) {
            if ($value==0) {
                $rist=0;
            } else {
                $rist=$value/$roomAll[$i]*100;
            }
            $roomVacancy[$i]=$rist;
            $i++;
        }
        //各部屋種のマークを決定する
        $j=0;
        foreach ($roomVacancy as $value) {
            if ($value<70) {
                $roomMark[$j]="〇";
            } elseif ($value==100) {
                $roomMark[$j]="✕";
            } else {
                $roomMark[$j]='△';
            }
            $j++;
        }
        echo "S ".$roomMark[0]."D ".$roomMark[1]."4 ".$roomMark[2];
    }
}
