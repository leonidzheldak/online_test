<?php
require_once dirname(__DIR__) . '/config/config.php';

if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_POST) {
    if (strlen($_POST['password']) < 6) {
        $error = 'Пароль должен быть не короче 6 символов';
    } else {
        $stmt = $pdo -> prepare(
            "INSERT INTO users (email, password, role) VALUES (?, ?, 'user')"
        );
        $stmt->execute([
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        header('Location: login.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <h3>Регистрация</h3>

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

            <button class="btn btn-main w-100">Зарегистрироваться</button>
        </form>

        <div class="auth-footer">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </div>
    </div>
</div>

</body>
</html>