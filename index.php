<?php
    //タイムゾーン設定
    date_default_timezone_set('Asia/Tokyo');

    //表示させる年月を設定　↓これは現在の月
    $year = date('Y');
    $month = date('m');

    //月末日を取得
    $end_month = date('t', strtotime($year.$month.'01'));
    //1日の曜日を取得
    $first_week = date('w', strtotime($year.$month.'01'));
    //月末日の曜日を取得
    $last_week = date('w', strtotime($year.$month.$end_month));

    $aryCalendar = [];
    $j = 0;

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
    <link rel="stylesheet" href="css/calendar.css">
    <style>
        @media (max-width: 600px) {
            /* .result {
                font-size: 1rem;
            } */
        }
    </style>
    <title>Calorie</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <div class="container mb-3">
        <main>
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
                                <td class="today"><?php echo $td ?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </main>
    </div>
    <?php include 'footer.php';?> 

</body>

</html>