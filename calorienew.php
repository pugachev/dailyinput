<?php



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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <title>新規登録画面</title>
</head>

<body>
    <div style="padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <main>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-4 pb-3" action="new.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="hometown" class="col-sm-3 col-form-label">分類</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="birthplace" id="birthplace">
                            <option value="" selected>選択して下さい</option>
                            <option value="外食">外食</option>
                            <option value="お惣菜">お惣菜</option>
                            <option value="お菓子">お菓子</option>
                            <option value="酒">酒</option>
                        </select>
                        <div class="err_text" id="err_birthplace"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item" class="col-sm-3 col-form-label">項目</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="item" placeholder="項目" value="" name="item">
                        <div class="err_text" id="err_item"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="calorie" class="col-sm-3 col-form-label">熱量</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="calorie" placeholder="カロリー" value="" name="calorie">
                        <div class="err_text" id="err_calorie"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="momentum" class="col-sm-3 col-form-label">運動量</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="momentum" placeholder="運動量" value="" name="momentum">
                        <div class="err_text" id="err_momentum"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="addImage" class="col-sm-3 col-form-label">画像</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" name="picdata" class="form-control">
                            <label class="custom-file-label" for="addImage">ファイル選択...</label>
                        </div>
                    </div>
                </div>
                <div class="mb-5 d-flex justify-content-center align-items-center">
                    <input type="button" class="btn btn-primary" value="新規登録" id="buttonNew"></input>
                </div>
            </form>
        </div>
    </main>
    </div>
    <script type="text/javascript">
            $("#buttonNew").on("click",function(){
                if(!formCheck())
                {
                    return false;
                }
                else
                {
                    $("#newform").submit();
                }

            });

            function deleteErrorMessage(tgt)
            {
                // $("#'+tg+t p").remove();
                alert("クリックされた");
                return false;
            }

            function formCheck(){
                var ret=true;
                //名前チェック(入力をチェック)
                $("#err_namebox p").remove();
                if($('input[name=womanname]').val()=='')
                {
                    $("#err_namebox").append("<p style='font-size:16px;color:red;'>お名前を入力してください。</p>");
                    ret = false;
                }

                //年齢チェック(入力と数値チェック)
                $("#err_agebox p").remove();
                var tmpage = $('input[name="age"]').val();
                if(tmpage=="" || !$.isNumeric(tmpage))
                {
                    $("#err_agebox").append("<p style='font-size:16px;color:red;'>年齢を入力してください。</p>");
                    ret = false;
                }
                //生年月日(選択チェック)
                $("#err_birthdaybox p").remove();
                // if( $('input[name="date"]').text()=='')
                if($("#dateOfBirth").val()=='')
                {
                    $("#err_birthdaybox").append("<p style='font-size:16px;color:red;'>生年月日を入力してください。</p>");
                    ret = false;
                }
                //出身地(選択チェック)
                $("#err_birthplace p").remove();
                var selected = $('#birthplace option:selected');
                if (!selected.val() || !selected.val()=='都道府県') {
                    $("#err_birthplace").append("<p style='font-size:16px;color:red;'>出身地を入力してください。</p>");
                    ret = false;
                }

                //血液型(選択をチェック)
                $("#err_bloodtype p").remove();
                var tmpbloodtyp = 0;
                $('input[name=bloodtype]').each(function () {
                    if ($(this).prop('checked')) { tmpbloodtyp++; }
                });
                if (tmpbloodtyp==0) {
                    $('#err_bloodtype').append("<p style='font-size:16px;color:red;'>血液型を選択してください。</p>");
                }
                //分類(選択をチェック)
                $("#err_categorytype p").remove();
                var tmpcategory = 0;
                $('input[name=category]').each(function () {
                    if ($(this).prop('checked')) { tmpcategory++; }
                });
                if (tmpcategory==0) {
                    $('#err_categorytype').append("<p style='font-size:16px;color:red;'>分類を選択してください。</p>");
                }
                //身長チェック(入力と数値チェック)
                $("#err_heghtbox p").remove();
                var tmpheight = $('input[name="height"]').val();
                if(tmpheight=="" || !$.isNumeric(tmpheight))
                {
                    $("#err_heghtbox").append("<p style='font-size:16px;color:red;'>身長を入力してください。</p>");
                    ret = false;
                }
                return ret;
            }

            //名前チェック
            $("#womanname").bind("blur", function() {
                $("#err_namebox p").remove();
                if($('input[name="womanname"]').val()==""){
                    $("#err_namebox").append("<p style='font-size:16px;color:red;'>名前を入力してください。</p>");
                    return false;
                }
            });

            //年齢チェック
            $("#age").bind("blur", function() {
                $("#err_agebox p").remove();
                var tmpage = $('input[name="age"]').val();
                if(tmpage=="" || !$.isNumeric(tmpage)){
                    $("#err_agebox").append("<p style='font-size:16px;color:red;'>年齢を入力してください。</p>");
                    return false;
                }
            });

            //生年月日チェック
            $("#birthday").bind("blur", function() {
                $("#err_birthdaybox p").remove();
                if($('input[type="date"]').val()==""){
                    $("#err_birthdaybox").append("<p style='font-size:16px;color:red;'>生年月日を入力してください。</p>");
                    return false;
                }
            });

            //身長ボタンチェック
            $("#height").bind("blur", function() {
                $("#err_heghtbox p").remove();
                if($('input[name="height"]').val()==""){
                    $("#err_heghtbox").append("<p style='font-size:16px;color:red;'>身長を入力してください。</p>");
                    return false;
                }
            });
            $(function(){
                $('#dateOfBirth').change(function(){
                    $("#err_birthdaybox p").remove();
                });
                $('#birthplace').change(function(){
                    $("#err_birthplace p").remove();
                });
                $( 'input[name="bloodtype"]:radio' ).change( function() {
                    $("#err_bloodtype p").remove();
                });
                $( 'input[name="category"]:radio' ).change( function() {
                    $("#err_categorytype p").remove();
                }); 
            });
    </script>
    <?php include 'footer.php';?>

</body>

</html>