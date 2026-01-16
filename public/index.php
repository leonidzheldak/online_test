<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';
require 'partials/header.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$tests = $pdo->query("SELECT * FROM tests ORDER BY id")->fetchAll();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates/public');
$twig = new \Twig\Environment($loader);

echo $twig -> render('main.twig', [
    'user' => $_SESSION['user'] ?? null,
    'tests' => $tests
]);

require 'partials/footer.php';