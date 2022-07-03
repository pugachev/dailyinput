<?php
    include 'lib/connect.php';
    include 'lib/querySpendingData.php';
    include 'lib/querySettingData.php';

    header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
    header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
    header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
    header('Cache-Control:pre-check=0,post-check=0',false);
    header('Pragma:no-cache');

    $predate="";
    $tgtday="";
    $nextdate="";
    $dispflg=false;

    if(!empty($_GET['predate']))
    {
        //パラメータより本日の日付を取得する
        $tgtday = $_GET['predate'];
        //システムより前日の日付を取得する
        $predate = date("Y-m-d",strtotime($tgtday."-1 day"));
        //システムより翌日の日付を取得する
        $nextdate = date("Y-m-d",strtotime($tgtday."+1 day"));
    }
    else if(!empty($_GET['nextdate']))
    {
        //パラメータより本日の日付を取得する
        $tgtday = $_GET['nextdate'];
        //システムより前日の日付を取得する
        $predate = date("Y-m-d",strtotime($tgtday."-1 day"));
        //システムより翌日の日付を取得する
        $nextdate = date("Y-m-d",strtotime($tgtday."+1 day"));
    }
    else
    {
        //システムより前日の日付を取得する
        $predate = date("Y-m-d",strtotime('-1 day'));
        //システムより本日の日付を取得する
        $tgtday = date("Y-m-d");
        //システムより翌日の日付を取得する
        $nextdate  = date("Y-m-d",strtotime('+1 day'));
    }

    //指定日の全データを取得する
    $querySpendingData = new QuerySpendingData();
    $results=$querySpendingData->getAllData($tgtday);

    //設定値(最高出費額　)を取得する
    $querySettingData = new QuerySettingData();
    $maxspending=$querySettingData->getSettingSpendingMaxData($tgtday);

    //目標上限値 - 実際出費額 = 差分出費
    $diffSpending = intval($maxspending) - intval($results['sumprice']);
    if($diffSpending<0)
    {
        $dispflg=true;
    }
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
    <style>
        #alert{
            text-align: center;
            width: 70%;
            margin: 55px auto;
            font-size:36px;
            color:red;
        }
        @media (max-width: 600px) {
            /* .result {
                font-size: 1rem;
            } */
        }
    </style>
    <title>出費</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'spendingheader.php';?>
    <div class="container mb-3">
        <main>
            <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="h5 col-md-4 result"><p class="text-center"><a href="spendinglist.php?predate=<?php echo $predate; ?>" class="btn btn-primary btn-xs">前日</a></p></div>
                        <div class="h5 col-md-4 result"><p class="text-center"><?php echo $tgtday; ?></p></div>
                        <div class="h5 col-md-4 result"><p class="text-center"><a href="spendinglist.php?nextdate=<?php echo $nextdate; ?>"  class="btn btn-primary btn-xs">翌日</a></p></div>
                    </div>
                    <div class="row">
                        <div class="h4 col-md-4 result"><p class="text-center">目標上限:<?php echo $maxspending; ?></p></div>
                        <div class="h4 col-md-4 result"><p class="text-center">現在出費:<?php echo $results['sumprice']; ?></p></div>
                        <div class="h4 col-md-4 result"><p class="text-center">差分出費:<?php echo $diffSpending; ?></p></div>
                    </div>
                    <?php if(!empty($results["data"]))
                    { 
                        print '<div class="table-responsive-md">';
                        print '<table class="table table-hover table-striped text-nowrap">';
                        print '<thead>';
                        print '<tr>';
                        print '<th>#</th>';
                        print '<th>分類</th>';
                        print '<th>項目</th>';
                        print '<th>価格</th>';
                        print '<th>数量</th>';
                        print '<th>編集</th>';
                        print '<th>削除</th>';
                        print '</tr>';
                        print '</thead>';
                        print '<tbody>';
                        foreach($results["data"] as $key=>$data)
                        {
                            print '<tr>';
                            print '<th>'.( intval($key)+1).'</th>';
                            print '<td>'.$data->getCategory().'</td>';
                            print '<td>'.$data->getItem().'</td>';
                            print '<td>'.$data->getPrice().'</td>';
                            print '<td>'.$data->getQuantity().'</td>';
                            print '<td><a href="spendingedit.php?id='.$data->getId().'" class="btn btn-primary btn-xs">編集</a></td>';
                            print '<td><a href="spendingedit.php" class="btn btn-primary btn-xs">削除</a></td>';
                            print '</tr>';
                        }
                        print '</tbody>';
                        print '</table>';
                        print '</div>';
                        print '</div>';
                        print '</div>';
                    }
                    else
                    {
                        print  '<div id="alert">データは存在しません！</div>'; 
                    }
                    ?>
                    <?php if(!empty($results["totalcnt"]) && intval($results["totalcnt"])>8)
                    { 
                        print '<nav class="mt-1 mb-4">';
                        print '<ul class="pagination d-flex justify-content-center">';
                        for ($i = 1; $i <= ceil(intval($results["totalcnt"]) / $limit); $i++)
                        {
                            if($i==$currentpage)
                            {
                                print '<li class="page-item active"><a class="page-link" href="spendinglist.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            else
                            {

                                print '<li class="page-item"><a class="page-link" href="spendinglist.php?page='.$i.'">'.$i.'</a></li>';
                            }
                        }
                        print '</ul>';
                        print '</nav>';
                    } ?>
        </main>
    </div>
    <?php include 'footer.php';?> 

</body>

</html>