<header>
    <ul>
        <li><a href="<?= base_url("Event/event_today"); ?>">本日のイベント</a></li>
        <li><a href="<?= base_url("Event/event_index"); ?>">イベント管理</a></li>
        <?php if($type === 2):?>
            <li><a href="<?= base_url("User/user_index"); ?>">ユーザ管理</a></li>
        <?php endif; ?>
    </ul>
</header>