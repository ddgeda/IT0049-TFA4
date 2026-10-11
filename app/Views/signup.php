<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - POS System</title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body>
    <div class="container auth-container">
        <h1>Staff Sign Up</h1>
        <p class="auth-description">Create a new account</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="auth-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('signup/attempt') ?>" method="post">
            <?= csrf_field() ?>
            <div class="auth-field">
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" value="<?= old('username') ?>" required>
            </div>
            <div class="auth-field auth-field--last">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button class="auth-submit" type="submit">Register Account</button>
        </form>
        
        <div class="auth-link">
            <a href="<?= base_url('login') ?>">Already have an account? Sign In</a>
        </div>
    </div>
</body>
</html>