<?php

require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$score = null;
try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }

    $questionSize = $manager->getQuestionSize();
    if (count($_SESSION['answers']) !== $questionSize) {
        throw new Exception('All questions are not answered');
    }

    $score = $manager->computeScore($_SESSION['answers']);
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}
$_SESSION['score'] = $score;

function identify_if_correct($ans, $ind) {
    global $manager;
    $answer = $manager->checkAnsSingle($ans, $ind);
    if ($answer == "correct") {
        echo "(<span style=\"color: blue\">correct</span>)";
    } else {
        echo "(<span style=\"color: red\">incorrect</span>)";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz</title>
</head>
<body>

<h1>Thank You</h1>

<h3>
    Congratulations<br />
    Complete Name: <?php echo $_SESSION['complete_name']; ?><br /> 
    Email: <?php echo $_SESSION['email']; ?> <br />
    Birthdate: <?php echo $_SESSION['birthdate'] ?> <br \>
    Score: <span style="color: blue"><?php echo $score; ?></span> out of <?php echo $manager->getQuestionSize() ;?> items <br />
    Your Answers:
</h3>

<h3>
    <ol>
    <?php for($number=1;$number<=10;$number++): ?>
        <li><?php echo $_SESSION['answers'][$number]; ?> <?php $manager->checkAnsSingle($_SESSION['answers'][$number], $number); ?></li>    
    <?php endfor; ?>
    <a href="download.php">Click here to download the results.</a>
    </ol>
</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
var_dump($_SESSION);
?>
</pre>