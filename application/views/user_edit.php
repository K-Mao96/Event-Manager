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
    <h2>ユーザ編集</h2>

    <?= form_open(); ?>
    <?php foreach($user as $item) :?>
        <p>氏名（必須）</p>
        <p>
            <?= form_error('name','<p>','</p>'); ?>
            <?= form_input('name', set_value('name',$item->name)); ?>
        </p>
        <p>ログインID（必須）</p>
        <p>
            <?= form_error('login_id','<p>','</p>'); ?>
            <?= form_input('login_id', set_value('login_id',$item->login_id)); ?>
        </p>
        <p>パスワード（変更の場合のみ）</p>
        <p>
            <?= form_error('login_pass','<p>','</p>'); ?>
            <?= form_password('login_pass', set_value('login_pass')); ?>
        </p>
        <p>所属グループ（必須）</p>
        <p>
            <?= form_error('group','<p>','</p>'); ?>
            <?= form_dropdown('group', $groups); ?>
        </p>
        <p>付与する権限の種類（必須）</p>
        <p>
            <?= form_error('user_type','<p>','</p>'); ?>
            <?= form_dropdown('user_type', $utypes); ?>
        </p>
    <?php endforeach; ?>

        <p><a href="<?= base_url("User/user_get")."/".$item->id;?>">キャンセル</a></p>
        <p><?= form_submit(null,'保存'); ?></p>
    <?= form_close(); ?>
</body>
</html>