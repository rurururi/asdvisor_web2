<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yes or No Questions</title>
</head>
<body>
<h2>Answer the following questions:</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<?php

// Array of questions
$questions = array(
    "Is the sky blue?",
    "Is the sun shining?",
    "Is it raining?",
    "Do you like pizza?",
    "Do you have a pet?",
);

// Array of 25 possible answers with corresponding possible outcomes
$answers = array(
    "Yes,Yes,Yes,Yes,Yes" => "You can sleep",
    "Yes,No,Yes,Yes,Yes" => "You can eat",
    "Yes,Yes,No,Yes,Yes" => "You can drink water",
    "Yes,Yes,Yes,No,Yes" => "You can go for a walk",
    "Yes,Yes,Yes,Yes,No" => "You can watch TV",
    "Yes,Yes,Yes,No,No" => "You can read a book",
    "Yes,Yes,No,Yes,No" => "You can listen to music",
    "Yes,No,Yes,Yes,No" => "You can play a game",
    "No,Yes,Yes,Yes,Yes" => "You should exercise",
    "Yes,No,Yes,No,Yes" => "You can take a shower",
    "No,Yes,Yes,Yes,No" => "You should go outside",
    "Yes,No,Yes,Yes,Yes" => "You can cook",
    "Yes,Yes,No,No,Yes" => "You can meditate",
    "Yes,Yes,No,Yes,No" => "You can call a friend",
    "Yes,No,Yes,No,No" => "You can take a nap",
    "No,Yes,No,Yes,Yes" => "You should drink coffee",
    "Yes,Yes,Yes,No,No" => "You can do some gardening",
    "No,Yes,Yes,No,Yes" => "You should do some cleaning",
    "No,No,Yes,Yes,Yes" => "You should do laundry",
    "Yes,No,No,Yes,Yes" => "You can go for a drive",
    "No,Yes,Yes,Yes,No" => "You should do some cooking",
    "No,Yes,No,Yes,No" => "You should do some shopping",
    "No,No,Yes,Yes,No" => "You should take a break",
    "No,Yes,Yes,No,No" => "You should do some studying",
    "No,No,Yes,No,Yes" => "You should take a vacation"
);

// Function to generate a random question and options
function askQuestion($questionIndex, $question) {
    echo "<p>$question<br>";
    echo "<label><input type='radio' name='answer$questionIndex' value='Yes'>Yes</label> ";
    echo "<label><input type='radio' name='answer$questionIndex' value='No'>No</label>";
    echo "</p>";
}

// Ask the questions
foreach ($questions as $index => $question) {
    askQuestion($index + 1, $question);
}

?>
<input type="submit" value="Submit">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedAnswers = "";
    foreach ($questions as $index => $question) {
        $selectedAnswers .= $_POST["answer" . ($index + 1)];
        if($index < 4) {
            $selectedAnswers .= ',';
        }
    }
    $outcome = $answers[$selectedAnswers];
    echo "<h2>Result:</h2>";
    echo "<p>$outcome</p>";
}

?>
</body>
</html>