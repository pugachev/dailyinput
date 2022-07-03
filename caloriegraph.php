<?php
        include 'lib/connect.php';
        include 'lib/queryCalorieData.php';
        require_once ('lib/jpgraph/jpgraph.php');
        require_once ('lib/jpgraph/jpgraph_pie.php');

        header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
        header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
        header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
        header('Cache-Control:pre-check=0,post-check=0',false);
        header('Pragma:no-cache');

    	//入力画面から取得した項目
        $rcvTgtDate = $_GET['tgtday'];

        $caloriedata = new QueryCalorieData();
        $results = $caloriedata->searchDataByDate($rcvTgtDate);
    
    
        // var_dump($results);
        // die();
    
        // (1) データ、凡例、描画色を準備
        // data配列生成
        $serachedData=[];
        // legends配列生成
        $serachedLegends=[];
        // colors配列生成
        $searchedColors=array('#0000FF', '#6600FF', '#CC00FF', '#66CC00', '#FFCC00');
        foreach($results as $result)
        {
            $serachedData[]=$result->getCalorie();
            $serachedLegends[]=$result->getItem();
        }
        $data=array('data'=>$serachedData,'legends'=>$serachedLegends,'colors'=>$searchedColors);
        
        // (2) 円グラフを準備
        $pie = new PiePlot($data['data']); // データ
        $pie->setLegends($data['legends']); // 凡例
        $pie->setSize(0.4); // サイズ
        $pie->setSliceColors($data['colors']); // 描画色
        
        // (3) グラフの描画先
        $g = new PieGraph(400,400); // サイズ
        // $g->title->setFont(FF_MINCHO, FS_NORMAL, 14); // タイトルフォント
        // $g->legend->setFont(FF_MINCHO, FS_NORMAL, 14); // 凡例フォント
        $g->title->SetFont(FF_FONT1,FS_NORMAL);
        $g->title->set('Calorie BreakDown'); // タイトル
        $g->add($pie); // グラフを追加
        
        // (4) グラフを描画
        $g->Stroke("auto");
        // $g->Stroke();
        $new_str=str_replace('-', '_',$rcvTgtDate);
        $imgsrc="caloriegraph.php_tgtday_".$new_str.".png";
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
    <!-- bootstrap-datepickerを読み込む -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        @media (max-width: 600px) {
            .title {
                font-size: 1rem;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <title>新規登録画面</title>
</head>

<body>
    <div style="padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <img src="<?php echo $imgsrc; ?>"  border=0 align=center width=800 height=800 />
        </div>
    </main>
    </div>
    <script type="text/javascript">
            $(function(){

            });
            


    </script>
    <?php include 'footer.php';?>

</body>

</html>