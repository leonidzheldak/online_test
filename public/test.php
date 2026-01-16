<?php
require_once dirname(__DIR__) . '/config/config.php';
require 'partials/header.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Текущий тест
$test_id = (int)($_GET['test_id'] ?? 0);
if (!$test_id) { echo "Тест не найден"; exit; }

// Инициализация вопросов для теста
if (!isset($_SESSION['tests'][$test_id])) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE test_id=? ORDER BY id");
    $stmt->execute([$test_id]);
    $_SESSION['tests'][$test_id] = $stmt->fetchAll();
}
$questions = $_SESSION['tests'][$test_id];
$total = count($questions);

// Определяем текущий шаг
$step = (int)($_GET['step'] ?? 0);
$current = $questions[$step] ?? null;

// Обработка ответа
if ($_POST && $current) {
    $answer_id = $_POST['answer'] ?? null;
    $is_correct = 0;
    if ($answer_id) {
        $stmt = $pdo->prepare("SELECT is_correct FROM answers WHERE id=?");
        $stmt->execute([$answer_id]);
        $is_correct = $stmt->fetchColumn();
    }

    $stmt = $pdo->prepare("INSERT INTO results (user_id,question_id,answer_id,correct) VALUES (?,?,?,?)");
    $stmt->execute([$_SESSION['user']['id'],$current['id'],$answer_id,$is_correct]);

    $step++;
    if ($step >= $total) {
        header("Location: test_finish.php?test_id=$test_id");
        exit;
    } else {
        header("Location: test.php?test_id=$test_id&step=$step");
        exit;
    }
}

?>

    <div class="container mt-5">
        <h4>Тест: <?= htmlspecialchars($test_id) ?> — Вопрос <?= $step+1 ?> / <?= $total ?></h4>

        <!-- Нумерация вопросов -->
        <div class="mb-3 d-flex flex-wrap gap-1">
            <?php for ($i=0;$i<$total;$i++):
                $class = 'border p-2 rounded';
                if ($i < $step) $class .= ' bg-secondary text-white';
                elseif ($i == $step) $class .= ' bg-primary text-white';
                ?>
                <div class="<?= $class ?>"><?= $i+1 ?></div>
            <?php endfor; ?>
        </div>

        <?php if ($current):
            $stmt = $pdo->prepare("SELECT * FROM answers WHERE question_id=? ORDER BY RAND()");
            $stmt->execute([$current['id']]);
            $answers = $stmt->fetchAll();
            ?>
            <div class="question-card p-3 mb-3">
                <p><?= htmlspecialchars($current['text']) ?></p>
                <form method="post">
                    <?php foreach ($answers as $a): ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="answer" id="a<?=$a['id']?>" value="<?=$a['id']?>" required>
                            <label class="form-check-label" for="a<?=$a['id']?>">
                                <?= htmlspecialchars($a['text']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <button class="btn btn-main mt-3"><?= $step+1==$total?'Завершить':'Далее' ?></button>
                </form>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary">В главное меню</a>
    </div>

<?php require 'partials/footer.php'; ?>