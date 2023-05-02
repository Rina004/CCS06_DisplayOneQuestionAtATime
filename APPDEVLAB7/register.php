<?php

require "vendor/autoload.php";

session_start();
// 2. Why do you think the session variable assignments are wrapped inside an if-else and try-catch statements?
// The try-catch statement is used for error handling in case there are specific situations where an error is possible, 
// while the if-else statement is used in order to validate the information that the user has entered, whether the user has
// inserted the complete required information or not, if so, then program will redirect to the quiz.php file

try {
    if (isset($_POST['complete_name'])) {
        $_SESSION['complete_name'] = $_POST['complete_name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['birthdate'] = $_POST['birthdate'];

        header('Location: quiz.php');
        exit;
    } else {
        throw new Exception('Missing the basic information.');
    }
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
}