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
    <h2>本日のイベント</h2>
	<?php var_dump($total_rows[0]->count()); ?>
    <?= $this->pagination->create_links(); ?>
    <table border="1">
        <tr>
            <th>タイトル</th>
            <th>開始日時</th>
            <th>場所</th>
            <th>対象グループ</th>
            <th>詳細</th>
        </tr>
        <?php foreach($events as $event): ?>
            <tr>
                <td><?= $event->title; ?></td>
                <td><?= $event->start; ?></td>
                <td><?= $event->place; ?></td>
                <td><?= $event->group_id; ?></td>
                <td><a href="<?= base_url("Event/event_get")."/".$event->id; ?>">詳細</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
