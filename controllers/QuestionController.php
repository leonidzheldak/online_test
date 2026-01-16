<?php

namespace lzheldak;

class QuestionController
{
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this -> pdo = $pdo;
    }

    public function getQuestions()
    {
        return $this -> pdo -> query("SELECT * FROM questions") -> fetchAll();
    }

    public function getQuestionsAnswers()
    {
        return $this -> pdo -> query("SELECT * FROM answers") -> fetchAll();
    }
}