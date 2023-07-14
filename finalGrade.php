<!DOCTYPE html>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>IT 207 Final Grade Determiner</title>

        <link rel="stylesheet" href="styles.css" />
    </head>

    <body>
        <div class="flex">
            <div class="outer width30 brandColor">
                <?php require 'menuDivision.inc'; ?>
            </div>
            <div class="outer width70">
                <div class="inner width100 height20 brandColor">
                    <?php require 'headerDivision.inc'; ?>
                </div>
                <div class="inner flex width100 height70">
                    <div class="width100 flex height100">
                        <div class = "brandColor inner">
	<?php
       $sum = 0;

       define("HUNDRED", 100); //defining a constant

       //function to calculate percentage
       function calculatePercentage($earned, $max)
       {
           $percent = ($earned / $max) * HUNDRED;
           return $percent;
       }
       //function to calculate weighted percentage
       function weightedPercentage($percent, $weight)
       {
           $weightedPercent = ($percent * $weight) / HUNDRED;
           return $weightedPercent;
       }
       //check if the post variable has value otherwise set null
       $earnedParticipation = isset($_POST['earnedParticipation']) ? $_POST['earnedParticipation'] : 0;
       $maxParticipation = isset($_POST['maxParticipation']) ? $_POST['maxParticipation'] : 0;
       $weightParticipation = isset($_POST['weightParticipation']) ? $_POST['weightParticipation'] : 0;

       //call functions to calculate values of participation
       $percent = calculatePercentage($earnedParticipation, $_POST['maxParticipation']);
       $weightedPercent = weightedPercentage($percent, $_POST['weightParticipation']);
       echo "You earned a " . $percent . "% for participation, with a weighted value of " . $weightedPercent . "%<br>";
       $weightedPercentParticipation = $weightedPercent;
       $sum += $weightedPercent; //use compound operator to add sum

       //check if the post variable has value otherwise set null
       $maxQuiz = isset($_POST['maxQuiz']) ? $_POST['maxQuiz'] : 0;
       $earnedQuiz = isset($_POST['earnedQuiz']) ? $_POST['earnedQuiz'] : 0;
       $weightQuiz = isset($_POST['weightQuiz']) ? $_POST['weightQuiz'] : 0;

       //call functions to calculate values of participation
	   $percent = calculatePercentage($earnedQuiz, $_POST['maxQuiz']);
       $weightedPercent = weightedPercentage($percent, $_POST['weightQuiz']);
       echo "You earned a " . $percent . "% for the Quizzes, with a weighted value of " . $weightedPercent . "%<br>";
       $sum += $weightedPercent; //use compound operator to add sum

       //check if the post variable has value otherwise set null
       $earnedLab = isset($_POST['earnedLab']) ? $_POST['earnedLab'] : 0;
       $maxLab = isset($_POST['maxLab']) ? $_POST['maxLab'] : 0;
       $weightLab = isset($_POST['weightLab']) ? $_POST['weightLab'] : 0;

       //call functions to calculate values of participation
       $percent = calculatePercentage($_POST['earnedLab'], $_POST['maxLab']);
       $weightedPercent = weightedPercentage($percent, $_POST['weightLab']);
       echo "You earned a " . $percent . "% for the Lab assignments, with a weighted value of " . $weightedPercent . "%<br>";
       $sum += $weightedPercent; //use compound operator to add sum

       //check if the post variable has value otherwise set null
       $earnedPracticum = isset($_POST['earnedPracticum']) ? $_POST['earnedPracticum'] : 0;
       $maxPracticum = isset($_POST['maxPracticum']) ? $_POST['maxPracticum'] : 0;
       $weightPracticum = isset($_POST['weightPracticum']) ? $_POST['weightPracticum'] : 0;

       //call functions to calculate values of participation
       $percent = calculatePercentage($_POST['earnedPracticum'], $_POST['maxPracticum']);
       $weightedPercent = weightedPercentage($percent, $_POST['weightPracticum']);
       echo "You earned a " . $percent . "% for the Practica, with a weighted value of " . $weightedPercent . "%<br>";
       $sum += $weightedPercent; //use compound operator to add sum

       if ($sum < "60") {
           $grade = "F";
       } elseif ($sum >= "60" && $sum < "70") {
           $grade = "D";
       } elseif ($sum >= "70" && $sum < "75") {
           $grade = "C";
       } elseif ($sum >= "75" && $sum < "80") {
           $grade = "C+";
       } elseif ($sum >= "80" && $sum < "85") {
           $grade = "B";
       } elseif ($sum >= "85" && $sum < "90") {
           $grade = "B+";
       } elseif ($sum >= "90" && $sum < "95") {
           $grade = "A";
       } else {
           $grade = "A+";
       }

       echo "<b>Your final grade is " . $sum . " which is " . $grade . "</b><br><br>";
    ?>
</div>
                    </div>
                </div>
                <div><?php require 'copyrightDivision.inc'; ?></div>
            </div>
        </div>
    </body>
</html>							


