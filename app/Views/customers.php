<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="account-list-page">
    <div class="container page-container">
        <div class="page-panel">
            <h1>Customer Accounts</h1>

            <nav class="page-nav" aria-label="Main navigation">
                <a href="<?= base_url('/'); ?>">Home</a>
                <a href="<?= base_url('/about'); ?>">About</a>
                <a href="<?= base_url('/customers'); ?>">Customers</a>
                <a href="<?= base_url('/users'); ?>">Users</a>
                <a href="<?= base_url('/logout'); ?>">Log out</a>
            </nav>

            <div class="page-toolbar">
                <p class="page-description">Manage registered customer lists</p>
                <a class="button" href="<?= base_url('customers/new'); ?>">+ Add New Customer</a>
            </div>

            <ul class="data-list">
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $c): ?>
                        <li class="data-item">
                            <div class="data-details">
                                <strong><?= esc($c['full_name']); ?></strong>
                                <span class="customer-meta">
                                    <?= esc($c['email']); ?>
                                    <?php if (!empty($c['phone'])): ?>
                                        <span aria-hidden="true">•</span>
                                        <?= esc($c['phone']); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <a class="link-button" href="<?= base_url('customers/edit/' . $c['id']); ?>">Edit</a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="empty-state">No customers found.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>