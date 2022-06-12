<?php
include 'lib/connect.php';
// include 'lib/spendingData.php';
include 'lib/querySpendingData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

// if(!empty($_POST['category']))
// {

    
// }
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
    <link rel="stylesheet" type="text/css" href="../bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker.min.css">
    <script type="text/javascript" src="../bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../bootstrap-datepicker-1.6.4-dist/locales/bootstrap-datepicker.ja.min.js"></script>

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
    <?php include 'spendingheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-4 pb-3" action="spendingnew.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="calorie" class="col-sm-3 col-form-label">日付</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="calorie" placeholder="カロリー/日" value="" name="calorie">
                        <div class="err_text" id="err_calorie"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="spending" class="col-sm-3 col-form-label">支出額/日</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="spending" placeholder="支出額/日" value="" name="spending">
                        <div class="err_text" id="err_spending"></div>
                    </div>
                </div>
                <div class="mb-5 d-flex justify-content-center align-items-center">
                    <input type="submit" class="btn btn-primary mr-1" value="設定保存" id="buttonNew"></input>
                    <input type="submit" class="btn btn-primary" value="キャンセル" id="buttonCancel"></input>
                </div>
            </form>
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