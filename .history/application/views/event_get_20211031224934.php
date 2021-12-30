<?php
$item = $event[0];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script> -->
</head>
<body>
    <?php require('parts/header.php'); ?>
    <h2>イベント詳細ページ</h2>
    <table border="1">
        <tr>
            <th id="title">タイトル</th>
            <td>
                <?= $item->title; ?>
                <?php if($item->unum ): ?>
                    <span>参加</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>開始日時</th>
            <td><?= $item->start; ?></td>
        </tr>
        <tr>
            <th>終了日時</th>
            <td><?= $item->end; ?></td>
        </tr>
        <tr>
            <th>場所</th>
            <td><?= $item->place; ?></td>
        </tr>
        <tr>
            <th>対象グループ</th>
            <td><?= $item->gname; ?></td>
        </tr>
        <tr>
            <th>詳細</th>
            <td><?= $item->detail; ?></td>
        </tr>
        <tr>
            <th>登録者</th>
            <td><?= $item->uname; ?></td>
        </tr>
        <tr>
            <th>参加者</th>
            <td>
                <?php foreach($attend_users as $a_user): ?>
                    <p><?= $a_user->name;?></p>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>

    <p><a href="<?= base_url("Event/event_index");?>">一覧に戻る</a></p>
    
    <?php if((int)$attend_count[0]->count === 0): ?>
        <p><a href="<?= base_url("Event/event_attend_done")."/".$item->id; ?>">参加する</a></p>
    <?php else: ?>
        <p><a href="<?= base_url("Event/event_cancel_attend_done")."/".$item->id; ?>">参加を取り消す</a></p>
    <?php endif; ?>

	<?php if($item->registered_by == $uid): ?>
		<p><a href="<?= base_url("Event/event_edit")."/".$item->id; ?>">編集</a></p>

		<?= form_open(base_url("Event/event_delete_done")."/".$item->id);?>
			<p id="alert"><?= form_submit(null,'削除する'); ?></p>
		<?= form_close();?>
	<?php endif; ?>
        
    <script>
        "use strict";
        {
            const alert = document.getElementById('alert');
            
            alert.addEventListener('click',e =>{
                e.preventDefault();
                if(confirm('本当に削除してよろしいですか？')){
                    alert.parentNode.submit();
                }
            });

        }
    </script>
    
</body>
</html>
