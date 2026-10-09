<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
</head>
<body>
    <h1>Customer Accounts</h1>
    
    <nav style="margin-bottom: 20px;">
        <a href="<?= base_url('/'); ?>">Home</a> |
        <a href="<?= base_url('/about'); ?>">About</a> |
        <a href="<?= base_url('/customers'); ?>">Customers</a> |
        <a href="<?= base_url('/users'); ?>">Users</a>
    </nav>

    <ul>
        <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $c): ?>
                <li>
                    <strong><?= esc($c['full_name']); ?></strong> - 
                    <?= esc($c['email']); ?> - 
                    <?= esc($c['phone']); ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No customers found.</p>
        <?php endif; ?>
    </ul>
</body>
</html>