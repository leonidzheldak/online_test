<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('footer.twig', []);