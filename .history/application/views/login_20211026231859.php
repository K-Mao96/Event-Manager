<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>ログイン画面</h2>
    <?php if($error === 'faild') :?>
        <p>ログインIDまたはパスワードが間違っています。</p>
    <?php endif;?>
    <?= form_open();?>
    <?= form_error('login_id','<p>','</p>'); ?>
    <p><?= form_input('login_id',set_value('login_id'),'placeholder = ログインID'); ?></p>

    <?= form_error('login_pass','<p>','</p>'); ?>
    <p><?= form_password('login_pass',set_value('login_pass'),'placeholder = パスワード'); ?></p>

    <p><?= form_submit(null,'ログイン'); ?></p>
    <?= form_close(); ?>
    <?php var_dump($result); ?>
</body>
</html>
