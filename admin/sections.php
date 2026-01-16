<?php

require_once __DIR__ . '/partials/header.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/controllers/SectionsController.php';

$sectionsController = new \lzheldak\SectionsController($pdo);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('sections.twig', [
    'user' => $_SESSION['user'] ?? null,
    'sections' => $sectionsController -> getSections()
]);

require_once __DIR__ . '/partials/footer.php';