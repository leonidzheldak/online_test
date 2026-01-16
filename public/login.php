<?php
require_once dirname(__DIR__) . '/config/config.php';

if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_POST) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверный email или пароль';
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <h3>Вход в систему</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button class="btn btn-main w-100">Войти</button>
        </form>

        <div class="auth-footer">
            Нет аккаунта? <a href="register.php">Регистрация</a>
        </div>
    </div>
</div>

</body>
</html>