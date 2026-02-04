function checkDivision(number, divisor) {
    return number % divisor === 0;
}

function updateGreeting() {
    // Grab Values From the Form
    const firstName = document.getElementById("first_name").value;
    const middleInitial = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    // Construct the Middle Name Part with Period Only if Present
    let formattedMiddle = "";
    if (middleInitial) {
        formattedMiddle = middleInitial.charAt(0).toUpperCase() + ". ";
    }

    // Construct Final Greeting and Replace Content
    const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
    document.getElementById("greeting").textContent = greetingText;

    // Number Output Loop 
    const listLoop = document.getElementById("loop");
    let htmlList = "";

    //Prompt User for a Number
    let userInput = prompt(`How high do you want to count ${firstName}?`);
    // Check For Validation 
    if (userInput.trim() === "" || isNaN(userInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }

    let limit = parseInt(userInput);

    // First Division Number Input
    let firstDivInput = prompt("Enter your first divisor: ");
    if (firstDivInput.trim() === "" || isNaN(firstDivInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }

    // Second Division Number Input
    let secondDivInput = prompt("Enter your second divisor: ");
    if (secondDivInput.trim() === "" || isNaN(secondDivInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }

    // New Variables for Divisors
    const firstDivisor = parseInt(secondDivInput);
    const secondDivisor = parseInt(firstDivInput);

    // Make Flexible For Changing Number and Words

    const word1 = "Whoosh!";
    const word2 = "Air Flow!";
    const defaultWord = "Cozy Breeze!";

    // Updated logic to be more adaptable and modular
    for (let i = 1; i <= limit; i++ ) {
         let outputWord = "";
        if (checkDivision(i, firstDivisor) && checkDivision(i, secondDivisor)) {
            outputWord = `${word1} ${word2}`;
        } else if (checkDivision(i, firstDivisor)) {
            outputWord = word1;
        } else if (checkDivision(i, secondDivisorDivisor)){
            outputWord = word2;
        } else {
            outputWord = defaultWord;
        }
         htmlList += `<li>${outputWord} </li>`;
    }

    listLoop.innerHTML = htmlList;

}

    // Submit Button Does Not Refresh Page
const form = document.getElementById("formOne");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();   
});