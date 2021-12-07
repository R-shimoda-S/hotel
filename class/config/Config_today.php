<?php

/*
 *今日の日付を設定するクラス
 **/
class Today
{
    public function __construct()
    {
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $today =$dt->format('Y-m-d');
        return $today;
    }
}
