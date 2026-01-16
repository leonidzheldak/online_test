<?php

require_once __DIR__ . '/partials/header.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/controllers/UserController.php';

$userController = new \lzheldak\UserController($pdo);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('users.twig', [
    'user' => $_SESSION['user'] ?? null,
    'users' => $userController -> getUsers()
]);

require_once __DIR__ . '/partials/footer.php';