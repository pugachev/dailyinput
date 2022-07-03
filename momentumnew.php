<?php
include 'lib/connect.php';
// include 'lib/calorieData.php';
include 'lib/queryCalorieData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

if(!empty($_POST['category']))
{
    //入力画面から取得した項目
    $rcvCategory = $_POST['category'];
    $rcvItem = $_POST['item'];
    $rcvQuantity = $_POST['quantity'];
    $rcvCalorie = $_POST['calorie'];
    $rcvMomentum = $_POST['momentum'];
    $tgtfilename="";
    if (!empty($_FILES['picdata']['name'])) 
    {
        $tgtfilename = date("YmdHis");
        $tgtfilename .= '.' . substr(strrchr($_FILES['picdata']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
        $file = "upload/$tgtfilename";

        move_uploaded_file($_FILES['picdata']['tmp_name'], 'upload/' . $tgtfilename);//imagesディレクトリにファイル保存
        if (exif_imagetype($file)) {
            //画像ファイルかのチェック
        } else {
            // $message = '画像ファイルではありません';
        }
    }

    $caloriedata = new CalorieData();
    $caloriedata->setCategory($rcvCategory);
    $caloriedata->setItem($rcvItem);
    $caloriedata->setCalorie($rcvCalorie);
    $caloriedata->setQuantity($rcvQuantity);
    $caloriedata->setMomen($rcvMomentum);
    $caloriedata->setPicdata($tgtfilename);

    $caloriedata->save();

    
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

    <!-- bootstrap-datepickerを読み込む -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <style>
        @media (max-width: 600px) {
            .title {
                font-size: 1rem;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <title>新規登録画面</title>
</head>

<body>
    <div style="padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-4 pb-3" action="momentumnew.php" enctype="multipart/form-data" method="post" id="newmomentum">
                <div class="form-group row">
                    <label for="calorie_date" class="col-sm-3 col-form-label">カロリー/日</label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgtdate">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="momentum" class="col-sm-3 col-form-label">運動量</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="momentum" placeholder="運動量" value="" name="momentum">
                        <div class="err_text" id="err_momentum"></div>
                    </div>
                </div>
                <div class="mb-5 d-flex justify-content-center align-items-center">
                    <input type="submit" class="btn btn-primary" value="新規登録" id="buttonNew"></input>
                </div>
            </form>
        </div>
    </main>
    </div>
    <script type="text/javascript">
            $(function(){
                // 日付設定
                $('#tgtdate').datepicker();
            });

    </script>
    <?php include 'footer.php';?>

</body>

</html>