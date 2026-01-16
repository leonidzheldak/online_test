<?php

require_once __DIR__ . '/partials/header.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/controllers/QuestionController.php';
require_once dirname(__DIR__) . '/controllers/SectionsController.php';

$questionsController = new \lzheldak\QuestionController($pdo);
$sectionsController = new \lzheldak\SectionsController($pdo);

$answers = $questionsController -> getQuestionsAnswers();
$answersByQuestion = [];
foreach ($answers as $answer) {
    $answersByQuestion[$answer['question_id']][] = $answer;
}

$questions = $questionsController -> getQuestions();
foreach ($questions as $question) {
    $question['answers'] = $answersByQuestion[$question['id']];
    $groupedQuestions[$question['test_id']][] = $question;
}

$sections = $sectionsController -> getSections();
foreach ($sections as &$section) {
    $section['questions'] = $groupedQuestions[$section['id']];
    unset($groupedQuestions[$section['id']]);
}

$orphaned = [];
foreach ($groupedQuestions as $questionsInGroup) {
    $orphaned = array_merge($orphaned, $questionsInGroup);
}

if (!empty($orphaned)) {
    array_unshift($sections, [
        'id' => 0,
        'title' => 'Вопросы без раздела',
        'questions' => $orphaned,
    ]);
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates/admin');
$twig = new \Twig\Environment($loader);

echo $twig -> render('questions.twig', [
    'sections' => $sections
]);

require_once __DIR__ . '/partials/footer.php';