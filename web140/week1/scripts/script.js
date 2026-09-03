
let score = 0;

function checkAnswer(isCorrect, messageId) {
    let message = document.getElementById(messageId);

    if (isCorrect === true) {
        message.textContent = "Correct!";
        message.style.color = "#007FD7"
    } else {
        message.textContent = "Incorrect. Try again!";
        message.style.color = "#EA1818"
    }

}

let submitBtn = document.getElementById("check_quiz");

submitBtn.addEventListener("click", function() {
    let scoreDisplay = document.getElementById("score");
    let correctBtn = document.getElementsByClassName("correctAns");
    let finalScore = 0
    for (let i = 0; i < correctBtn.length; i++) {
        if (correctBtn[i].checked === true) {
            finalScore += 1;
        }
    }

    scoreDisplay.textContent = "Your Score: " + finalScore + " out of 6";
});