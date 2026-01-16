<?php

namespace lzheldak;

class UserController
{
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this -> pdo = $pdo;
    }
    public function getUsers()
    {
        return $this -> pdo -> query("SELECT * FROM users") -> fetchAll();
    }

    public function createUser(string $email, string $password, string $role = 'user'): array {
        try {
            // Проверяем, есть ли уже такой email
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email=?");
            $stmt->execute([$email]);
            if($stmt->fetchColumn() > 0){
                return [
                    'success' => false,
                    'error' => 'Пользователь с таким email уже существует'
                ];
            }

            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO users (email,password,role) VALUES (?,?,?)");
            $stmt->execute([$email, $passHash, $role]);

            return [
                'success' => true,
                'id' => $this->pdo->lastInsertId()
            ];
        } catch (\PDOException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function editUser(int $id, string $email, string $password = '', string $role = 'user'): array {
        try {
            // Проверка, что пользователь существует
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE id=?");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                return ['success' => false, 'error' => 'Пользователь не найден'];
            }

            if ($password) {
                $passHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE users SET email=?, password=?, role=? WHERE id=?");
                $stmt->execute([$email, $passHash, $role, $id]);
            } else {
                $stmt = $this->pdo->prepare("UPDATE users SET email=?, role=? WHERE id=?");
                $stmt->execute([$email, $role, $id]);
            }

            return ['success' => true];
        } catch (\PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function deleteUser(int $id): array {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=?");
            $stmt->execute([$id]);
            if($stmt->rowCount() === 0){
                return ['success' => false, 'error' => 'Пользователь не найден'];
            }
            return ['success'=>true];
        } catch (\PDOException $e) {
            return ['success'=>false, 'error' => $e->getMessage()];
        }
    }
}