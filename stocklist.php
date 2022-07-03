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
                    <div class="table-responsive-md">
                        <table class="table table-hover table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>分類</th>
                                    <th>項目</th>
                                    <th>残数</th>
                                    <th>編集</th>
                                    <th>削除</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                    <th>1</th>
                                    <td>食材</td>
                                    <td>カレー</td>
                                    <td>3</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>

                                <tr>
                                    <th>2</th>
                                    <td>食材</td>
                                    <td>ラーメン</td>
                                    <td>5</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td>食材</td>
                                    <td>うどん</td>
                                    <td>６</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td>食材</td>
                                    <td>蕎麦</td>
                                    <td>3</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <td>食材</td>
                                    <td>中華そば</td>
                                    <td>６</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>6</th>
                                    <td>食材</td>
                                    <td>ハンバーグ</td>
                                    <td>3</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>7</th>
                                    <td>食材</td>
                                    <td>野菜</td>
                                    <td>2</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>8</th>
                                    <td>食材</td>
                                    <td>コロッケ</td>
                                    <td>2</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>9</th>
                                    <td>食材</td>
                                    <td>アルコール</td>
                                    <td>2</td>
                                    <td><a href="edit.php" class="btn btn-primary btn-xs">編集</a></td>
                                    <td><a href="" class="btn btn-primary btn-xs">削除</a></td>
                                </tr>
                                <tr>
                                    <th>10</th>
                                    <td>食材</td>
                                    <td>お肉</td>
                                    <td>1</td>
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
