<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($heading); ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="customer-form-page">
    <div class="container auth-container">
        <div class="page-panel">
            <h1><?= esc($heading); ?></h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-error">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= esc($formAction); ?>" method="post">
                <?= csrf_field() ?>

                <div class="auth-field">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" value="<?= esc(old('full_name', $customer['full_name'] ?? '')); ?>" required>
                </div>

                <div class="auth-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?= esc(old('email', $customer['email'] ?? '')); ?>" required>
                </div>

                <div class="auth-field auth-field--last">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" value="<?= esc(old('phone', $customer['phone'] ?? '')); ?>">
                </div>

                <button class="auth-submit" type="submit">Save customer</button>
            </form>

            <div class="auth-link">
                <a href="<?= base_url('customers'); ?>">Back to customers</a>
            </div>
        </div>
    </div>
</body>
</html>