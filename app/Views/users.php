<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
</head>
<body>
    <h1>User / Staff Accounts</h1>

    <nav style="margin-bottom: 20px;">
    <a href="<?= base_url('/'); ?>">Home</a> |
    <a href="<?= base_url('/about'); ?>">About</a> |
    <a href="<?= base_url('/customers'); ?>">Customers</a> |
    <a href="<?= base_url('/users'); ?>">Users</a>
    </nav>

    <ul>
        <?php if (!empty($users) && is_array($users)): ?>
            <?php foreach ($users as $user): ?>
                <?php 
                    // This handles $user whether it's an array OR an object
                    $username = is_array($user) ? ($user['username'] ?? '') : ($user->username ?? '');
                    $fullName = is_array($user) ? ($user['full_name'] ?? '') : ($user->full_name ?? '');
                    $role     = is_array($user) ? ($user['role'] ?? '') : ($user->role ?? '');
                ?>
                <li>
                    <strong><?= esc($username); ?></strong> - 
                    <?= esc($fullName); ?> 
                    <em>(Role: <?= esc($role); ?>)</em>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No users found in the database.</p>
        <?php endif; ?>
    </ul>
</body>
</html>