<?php

namespace lzheldak;

class SectionsController
{
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this -> pdo = $pdo;
    }

    public function getSections()
    {
        return $this -> pdo -> query("SELECT * FROM tests")->fetchAll();
    }

    public function createSection(string $title, string $description = ''): array {
        try {
            // Проверка уникальности названия
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tests WHERE title=?");
            $stmt->execute([$title]);
            if($stmt->fetchColumn() > 0){
                return ['success'=>false, 'error'=>'Раздел с таким названием уже существует'];
            }

            $stmt = $this->pdo->prepare("INSERT INTO tests (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);
            return ['success'=>true, 'id'=>$this->pdo->lastInsertId()];
        } catch (\PDOException $e) {
            return ['success'=>false, 'error'=>$e->getMessage()];
        }
    }

    // Редактировать раздел
    public function editSection(int $id, string $title, string $description = ''): array {
        try {
            // Проверка уникальности названия для других разделов
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tests WHERE title=? AND id<>?");
            $stmt->execute([$title, $id]);
            if($stmt->fetchColumn() > 0){
                return ['success'=>false, 'error'=>'Раздел с таким названием уже существует'];
            }

            $stmt = $this->pdo->prepare("UPDATE tests SET title=?, description=? WHERE id=?");
            $stmt->execute([$title, $description, $id]);

            if($stmt->rowCount() === 0){
                return ['success'=>false, 'error'=>'Раздел не найден или данные не изменились'];
            }

            return ['success'=>true];
        } catch (\PDOException $e) {
            return ['success'=>false, 'error'=>$e->getMessage()];
        }
    }

    // Удалить раздел
    public function deleteSection(int $id): array {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tests WHERE id=?");
            $stmt->execute([$id]);

            if($stmt->rowCount() === 0){
                return ['success'=>false, 'error'=>'Раздел не найден'];
            }

            return ['success'=>true];
        } catch (\PDOException $e) {
            return ['success'=>false, 'error'=>$e->getMessage()];
        }
    }
}