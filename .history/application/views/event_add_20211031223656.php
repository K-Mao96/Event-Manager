<?php
$start = [
	'name' => 'start',
    'value' => set_value('start'),
    'type' => 'date'
];
?>
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
    <h2>08 イベント情報の登録</h2>

    <?= form_open(); ?>
        <p>タイトル</p>
        <p>
            <?= form_error('title','<p>','</p>'); ?>
            <?= form_input('title', set_value('title')); ?>
        </p>
        <p>開始日時（必須）</p>
        <p>
            <?= form_error('start','<p>','</p>'); ?>
            <!-- <?= form_input('start', set_value('start'),$extra); ?> -->
            <?= form_input(); ?>
        </p>
        <p>修了日時</p>
        <p>
            <?= form_error('end','<p>','</p>'); ?>
            <?= form_input('end', set_value('end')); ?>
        </p>
        <p>場所（必須）</p>
        <p>
            <?= form_error('place','<p>','</p>'); ?>
            <?= form_input('place', set_value('place')); ?>
        </p>
        <p>対象グループ</p>
        <p>
            <?= form_error('group','<p>','</p>'); ?>
            <?= form_dropdown('group', $groups); ?>
        </p>
        <p>詳細</p>
        <p>
            <?= form_error('detail','<p>','</p>'); ?>
            <?= form_textarea('detail', set_value('detail')); ?>
        </p>

        <p><a href="<?= base_url("Event/event_index");?>">キャンセル</a></p>
        <p><?= form_submit(null,'保存'); ?></p>
    <?= form_close(); ?>
</body>
</html>
