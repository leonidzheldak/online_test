<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Настройки базы данных
$host = '127.0.0.1';       // или localhost
$db   = 'ib_test';          // твоя база
$user = 'root';             // пользователь MySQL
$pass = '';                 // пароль
$charset = 'utf8mb4';

// DSN для PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // выбрасывать исключения
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // возвращать ассоциативные массивы
    PDO::ATTR_EMULATE_PREPARES   => false,                  // реальные prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Ошибка подключения к БД: ' . $e->getMessage());
}