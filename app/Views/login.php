<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - POS System</title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body>
    <div class="container auth-container">
        <h1>Staff Login</h1>
        <p class="auth-description">Please sign in to manage accounts</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="auth-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="auth-error">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/attempt'); ?>" method="post">
            <?= csrf_field() ?>
            <div class="auth-field">
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" required>
            </div>
            <div class="auth-field auth-field--last">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button class="auth-submit" type="submit">Sign In</button>
        </form>

        <div class="auth-link">
            <a href="<?= base_url('signup') ?>">Don't have an account? Sign Up</a>
        </div>
    </div>
</body>
</html>