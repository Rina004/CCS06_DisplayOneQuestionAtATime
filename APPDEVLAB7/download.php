<?php
require "vendor/autoload.php";
use App\QuestionManager;
session_start();

$manager = new QuestionManager;
$fileContent = "Complete Name: " . $_SESSION['complete_name'];
$fileContent = $fileContent . "\nEmail: " . $_SESSION['email'];
$fileContent = $fileContent . "\nBirthdate: " . $_SESSION['birthdate'];
$fileContent = $fileContent . "\nScore: " . $_SESSION['score'] . " out of 10";
$fileContent = $fileContent . "\nAnswers:";

for($number=1;$number<=10;$number++) {
    $fileContent = $fileContent . "\n" . $number . ". " . $_SESSION['answers'][$number] . " " . "(" . $manager->checkAnsSingle($_SESSION['answers'][$number], $number) . ")";
}

$fileName = "results.txt";

file_put_contents($fileName, $fileContent);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . filesize($fileName));
readfile($fileName);
unlink($fileName);
exit;
?>