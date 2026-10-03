<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Accounts</title>
</head>
<body>
    <!-- Simple navigation links -->
    <nav>
        <a href="<?= base_url('/'); ?>">Home</a> |
        <a href="<?= base_url('/about'); ?>">About</a> |
        <a href="<?= base_url('/customers'); ?>">Customers</a> |
        <a href="<?= base_url('/users'); ?>">Users</a>
    </nav>
    <hr>

    <h1>User / Staff Accounts</h1>
    
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <strong><?= $user['username']; ?></strong> - 
                <?= $user['full_name']; ?> 
                <em>(Role: <?= $user['role']; ?>)</em>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>