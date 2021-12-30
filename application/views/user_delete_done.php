<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require('parts/header.php'); ?>
    <h2>ユーザ削除</h2>
    <p>ユーザの削除が完了しました。</p>
    <a href="<?= base_url("User/user_index");?>">ユーザ一覧へ戻る</a>
</body>
</html>