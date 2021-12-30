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
    <h2>受付完了しました</h2>
    <a href="<?= base_url('Event/event_get')."/".$id;?>">イベント詳細に戻る</a>
</body>
</html>