<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($heading); ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>
<body class="user-form-page">
    <div class="container auth-container">
        <div class="page-panel">
            <h1><?= esc($heading); ?></h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-error">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= esc($formAction); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="auth-field">
                    <label for="username">Username</label>
                    <input id="username" name="username" value="<?= esc(old('username', $user['username'] ?? '')); ?>" required minlength="3">
                </div>

                <div class="auth-field">
                    <label for="password">Password<?= $isEdit ? ' (leave blank to keep current)' : ''; ?></label>
                    <input id="password" type="password" name="password" minlength="8" <?= $isEdit ? '' : 'required'; ?>>
                </div>

                <div class="auth-field auth-field--last">
                    <label for="avatar">Profile picture</label>
                    <input id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    <small class="form-help">JPG or PNG only, max 2MB.</small>
                </div>

                <button class="auth-submit" type="submit">Save user</button>
            </form>

            <div class="auth-link">
                <a href="<?= base_url('users'); ?>">Back to users</a>
            </div>
        </div>
    </div>
</body>
</html>