<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="account-list-page">
    <div class="container page-container">
        <div class="page-panel">
            <h1>User / Staff Accounts</h1>

            <nav class="page-nav" aria-label="Main navigation">
                <a href="<?= base_url('/'); ?>">Home</a>
                <a href="<?= base_url('/about'); ?>">About</a>
                <a href="<?= base_url('/customers'); ?>">Customers</a>
                <a href="<?= base_url('/users'); ?>">Users</a>
                <a href="<?= base_url('/logout'); ?>">Log out</a>
            </nav>

            <div class="page-toolbar">
                <p class="page-description">Manage system staff and user profiles</p>
                <a class="button" href="<?= base_url('users/new'); ?>">+ Add New User</a>
            </div>

            <ul class="data-list">
                <?php if (!empty($users) && is_array($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <?php
                            // This handles $user whether it's an array OR an object
                            $username = is_array($user) ? ($user['username'] ?? '') : ($user->username ?? '');
                            $fullName = is_array($user) ? ($user['full_name'] ?? '') : ($user->full_name ?? '');
                            $role     = is_array($user) ? ($user['role'] ?? '') : ($user->role ?? '');
                        ?>
                        <?php
                            $userId = is_array($user) ? ($user['id'] ?? null) : ($user->id ?? null);
                            $avatarName = is_array($user) ? ($user['avatar'] ?? null) : ($user->avatar ?? null);
                            $placeholderSrc = base_url('uploads/avatar-placeholder.svg');
                            $avatarSrc = $placeholderSrc;

                            if (is_string($avatarName) && $avatarName !== '') {
                                $safeAvatarName = basename($avatarName);
                                $avatarPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $safeAvatarName;

                                if (is_file($avatarPath)) {
                                    $avatarSrc = base_url('uploads/' . rawurlencode($safeAvatarName));
                                }
                            }
                        ?>
                        <li class="data-item user-list-item">
                            <div class="user-summary">
                                <img
                                    class="user-avatar"
                                    src="<?= esc($avatarSrc, 'attr'); ?>"
                                    alt="<?= esc($username, 'attr'); ?> profile picture"
                                    onerror="this.onerror=null;this.src='<?= esc($placeholderSrc, 'attr'); ?>';"
                                >
                                <div class="data-details">
                                    <strong><?= esc($username); ?></strong>
                                    <span class="user-meta">
                                        <?= esc($fullName); ?>
                                        <span aria-hidden="true">•</span>
                                        <em>Role: <?= esc($role); ?></em>
                                    </span>
                                </div>
                            </div>
                            <a class="link-button" href="<?= base_url('users/edit/' . $userId); ?>">Edit</a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="empty-state">No users found in the database.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>