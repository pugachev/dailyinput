<?php
    include 'lib/connect.php';
    include 'lib/querySpendingData.php';
    include 'lib/querySettingData.php';

    header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
    header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
    header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
    header('Cache-Control:pre-check=0,post-check=0',false);
    header('Pragma:no-cache');

    $limit=5;
    $currentpage ="1";

    $tgtstartdate="";
    $tgtenddate="";
    $category="";
    $item="";

    if(!empty($_GET['page']))
    {
        $currentpage=$_GET['page'];
    }

    if(!empty($_POST["tgtstartdate"]) || !empty($_POST["tgtenddate"]) || !empty($_POST["category"]) || !empty($_POST["item"]))
    {
        //指定データで検索を実行する
        $queryCalorieData = new QuerySpendingData();
        $results=$queryCalorieData->searchData($_POST["tgtstartdate"],$_POST["tgtenddate"],$_POST["category"],$_POST["item"]);
        $searchconditions = explode(",",$results["searchcondition"]);

        $tgtlink=[];
        for($j=0;$j<($results['totalcnt']/$limit);$j++)
        {
            $tgtlink[$j]="caloriesearch.php?page=".($j+1);
            for($i=0;$i<count($searchconditions);$i++)
            {
                if(!empty($searchconditions[$i]))
                {
                    $tgtlink[$j].= "&".$searchconditions[$i];
                }
            }
        }
    }

    if(!empty($_GET["startdate"]) || !empty($_GET["enddate"]) || !empty($_GET["category"]) || !empty($_GET["item"]))
    {
        if(!empty($_GET["startdate"]))
        {
            $tgtstartdate=$_GET["startdate"];
        }

        if(!empty($_GET["enddate"]))
        {
            $tgtenddate=$_GET["enddate"];
        }

        if(!empty($_GET["category"]))
        {
            $category=$_GET["category"];
        }

        if(!empty($_GET["item"]))
        {
            $item=$_GET["item"];
        }


        //指定データで検索を実行する
        $queryCalorieData = new QuerySpendingData();
        $results=$queryCalorieData->searchData($tgtstartdate,$tgtenddate,$category,$item,$currentpage);
        $searchconditions = explode(",",$results["searchcondition"]);

        $tgtlink=[];
        for($j=0;$j<($results['totalcnt']/$limit);$j++)
        {
            $tgtlink[$j]="caloriesearch.php?page=".($j+1);
            for($i=0;$i<count($searchconditions);$i++)
            {
                if(!empty($searchconditions[$i]))
                {
                    $tgtlink[$j].= "&".$searchconditions[$i];
                }
            }
        }
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
        @media (max-width: 600px) {
            /* .result {
                font-size: 1rem;
            } */
        }
    </style>
    <title>出費検索</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'spendingheader.php';?>
    <div class="container mb-3">
        <main>
            <div class="container">
                <form class="mt-4 pb-3" action="spendingsearch.php" method="post" id="searchForm">
                    <div class="form-group row ">
                        <label for="tgtdate" class="col-sm-3 col-lg-1 col-form-label">開始</label>
                        <div class="col-sm-9 col-lg-5">
                            <input type="date" class="form-control" id="tgtdate" name="tgtstartdate">
                        </div>
                        <label for="tgtdate" class="col-sm-3 col-lg-1 col-form-label">終了</label>
                        <div class="col-sm-9 col-lg-5">
                            <input type="date" class="form-control" id="tgtdate" name="tgtenddate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category" class="col-sm-3 col-form-label col-lg-1">分類</label>
                        <div class="col-sm-9 col-lg-11">
                            <select class="form-control" name="category" id="category">
                                <option value="firstchoice" selected>選択して下さい</option>
                                <option value="foods">食材</option>
                                <option value="eatingout">外食</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="item" class="col-sm-3 col-form-label col-lg-1">項目</label>
                        <div class="col-sm-9 col-lg-11">
                            <select class="form-control" name="item" id="item">
                            <option value="0000" selected>選択して下さい</option>
                            <option value="1001" class="foods">カレー</option>
                            <option value="1002" class="foods">ラーメン</option>
                            <option value="1003" class="foods">うどん</option>
                            <option value="1004" class="foods">蕎麦</option>
                            <option value="1005" class="foods">中華そば</option>
                            <option value="1006" class="foods">チキン</option>
                            <option value="1007" class="foods">コロッケ</option>
                            <option value="1008" class="foods">野菜</option>
                            <option value="1009" class="foods">お肉</option>
                            <option value="1010" class="foods">ハンバーグ</option>
                            <option value="1011" class="foods">アルコール</option>  
                            <option value="1012" class="foods">お菓子</option>
                            <option value="1013" class="foods">おにぎり</option> 
                            <option value="1014" class="foods">パン</option>  
                            <option value="2001" class="necessities">トイレ用品</option>
                            <option value="2002" class="necessities">お風呂用品</option>
                            <option value="2003" class="necessities">台所用品</option>
                            <option value="2004" class="necessities">洗濯用品</option>
                            <option value="2005" class="necessities">掃除用品</option>
                            <option value="3001" class="amazon">PC用品</option>
                            <option value="3002" class="amazon">Kindle本</option>
                            <option value="3003" class="amazon">サプリメント</option>
                            <option value="3004" class="amazon">アロマ用品</option>
                            <option value="3005" class="amazon">仏具用品</option>
                            <option value="4001" class="publiccharge">水道代</option>
                            <option value="4002" class="publiccharge">ガス代</option>
                            <option value="4003" class="publiccharge">光熱費</option>
                            <option value="4004" class="publiccharge">NHK</option>
                            <option value="5001" class="medical">歯医者</option>
                            <option value="5002" class="medical">内科</option>
                            <option value="5003" class="medical">外科</option>
                            <option value="5004" class="medical">検査</option>
                            <option value="6001" class="outeat">中華</option>
                            <option value="6002" class="outeat">ファストーフード</option>
                            <option value="6003" class="outeat">洋食</option>
                            <option value="6004" class="outeat">和食</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5 d-flex justify-content-center align-items-center">
                        <input type="submit" class="btn btn-primary" value="検索" id="buttonNew"></input>
                    </div>
                </form>

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
                            print '<td><a href="calorieedit.php?id='.$data->getId().'" class="btn btn-primary btn-xs">編集</a></td>';
                            print '<td><a href="calorieedit.php" class="btn btn-primary btn-xs">削除</a></td>';
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
                    <?php if(!empty($results["totalcnt"]) && intval($results["totalcnt"])>5)
                    { 
                        print '<nav class="mt-1 mb-4">';
                        print '<ul class="pagination d-flex justify-content-center">';
                        // for ($i = 1; $i <= ceil(intval($results["totalcnt"]) / $limit); $i++)
                        for ($i = 0; $i <count($tgtlink); $i++)
                        {
                            if(($i+1)==$currentpage)
                            {
                                print '<li class="page-item active"><a class="page-link" href='.$tgtlink[$i].'>'.($i+1).'</a></li>';
                            }
                            else
                            {

                                print '<li class="page-item"><a class="page-link" href='.$tgtlink[$i].'>'.($i+1).'</a></li>';
                            }
                        }
                        print '</ul>';
                        print '</nav>';
                    } ?>
                </div>
            </div>
        </main>
    </div>
    <?php include 'footer.php';?> 

</body>

</html>