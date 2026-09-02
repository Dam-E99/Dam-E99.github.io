
let score = 0;

function checkAnswer(isCorrect) {
    let message = document.getElementById("score");
    if (isCorrect === True) {
        message.textContent = "Correct!";
        score += 1;
    } else {
        message.textContent = "Incorrect. Try again!";
    }
}

let submitBtn = document.getElementById("check_quiz");

let submitBtn = addEventListener("click", function() {
    let scoreDisplay = document.getElementById("score");
    scoreDisplay.textContent = "Your Score: " + score + " out of 6";
});