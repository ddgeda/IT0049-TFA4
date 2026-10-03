<h1>Customer Accounts</h1>
<ul>
    <?php foreach ($customers as $c): ?>
        <li><strong><?= $c['name']; ?></strong> - <?= $c['email']; ?> - <?= $c['phone']; ?></li>
    <?php endforeach; ?>
</ul>