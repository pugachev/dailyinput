<?php

    $switchflag="";
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if ((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) 
    {
        //スマホの場合に読み込むソースを記述
        $switchflag="sp";
    } 
    else 
    { 
         //PCの場合に読み込むソースを記述
         $switchflag="pc";
     }
    //タイムゾーン設定
    date_default_timezone_set('Asia/Tokyo');

    //表示させる年月を設定　↓これは現在の月
    $year = date('Y');
    // $month = date('m');
    $month = '7';

    $aryCalendar = [];

    if($switchflag=="sp")
    {
        //月末日を取得
        $end_month = date('t', strtotime($year.$month.'01'));

        //スケジュール設定 日付をキーに
        $arySchedule = [];
        $arySchedule[5] = '友達とショッピング';
        $arySchedule[10] = '上司と打ち合わせ';
        $arySchedule[15] = '大阪へ日帰り旅行';
        $arySchedule[20] = '歯医者に行く';
        $arySchedule[25] = '誕生日';

        $aryCalendar = [];

        //1日から月末日までループ
        for ($i = 1; $i <= $end_month; $i++){
            $aryCalendar[$i]['day'] = $i;
            $aryCalendar[$i]['week'] = date('w', strtotime($year.$month.sprintf('%02d', $i)));
            if(isset($arySchedule[$i])){
                $aryCalendar[$i]['text'] = $arySchedule[$i];
            }else{
                $aryCalendar[$i]['text'] = '';
            }
        }
    }
    else
    {
        $j = 0;

        //月末日を取得
        $end_month = date('t', strtotime($year.$month.'01'));
        //1日の曜日を取得
        $first_week = date('w', strtotime($year.$month.'01'));
        //月末日の曜日を取得
        $last_week = date('w', strtotime($year.$month.$end_month));

        //1日開始曜日までの穴埋め
        for($i = 0; $i < $first_week; $i++){
            $aryCalendar[$j][] = '';
        }

        //1日から月末日までループ
        for ($i = 1; $i <= $end_month; $i++){
            //日曜日まで進んだら改行
            if(isset($aryCalendar[$j]) && count($aryCalendar[$j]) === 7){
                $j++;
            }
            $aryCalendar[$j][] = $i; 
        }

        //月末曜日の穴埋め
        for($i = count($aryCalendar[$j]); $i < 7; $i++){
            $aryCalendar[$j][] = '';
        }
    }
    $aryWeek = ['日', '月', '火', '水', '木', '金', '土'];
?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.3/assets/css/docs.min.css" crossorigin="anonymous">
    <?php if($switchflag=="sp"){?>
         <link rel="stylesheet" href="css/calendar_sp.css">
    <?php } else { ?>
        <link rel="stylesheet" href="css/calendar_pc.css">
    <?php } ?>

    <title>Calorie</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <div class="container mb-1">
        <main>          
                <?php
                    if ($switchflag=="sp") {
                ?>
                <div class="container mt-3 mb-5">
                    <div calss="container">
                        <div class="row">
                        <div class="col-4 result"><div class="text-center" style="font-size:14px;">差分:48000kcal</div></div>
                        <div class="col-4 result"><div class="text-center" style="font-size:16px;font-weight:bold;">2022/06/11</div></div>
                        <div class="col-4 result"><div class="text-center" style="font-size:14px;">差分:18000kcal</div></div>
                        </div>
                    </div>
                    <table class="calender_column">
                        <?php foreach($aryCalendar as $value){ ?>
                            <?php if($value['day'] != date('j')){ ?>
                            <tr class="week<?php echo $value['week'] ?>">
                            <?php }else{ ?>
                            <tr class="today">
                            <?php } ?>
                                <td>
                                    <?php echo $value['day'] ?>(<?php echo $aryWeek[$value['week']] ?>)
                                </td>
                                <td>
                                    <?php echo $value['text'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                <div class="container mt-5">
                    <div class="row">
                        <div class="h4 col-md-4 result"><p class="text-center">差分:48000kcal</p></div>
                        <div class="h3 col-md-4 result"><p class="text-center">2022/06/11</p></div>
                        <div class="h4 col-md-4 result"><p class="text-center">差分:120000円</p></div>
                    </div>
                    <table class="calendar">
                        <!-- 曜日の表示 -->
                        <tr>
                        <?php foreach($aryWeek as $week){ ?>
                            <th><?php echo $week ?></th>
                        <?php } ?>
                        </tr>
                        <!-- 日数の表示 -->
                        <?php foreach($aryCalendar as $tr){ ?>
                        <tr>
                            <?php foreach($tr as $td){ ?>
                                <?php if($td != date('j')){ ?>
                                    <td><?php echo $td ?></td>
                                <?php }else{ ?>
                                    <!-- 今日の日付 -->
                                    <td class="today">
                                        <?php echo $td ?>
                                        <?php echo "<br />" ?>
                                        <?php echo '<font size=3><a href="calorieList.php">' ?>
                                        <?php echo '1650kcal' ?>
                                        <?php echo '</a></font>' ?>
                                        <?php echo " " ?>
                                        <?php echo '<font size=3><a href="spendingList.php">' ?>
                                        <?php echo '1750円' ?>
                                        <?php echo '</a></font>' ?>
                                </td>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
        </main>
    </div>
    <?php include 'footer.php';?> 

</body>

</html>