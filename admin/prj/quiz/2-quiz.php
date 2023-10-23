<?php
  $user = 25 ;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple PHP Quiz</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="2-quiz.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="4-quiz.js"></script>
  </head>
  <body>
    <div id="account" style="display: none;">
    <?php
    echo $user
    ?></div>
    <div id="quizWrap">
      <div id="quizQn"></div>
      <div id="quizAns"></div>
    </div>
  </body>
</html>