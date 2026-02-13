function checkDivision(number, divisor) {
    return number % divisor === 0;
}

function updateGreeting() {
    // Grab Values From the Form
    const firstName = document.getElementById("first_name").value;
    const middleInitial = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    const limit = parseInt(document.getElementById("limit").value);

    const firstDivisor = parseInt(document.getElementById("divisor_one").value);
    const word1 = document.getElementById("word_one").value;


    const secondDivisor = parseInt(document.getElementById("divisor_two").value);
    const word2 = document.getElementById("word_two").value;

    const thirdDivisor = parseInt(document.getElementById("divisor_three").value);
    const word3 = document.getElementById("word_three").value;

    const defaultWord = document.getElementById("default_word").value;

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

    // Third Division Number Input
    let thirdDivInput = prompt("Enter your third divisor: ");
    if (thirdDivInput.trim() === "" || isNaN(thirdDivInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }

    

    // Updated logic to be more adaptable and modular
    for (let i = 1; i <= limit; i++ ) {
         let outputWord = "";
        if (checkDivision(i % firstDivisor === 0)) {
            outputWord += word1;
        } 
        if (checkDivision(i % secondDivisor === 0)) {
            outputWord += (outputWord ? ", " : "" ) + word2;
        } 
        if (checkDivision(i % thirdDivisor === 0)){
            outputWord += (outputWord ? ", " : "" ) + word3;
        } 
        if (outputWord === "") {
            outputWord = defaultWord;
        }
        if (outputWord != "") {
            outputWord += htmlList += `<li>${outputWord}</li>`;
        }

    }

    listLoop.innerHTML = htmlList;

}

    // Submit Button Does Not Refresh Page
const form = document.getElementById("formOne");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();   
});