<?php
// 今月を0とする。
$month = 0;
// カレンダに記述する日付のカウンタ。
$date = 1;

$j=1;
//クエリパラメータが存在し、対象が数値形式であり、整数である条件式
if (isset($_GET['month']) && is_numeric($_GET['month']) && is_int((int) $_GET['month'])) {
    $month = (int) $_GET['month'];
}

// 今日の日付のDateTimeクラスのインスタンスを生成しタイムゾーンを「アジア/東京」にする。
$dt = new DateTime();
$dt->setTimezone(new DateTimeZone('Asia/Tokyo'));

//日付を本日の日付分引く
$d = $dt->format('d');
$dt->sub(new DateInterval('P' . ($d - 1) . 'D'));

if ($month > 0) {
    // $monthが0より大きいときは、現在月の「ついたち」に、その月数を追加します。
    $dt->add(new DateInterval("P" . $month . "M"));
} else {
    // $monthが0より小さいときは、現在月の「ついたち」から、その月数を引きます。
    $dt->sub(new DateInterval("P" . (0 - $month) . "M"));
}

//初日が何曜日かを求める
$startDayOfTheWeek =$dt->format('w');
//当月に何日あるかの日数を求める
$monthDays = $dt->format('t');
// 当月に何週あるかを求める。曜日の数値に対応する月の日数を足した数値を7で割り、小数点以下を切り上げることで、同月の週数が求められます。
$weeks = ceil($monthDays +$startDayOfTheWeek)/7;

//予約記録用日時フォーマット
$dm =$dt->format('Y-m-d');
