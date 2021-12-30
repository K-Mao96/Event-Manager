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
    <h2>ユーザ詳細ページ</h2>
    <table border="1">
        <?php foreach($user as $item): ?>
            <tr>
                <th>ID</th>
                <td><?= $item->id; ?></td>
            </tr>
            <tr>
                <th>氏名</th>
                <td><?= $item->name; ?></td>
            </tr>
            <tr>
                <th>所属グループ</th>
                <td><?= $item->gname; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="<?= base_url("User/user_index");?>">一覧に戻る</a></p>

    <p><a href="<?= base_url("User/user_edit")."/".$user[0]->id; ?>">編集</a></p>

    <?= form_open(base_url("User/user_delete_done")."/".$user[0]->id);?>
    <p id="alert"><?= form_submit(null,'削除する'); ?></p>
    <?= form_close();?>
    

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
