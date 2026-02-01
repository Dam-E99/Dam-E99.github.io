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

    let firstDivInput = parseInt(prompt("Enter your first divisor: "));
    if (firstDivInput.trim() === "" || isNaN(firstDivInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }
    const divide1 = parseInt(firstDivInput);

    let secondDivInput = parseInt(prompt("Enter your second divisor: "));
    if (secondDivInput.trim() === "" || isNaN(secondDivInput)) {
        alert("Invalid Input, Please Enter a Number.");
        return;
    }
    const divide2 = parseInt(secondDivInput);

    // Make Flexible For Changing Number and Words

    const word1 = "Whoosh!";
    const word2 = "Air Flow!";
    const defaultWord = "Cozy Breeze!";

    // Loop with Else if to divide 3 or 5 or Both, else print default
    for (let i = 1; i <= limit; i++ ) {
         let outputWord = "";
        if (i % divide1 === 0 && i % divide2 === 0) {
            outputWord = `${word1} ${word2}`;
        } else if (i % divide1 === 0) {
            outputWord = word1;
        } else if (i % divide2 === 0) {
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