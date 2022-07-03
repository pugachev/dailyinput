<?php
include 'lib/connect.php';
// include 'lib/calorieData.php';
include 'lib/queryCalorieData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

$searchCondition="";
$currentPage="";

$queryCalorieData = new QueryCalorieData();
if(!empty($_GET['id']))
{
    //一覧画面から取得した日付
    $result = $queryCalorieData->getDatum($_GET['id']);
}

if(!empty($_GET['scd']))
{
    $searchCondition=$_GET['scd'];
    $currentPage=$_GET['currentPage'];
}

//遷移元から貰ったcurrentpageを保存する
if(!empty($_GET['currentpage']))
{
    $currentPage = $_GET['currentpage'];
}

if(!empty($_POST['id']))
{
    $id = $_POST['id'];
    $tgtdate = $_POST['tgtdate'];
    $tgtcategory = $_POST['category'];
    $tgtitem = $_POST['item'];
    $tgtcalorie = $_POST['calorie'];
    $tgtquantity = $_POST['quantity'];

    $caloriedata = new CalorieData();
    $caloriedata->setId($id);
    $caloriedata->setTgtDate($tgtdate);
    $caloriedata->setCategory($tgtcategory);
    $caloriedata->setItem($tgtitem);
    $caloriedata->setCalorie($tgtcalorie);
    $caloriedata->setQuantity($tgtquantity);

    $caloriedata->save();

    // $tgturl = 'Location: https://ikefukuro40.tech/dailyinput/calorieedit.php?id='.$id;
    $tgturl = 'Location: http://localhost/dailyinput/calorieedit.php?id='.$id;

    header($tgturl);
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
    <title>編集画面</title>
</head>

<body>
    <div style="padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-4 pb-3" action="calorieedit.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="calorie_date" class="col-sm-3 col-form-label">対象日</label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgtdate" name="tgtdate" value="<?php echo $result->getTgtDate(); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="category" class="col-sm-3 col-form-label">分類</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="category" id="category">
                            <option value="firstchoice" selected>選択して下さい</option>
                            <option value="foods" <?php if($result->getCategory()=='foods') echo 'selected'; ?>>食材</option>
                            <option value="eatingout" <?php if($result->getCategory()=='eatingout') echo 'selected'; ?>>外食</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item" class="col-sm-3 col-form-label">項目</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="item" id="item">
                            <option value="0000" selected>選択して下さい</option>
                            <option value="1001" class="foods" <?php if($result->getItem()=='1001') echo 'selected'; ?>>カレー</option>
                            <option value="1002" class="foods" <?php if($result->getItem()=='1002') echo 'selected'; ?>>ラーメン</option>
                            <option value="1003" class="foods" <?php if($result->getItem()=='1003') echo 'selected'; ?>>うどん</option>
                            <option value="1004" class="foods" <?php if($result->getItem()=='1004') echo 'selected'; ?>>蕎麦</option>
                            <option value="1005" class="foods" <?php if($result->getItem()=='1005') echo 'selected'; ?>>中華そば</option>
                            <option value="1006" class="foods" <?php if($result->getItem()=='1006') echo 'selected'; ?>>チキン</option>
                            <option value="1007" class="foods" <?php if($result->getItem()=='1007') echo 'selected'; ?>>コロッケ</option>
                            <option value="1008" class="foods" <?php if($result->getItem()=='1008') echo 'selected'; ?>>野菜</option>
                            <option value="1009" class="foods" <?php if($result->getItem()=='1009') echo 'selected'; ?>>お肉</option>
                            <option value="1010" class="foods" <?php if($result->getItem()=='1010') echo 'selected'; ?>>ハンバーグ</option>
                            <option value="1011" class="foods" <?php if($result->getItem()=='1011') echo 'selected'; ?>>アルコール</option>  
                            <option value="1012" class="foods" <?php if($result->getItem()=='1012') echo 'selected'; ?>>お菓子</option> 
                            <option value="1013" class="foods" <?php if($result->getItem()=='1013') echo 'selected'; ?>>おにぎり</option>   
                            <option value="1014" class="foods" <?php if($result->getItem()=='1014') echo 'selected'; ?>>パン</option>     
                            <option value="1015" class="foods" <?php if($result->getItem()=='1015') echo 'selected'; ?>>ご飯</option>     
                            <option value="6001" class="outeat" <?php if($result->getItem()=='6001') echo 'selected'; ?>>中華</option>
                            <option value="6002" class="outeat" <?php if($result->getItem()=='6002') echo 'selected'; ?>>ファストーフード</option>
                            <option value="6003" class="outeat" <?php if($result->getItem()=='6003') echo 'selected'; ?>>洋食</option>
                            <option value="6004" class="outeat" <?php if($result->getItem()=='6004') echo 'selected'; ?>>和食</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="quantity" class="col-sm-3 col-form-label">個数</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="quantity" placeholder="個数" value="<?php echo $result->getQuantity(); ?>" name="quantity">
                        <div class="err_text" id="err_quantity"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="calorie" class="col-sm-3 col-form-label">熱量</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="calorie" placeholder="カロリー" value="<?php echo $result->getCalorie(); ?>" name="calorie">
                        <div class="err_text" id="err_calorie"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="addImage" class="col-sm-3 col-form-label">画像</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" name="picdata" class="form-control">
                            <label class="custom-file-label" for="addImage">ファイル選択...</label>
                        </div>
                    </div>
                </div> -->
                <div class="mb-5 d-flex justify-content-center align-items-center">
                    <input type="submit" class="btn btn-primary" value="編集" id="buttonNew"></input>
                    <?php 
                    print '<a href="caloriesearch.php?scd='.$searchCondition.'&page='.$currentPage.'"  class="btn btn-primary">戻る</a>';
                    ?>
                </div>

                <input type="hidden" value="<?php echo $result->getId(); ?>" name="id">
            </form>
        </div>
    </main>
    </div>
    <script type="text/javascript">
            $(function(){
                // 日付設定
                $('#tgtdate').datepicker();
                // selectbox コード選択左側
                $("#category").on("change", change_select);
            });
            // selectbox コード選択左側
            function change_select(){
                //onchange()が発火したらoption:selectedが切り替わるのでそれをとっている
                var value = $("#category option:selected").attr("value");

                //  #second option の要素数を取得
                var count = $("#item option").length;
                console.log(count);
                for (var i=1; i<count; i++) 
                {
                    // #second option要素 ここに全ての要素が入っている
                    var opt = $("#item option").eq(i);
                    var cls = opt.attr("class");
                    
                    if (value == cls)
                    {
                        opt.show();
                    }
                    else if (value == "firstchoice")
                    {
                        //「コードを選択して下さい」
                        opt.show();
                    }
                    else
                    {
                        opt.hide();
                    }
                }
                // value 指定 左側のどのコードを選択してもあらためて「コードを選択して下さい」が表示される
                $("#item").val("0000");
            }


    </script>
    <?php include 'footer.php';?>

</body>

</html>