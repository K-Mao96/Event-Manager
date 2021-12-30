<?php
$start = 
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
    <h2>イベント一覧</h2>
    <?= $this->pagination->create_links(); ?>
    <table border="1">
        <tr>
            <th>タイトル</th>
            <th>開始日時</th>
            <th>場所</th>
            <th>対象グループ</th>
            <th>詳細</th>
        </tr>
        <?php foreach($events as $index => $event): ?>
            <tr>
                <td>
                    <?= $event->title; ?>
                    <?php if((int)$count[$index][0]->count === 1) :?>
                        <span>参加</span>
                    <?php endif; ?>
                </td>
                <td><?= $event->start; ?></td>
                <td><?= $event->place; ?></td>
                <td><?= $event->gname; ?></td>
                <td><a href="<?= base_url("Event/event_get")."/".$event->id; ?>">詳細</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="<?= base_url("Event/event_add");?>">イベントの登録</a></p>
</body>
</html>
