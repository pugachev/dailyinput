<?php
include 'lib/connect.php';
// include 'lib/spendingData.php';
include 'lib/querySettingData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

if(!empty($_POST['tgtdate']))
{
    $rcvTgtDate = $_POST['tgtdate'];
    $rcvMaxColorie = $_POST['maxcalorie'];
    $rcvMaxSpending = $_POST['maxspending'];

    $settingdata = new SettingData();
    $settingdata->setTxtDate($rcvTgtDate);
    $settingdata->setMaxCalorie($rcvMaxColorie);
    $settingdata->setIMaxSpending($rcvMaxSpending);

    $settingdata->save();
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <title>新規登録画面</title>
</head>

<body>
    <div style="padding-top: 50px;">
    <?php include 'spendingheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-4 pb-3" action="https://ikefukuro40.tech/dailyinput/settingnew.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="tgtdate" class="col-sm-3 col-form-label">対象日</label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgtdate" name="tgtdate">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="maxcalorie" class="col-sm-3 col-form-label">摂取可能量</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="maxcalorie" placeholder="摂取可能量" value="" name="maxcalorie">
                        <div class="err_text" id="err_maxcalorie"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="maxspending" class="col-sm-3 col-form-label">出費可能額</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="maxspending" placeholder="出費可能額" value="" name="maxspending">
                        <div class="err_text" id="err_maxspending"></div>
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
                // 日付設定
                $('#tgtdate').datepicker();
            });
    </script>
    <?php include 'footer.php';?>

</body>

</html>