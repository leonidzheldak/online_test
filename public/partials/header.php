<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оценка компетенций ИБ</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">ИБ-Тестирование</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="analytics.php">Аналитика</a></li>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="/admin/adminUsers.php">Администрирование</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item text-light me-3">
                        <?= htmlspecialchars($_SESSION['user']['email']) ?>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="logout.php">Выйти</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">