<?php
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('access_denied.twig', []);