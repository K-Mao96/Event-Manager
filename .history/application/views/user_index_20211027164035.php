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
    <h2>ユーザ一覧</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>氏名</th>
            <th>所属グループ</th>
            <th>詳細</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user->id; ?></td>
                <td><?= $user->name; ?></td>
                <td><?= $user->gname; ?></td>
                <td><a href="<?= base_url("User/user_get")."/".$user->id; ?>">詳細</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="<?= base_url("User/user_add");?>">ユーザの登録</a></p>
</body>
</html>