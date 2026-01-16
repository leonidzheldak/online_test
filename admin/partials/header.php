<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/config.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    include __DIR__ . '/access_denied.php';
    exit;
}

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('header.twig', [
    'email' => $_SESSION['user']['email']
]);