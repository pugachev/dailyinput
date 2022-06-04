<?php
include '../lib/connect.php';
include '../lib/queryPersonalData.php';

header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header('Cache-Control:no-cache,no-store,must-revalidate,max-age=0');
header('Cache-Control:pre-check=0,post-check=0',false);
header('Pragma:no-cache');

$ret=false;
if(!empty($_POST['womanname']))
{
    //入力画面から取得した項目
    $rcvName = $_POST['womanname'];
    $rcvAge = $_POST['age'];
    $rcvBirthday = $_POST['birthday'];
    $rcvBirthPlace = $_POST['birthplace'];
    $rcvBloodType = $_POST['bloodtype'];
    $rcvCategory = $_POST['category'];
    $rcvHeight = $_POST['height'];
    $rcvNotices = $_POST['notices'];
    $rcvPicData0 = "nodata.png";
    $rcvPicData1 = "nodata.png";
    $rcvPicData2 = "nodata.png";

    $search = new QueryPersonalData();
    $ret = $search->getDatumByName($_POST['womanname']);
    //戻り値:trueの場合は既に名前が存在するのでエラー処理する
    if(!$ret)
    {
        if(isset($_FILES["picdata"]))
        {
            $tgtfilename = $rcvName;
            
            // アップロードされたファイル件を処理
            foreach ($_FILES["picdata"]["tmp_name"] as $no => $tmp_name) 
            {
                // アップロードされたファイルか検査
                if(is_uploaded_file($_FILES["picdata"]["tmp_name"][$no]))
                {
                    $tgtfilename='';
                    $tgtfilename .= $rcvName;
                    $tgtfilename .= '_';
                    $tgtfilename .= $no;
                    $tgtfilename .= '.jpg';
                    move_uploaded_file($_FILES["picdata"]["tmp_name"][$no], "uploads/" . $tgtfilename);

                    if($no==0)
                    {
                        $rcvPicData0 = $tgtfilename;
                    }
                    else if($no==1)
                    {
                        $rcvPicData1 = $tgtfilename;
                    }
                    else if($no==2)
                    {
                        $rcvPicData2 = $tgtfilename;
                    }
                }
                
            }
        }

        $personaldata = new PersonalData();
        $personaldata->setName($rcvName);
        $personaldata->setAge($rcvAge);
        $personaldata->setBirthday($rcvBirthday);
        $personaldata->setBirthplace($rcvBirthPlace);
        $personaldata->setBloodtype($rcvBloodType);
        $personaldata->setCategory($rcvCategory);
        $personaldata->setHeight($rcvHeight);
        $personaldata->setNotices($rcvNotices);
        $personaldata->setPicdata0($rcvPicData0);
        $personaldata->setPicdata1($rcvPicData1);
        $personaldata->setPicdata2($rcvPicData2);
        $personaldata->save();
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
    <?php include 'header.php';?>
    <main>
        <?php if($ret){
            print '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            print '<p class="text-center"><strong>登録エラー</strong>'.$rcvName.'既に存在している名前です</p>';
            print '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            print '<span aria-hidden="true">&times;</span>';
            print '</button>';
            print '</div>';
        } ?>
        <div class="errorMsg"></div>
        <div class="container">
            <form class="mt-3 pb-3" action="new.php" enctype="multipart/form-data" method="post" id="newform">
                <div class="form-group row">
                    <label for="womanname" class="col-sm-3 col-form-label">名前</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="womanname" placeholder="名前" value="" name="womanname">
                        <div class="err_text" id="err_namebox"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="age" class="col-sm-3 col-form-label">年齢</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="age" placeholder="年齢" value="" name="age">
                        <div class="err_text" id="err_agebox"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dateOfBirth" class="col-sm-3 col-form-label">生年月日</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="dateOfBirth" placeholder="yyyy-mm-dd" value="" name="birthday">
                        <div class="err_text" id="err_birthdaybox"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hometown" class="col-sm-3 col-form-label">出身地</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="birthplace" id="birthplace">
                            <option value="" selected>都道府県</option>
                            <option value="北海道">北海道</option>
                            <option value="青森県">青森県</option>
                            <option value="岩手県">岩手県</option>
                            <option value="宮城県">宮城県</option>
                            <option value="秋田県">秋田県</option>
                            <option value="山形県">山形県</option>
                            <option value="福島県">福島県</option>
                            <option value="茨城県">茨城県</option>
                            <option value="栃木県">栃木県</option>
                            <option value="群馬県">群馬県</option>
                            <option value="埼玉県">埼玉県</option>
                            <option value="千葉県">千葉県</option>
                            <option value="東京都">東京都</option>
                            <option value="神奈川県">神奈川県</option>
                            <option value="新潟県">新潟県</option>
                            <option value="富山県">富山県</option>
                            <option value="石川県">石川県</option>
                            <option value="福井県">福井県</option>
                            <option value="山梨県">山梨県</option>
                            <option value="長野県">長野県</option>
                            <option value="岐阜県">岐阜県</option>
                            <option value="静岡県">静岡県</option>
                            <option value="愛知県">愛知県</option>
                            <option value="三重県">三重県</option>
                            <option value="滋賀県">滋賀県</option>
                            <option value="京都府">京都府</option>
                            <option value="大阪府">大阪府</option>
                            <option value="兵庫県">兵庫県</option>
                            <option value="奈良県">奈良県</option>
                            <option value="和歌山県">和歌山県</option>
                            <option value="鳥取県">鳥取県</option>
                            <option value="島根県">島根県</option>
                            <option value="岡山県">岡山県</option>
                            <option value="広島県">広島県</option>
                            <option value="山口県">山口県</option>
                            <option value="徳島県">徳島県</option>
                            <option value="香川県">香川県</option>
                            <option value="愛媛県">愛媛県</option>
                            <option value="高知県">高知県</option>
                            <option value="福岡県">福岡県</option>
                            <option value="佐賀県">佐賀県</option>
                            <option value="長崎県">長崎県</option>
                            <option value="熊本県">熊本県</option>
                            <option value="大分県">大分県</option>
                            <option value="宮崎県">宮崎県</option>
                            <option value="鹿児島県">鹿児島県</option>
                            <option value="沖縄県">沖縄県</option>
                        </select>
                        <div class="err_text" id="err_birthplace"></div>
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-3 pt-0">血液型</legend>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="bloodtype" id="bloodTypeA" value="A">
                                <label class="form-check-label" for="bloodTypeA">
                                    A型
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="bloodtype" id="bloodTypeB" value="B">
                                <label class="form-check-label" for="bloodTypeB">
                                    B型
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="bloodtype" id="bloodTypeAB" value="AB">
                                <label class="form-check-label" for="bloodTypeAB">
                                    AB型
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="bloodtype" id="bloodTypeO" value="O">
                                <label class="form-check-label" for="bloodTypeO">
                                    O型
                                </label>
                            </div>
                            <div class="err_text" id="err_bloodtype"></div>
                        </div>  
                    </div>
                </fieldset>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-3 pt-0">分類</legend>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="announcer" value="局アナ">
                                <label class="form-check-label" for="announcer">
                                    局アナ
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="free" value="フリー">
                                <label class="form-check-label" for="free">
                                    フリー
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="actress" value="女優">
                                <label class="form-check-label" for="actress">
                                    女優
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="model" value="モデル">
                                <label class="form-check-label" for="model">
                                    モデル
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="other" value="それ以外">
                                <label class="form-check-label" for="other">
                                    その他
                                </label>
                            </div>
                            <div class="err_text" id="err_categorytype"></div>
                        </div>
                    </div>
                    
                </fieldset>
                <div class="form-group row">
                    <label for="height" class="col-sm-3 col-form-label">身長（cm）</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="height" placeholder="165" value="" name="height">
                        <div class="err_text" id="err_heghtbox"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="speciality" class="col-sm-3 col-form-label">特記事項</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tgtspeciality" placeholder="特記事項" value="" name="notices">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="addImage" class="col-sm-3 col-form-label">画像（追加）</label>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <!-- <input type="file" class="custom-file-input" id="addImage" lang="ja" name="picdata[]" multiple="multiple"> -->
                            <input type="file" class="custom-file-input" id="addImage" lang="ja" name="picdata[]" multiple="multiple">
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