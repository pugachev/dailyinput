<?php
include 'lib/connect.php';
// include 'lib/spendingData.php';
include 'lib/querySpendingData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

if(!empty($_POST['category']))
{
    //入力画面から取得した項目
    // 対象日
    $rcvTgtDate=$_POST['tgtdate'];
    // カテゴリ
    $rcvCategory = $_POST['category'];
    // 項目
    $rcvItem = $_POST['item'];
    // 出費額
    $rcvPrice = $_POST['price'];
    // 個数
    $rcvQuantity = $_POST['quantity'];

    $spendingdata = new SpendingData();
    $spendingdata->setTxtDate($rcvTgtDate);
    $spendingdata->setCategory($rcvCategory);
    $spendingdata->setItem($rcvItem);
    $spendingdata->setPrice($rcvPrice);
    $spendingdata->setQuantity($rcvQuantity);

    $spendingdata->save();
    
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
            <form class="mt-4 pb-3" action="spendingnew.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="tgtdate" class="col-sm-3 col-form-label">対象日</label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" id="tgtdate" name="tgtdate">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="category" class="col-sm-3 col-form-label">分類</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="category" id="category">
                            <option value="firstchoice" selected>選択して下さい</option>
                            <option value="foods">食材</option>
                            <option value="necessities">日用品</option>
                            <option value="amazon">Amazon</option>
                            <option value="publiccharge">公共料金</option>
                            <option value="tax">税金</option>
                            <option value="medical">医療費</option>
                            <option value="eatingout">外食</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item" class="col-sm-3 col-form-label">項目</label>
                    <div class="col-sm-9">
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
                <div class="form-group row">
                    <label for="price" class="col-sm-3 col-form-label">出費額</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="price" placeholder="出費額" value="" name="price">
                        <div class="err_text" id="err_price"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="quantity" class="col-sm-3 col-form-label">個数</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="quantity" placeholder="個数" value="" name="quantity">
                        <div class="err_text" id="err_quantity"></div>
                    </div>
                </div>
                <div class="mb-5 d-flex justify-content-center align-items-center">
                    <input type="submit" class="btn btn-primary mr-1" value="新規登録" id="buttonNew"></input>
                    <input type="submit" class="btn btn-primary" value="キャンセル" id="buttonCancel"></input>
                </div>
            </form>
        </div>
    </main>
    </div>
    <script type="text/javascript">
            $(function(){
                // selectbox コード選択左側
                $("#category").on("change", change_select);
                // 日付設定
                $('#tgtdate').datepicker();
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