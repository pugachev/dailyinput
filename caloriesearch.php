<?php
    include 'lib/connect.php';
    include 'lib/queryCalorieData.php';
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
    $searchconditions="";
    $preSearchStartDate="";
    $preSearchEndDate="";
    $preSearchCategory="";
    $preSearchItem="";

    if(!empty($_GET['page']))
    {
        $currentpage=$_GET['page'];
    }

    if(!empty($_POST["tgtstartdate"]) || !empty($_POST["tgtenddate"]) || !empty($_POST["category"]) || !empty($_POST["item"]))
    {
        //指定データで検索を実行する
        $queryCalorieData = new QueryCalorieData();
        $results=$queryCalorieData->searchData($_POST["tgtstartdate"],$_POST["tgtenddate"],$_POST["category"],$_POST["item"],$currentpage);
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
        $queryCalorieData = new QueryCalorieData();
        $results=$queryCalorieData->searchData($tgtstartdate,$tgtenddate,$category,$item,$currentpage,$currentpage);
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

    //前回の検索結果を画面に表示する
    if(!empty($searchconditions))
    {
        //検索条件は全部で4個

        // 0番目 開始日
        if(!empty(explode($searchconditions[0],"=")))
        {
            $preSearchStartDate=explode("=",$searchconditions[0])[1];
        }

        // 1番目 終了日
        if(!empty(explode($searchconditions[1],"=")))
        {
            $preSearchEndDate=explode("=",$searchconditions[1])[1];
        }
  
        // 2番目 カテゴリー
        if(!empty(explode($searchconditions[2],"=")))
        {
            $preSearchCategory=explode("=",$searchconditions[2])[1];
        }
    
        // 3番目 アイテム名
        if(!empty(explode($searchconditions[3],"=")))
        {
            $preSearchItem=explode("=",$searchconditions[3])[1];
        }

        //指定データで検索を実行する
        $queryCalorieData = new QueryCalorieData();
        $results=$queryCalorieData->searchData($preSearchStartDate,$preSearchEndDate,$preSearchCategory,$preSearchItem,$currentpage);
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

    if(!empty($_GET['scd']))
    {
        //検索条件は全部で4個
        $searchconditions = explode(",",$_GET['scd']);
        // var_dump($_GET['scd']);
        // die();

        // 0番目 開始日
        if(!empty(explode($searchconditions[0],"=")))
        {
            $preSearchStartDate=explode("=",$searchconditions[0])[1];
        }

        // 1番目 終了日
        if(!empty(explode($searchconditions[1],"=")))
        {
            $preSearchEndDate=explode("=",$searchconditions[1])[1];
        }
  
        // 2番目 カテゴリー
        if(!empty(explode($searchconditions[2],"=")))
        {
            $preSearchCategory=explode("=",$searchconditions[2])[1];
        }
    
        // 3番目 アイテム名
        if(!empty(explode($searchconditions[3],"=")))
        {
            $preSearchItem=explode("=",$searchconditions[3])[1];
        }

        //指定データで検索を実行する
        $queryCalorieData = new QueryCalorieData();
        $results=$queryCalorieData->searchData($preSearchStartDate,$preSearchEndDate,$preSearchCategory,$preSearchItem,$currentpage);

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
    <title>熱量検索</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <div class="container mb-3">
        <main>
            <div class="container">
                <form class="mt-4 pb-3" action="caloriesearch.php" method="post" id="searchForm">
                    <div class="form-group row ">
                        <label for="tgtdate" class="col-sm-3 col-lg-1 col-form-label">開始</label>
                        <div class="col-sm-9 col-lg-5">
                            <input type="date" class="form-control" id="tgtdate" name="tgtstartdate" value="<?php echo $preSearchStartDate; ?>">
                        </div>
                        <label for="tgtdate" class="col-sm-3 col-lg-1 col-form-label">終了</label>
                        <div class="col-sm-9 col-lg-5">
                            <input type="date" class="form-control" id="tgtdate" name="tgtenddate" value="<?php echo $preSearchEndDate; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category" class="col-sm-3 col-form-label col-lg-1">分類</label>
                        <div class="col-sm-9 col-lg-11">
                            <select class="form-control" name="category" id="category">
                                <option value="firstchoice" selected>選択して下さい</option>
                                <option value="foods" <?php if($preSearchCategory=='foods') echo 'selected'; ?>>食材</option>
                                <option value="eatingout"  <?php if($preSearchCategory=='eatingout') echo 'selected'; ?>>外食</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="item" class="col-sm-3 col-form-label col-lg-1">項目</label>
                        <div class="col-sm-9 col-lg-11">
                            <select class="form-control" name="item" id="item">
                                <option value="0000" selected>選択して下さい</option>
                                <option value="1001" class="foods" <?php if($preSearchItem=='1001') echo 'selected'; ?>>カレー</option>
                                <option value="1002" class="foods" <?php if($preSearchItem=='1002') echo 'selected'; ?>>ラーメン</option>
                                <option value="1003" class="foods" <?php if($preSearchItem=='1003') echo 'selected'; ?>>うどん</option>
                                <option value="1004" class="foods" <?php if($preSearchItem=='1004') echo 'selected'; ?>>蕎麦</option>
                                <option value="1005" class="foods" <?php if($preSearchItem=='1005') echo 'selected'; ?>>中華そば</option>
                                <option value="1006" class="foods" <?php if($preSearchItem=='1006') echo 'selected'; ?>>チキン</option>
                                <option value="1007" class="foods" <?php if($preSearchItem=='1007') echo 'selected'; ?>>コロッケ</option>
                                <option value="1008" class="foods" <?php if($preSearchItem=='1008') echo 'selected'; ?>>野菜</option>
                                <option value="1009" class="foods" <?php if($preSearchItem=='1009') echo 'selected'; ?>>お肉</option>
                                <option value="1010" class="foods" <?php if($preSearchItem=='1010') echo 'selected'; ?>>ハンバーグ</option>
                                <option value="1011" class="foods" <?php if($preSearchItem=='1011') echo 'selected'; ?>>アルコール</option>  
                                <option value="1012" class="foods" <?php if($preSearchItem=='1012') echo 'selected'; ?>>お菓子</option> 
                                <option value="1013" class="foods" <?php if($preSearchItem=='1013') echo 'selected'; ?>>おにぎり</option>   
                                <option value="1014" class="foods" <?php if($preSearchItem=='1014') echo 'selected'; ?>>パン</option>     
                                <option value="1015" class="foods" <?php if($preSearchItem=='1015') echo 'selected'; ?>>ご飯</option>     
                                <option value="6001" class="outeat" <?php if($preSearchItem=='6001') echo 'selected'; ?>>中華</option>
                                <option value="6002" class="outeat" <?php if($preSearchItem=='6002') echo 'selected'; ?>>ファストーフード</option>
                                <option value="6003" class="outeat" <?php if($preSearchItem=='6003') echo 'selected'; ?>>洋食</option>
                                <option value="6004" class="outeat" <?php if($preSearchItem=='6004') echo 'selected'; ?>>和食</option>
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
                        print '<th>対象日</th>';
                        print '<th>項目</th>';
                        print '<th>熱量</th>';
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
                            print '<td>'.$data->getTgtDate().'</td>';
                            print '<td>'.$data->getItem().'</td>';
                            print '<td>'.$data->getCalorie().'</td>';
                            print '<td>'.$data->getQuantity().'</td>';
                            // print '<td><a href="calorieedit.php?id='.$data->getId()."'" class="btn btn-primary btn-xs">編集</a></td>';
                            // print '<td><a href="calorieedit.php?id='.$data->getId().'&scd='.aaa.'" class="btn btn-primary btn-xs">編集</a></td>';
                            print '<td><a href="calorieedit.php?id='.$data->getId().'&scd='.$results["searchcondition"].'&currentpage='.$currentpage.'" class="btn btn-primary btn-xs">編集</a></td>';
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