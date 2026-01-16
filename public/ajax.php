<?php

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/controllers/UserController.php';
require_once dirname(__DIR__) . '/controllers/SectionsController.php';

header('Content-Type: application/json');

$userController = new \lzheldak\UserController($pdo);
$sectionsController = new \lzheldak\SectionsController($pdo);

$action = $_POST['action'] ?? null;

if($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if(!$id){
        echo json_encode(['success'=>false,'error'=>'Некорректный ID']);
        exit;
    }

    $res = $userController->deleteUser($id);
    echo json_encode($res);
    exit;
}

if($action === 'create') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if(!$email || !$password){
        echo json_encode(['success'=>false,'error'=>'Email или пароль пустые']);
        exit;
    }

    $res = $userController->createUser($email, $password, $role);
    echo json_encode($res);
    exit;
}

if ($action === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? 'user';

    if (!$id || !$email || !in_array($role, ['user','admin'])) {
        echo json_encode(['success'=>false, 'error'=>'Некорректные данные']);
        exit;
    }

    $res = $userController->editUser($id, $email, $password, $role);
    echo json_encode($res);
    exit;
}

if ($action == 'create_section') {
    $title = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if(!$title){
        echo json_encode(['success'=>false, 'error'=>'Название обязательно']);
        exit;
    }
    echo json_encode($sectionsController->createSection($title, $description));
    exit;
}

if ($action == 'edit_section') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if(!$id || !$title){
        echo json_encode(['success'=>false, 'error'=>'Некорректные данные']);
        exit;
    }
    echo json_encode($sectionsController->editSection($id, $title, $description));
    exit;
}

if ($action == 'delete_section') {
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['success' => false, 'error' => 'Некорректный ID']);
        exit;
    }
    echo json_encode($sectionsController->deleteSection($id));
    exit;
}

echo json_encode(['success'=>false,'error'=>'Неизвестное действие']);