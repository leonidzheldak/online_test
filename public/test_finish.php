<?php
require_once dirname(__DIR__) . '/config/config.php';
require 'partials/header.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$test_id = (int)($_GET['test_id'] ?? 0);
if (!$test_id) { echo "Тест не найден"; exit; }

// Получаем результаты пользователя
$stmt = $pdo->prepare("
    SELECT q.text as question_text, a.text as answer_text, r.correct
    FROM results r
    JOIN questions q ON r.question_id = q.id
    LEFT JOIN answers a ON r.answer_id = a.id
    WHERE r.user_id=? AND q.test_id=?
");
$stmt->execute([$_SESSION['user']['id'],$test_id]);
$results = $stmt->fetchAll();

// Сбрасываем сессию для возможности пройти заново
unset($_SESSION['tests'][$test_id]);
?>

    <div class="container mt-5">
        <h4>Результаты теста: <?= htmlspecialchars($test_id) ?></h4>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Вопрос</th>
                <th>Ваш ответ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $r): ?>
                <tr class="<?= $r['correct'] ? 'table-success' : 'table-danger' ?>">
                    <td><?= htmlspecialchars($r['question_text']) ?></td>
                    <td><?= htmlspecialchars($r['answer_text']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <a href="test.php?test_id=<?= $test_id ?>" class="btn btn-main mt-3">Пройти заново</a>
        <a href="index.php" class="btn btn-secondary mt-3">В главное меню</a>
    </div>

<?php require 'partials/footer.php'; ?>