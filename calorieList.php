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
            /* .result {
                font-size: 1rem;
            } */
        }
    </style>
    <title>Calorie</title>
</head>

<body style=" padding-top: 50px;">
    <?php include 'calorieheader.php';?>
    <div class="container mb-3">
        <main>
            <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="h5 col-md-4 result"><p class="text-center">前日</p></div>
                        <div class="h5 col-md-4 result"><p class="text-center">2022/06/11</p></div>
                        <div class="h5 col-md-4 result"><p class="text-center">翌日</p></div>
                    </div>
                    <div class="row">
                        <div class="h4 col-md-4 result"><p class="text-center">目標熱量:1600</p></div>
                        <div class="h4 col-md-4 result"><p class="text-center">現在熱量:1250</p></div>
                        <div class="h4 col-md-4 result"><p class="text-center">差分熱量:350</p></div>
                    </div>
                    <div class="table-responsive-md">
                        <table class="table table-hover table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>分類</th>
                                    <th>項目</th>
                                    <th>熱量</th>
                                    <th>画像</th>
                                    <th>編集</th>
                                    <th>削除</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                    <th>1</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>

                                <tr>
                                    <th>2</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>6</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>7</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>8</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>9</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>10</th>
                                    <td><a href="detail.html">外食</a></td>
                                    <td>王将セット</td>
                                    <td>1250</td>
                                    <td>画像</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include 'footer.php';?> 

</body>

</html>