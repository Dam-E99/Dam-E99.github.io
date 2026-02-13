function checkDivision(number, divisor) {
    return number % divisor === 0;
}

function updateGreeting() {
    // Grab Name Values From the Form
    const firstName = document.getElementById("first_name").value;
    const middleInitial = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    // Grab Number/Word Values From the Form
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


    // Check For Number Validation 
    if (isNaN(limit) || isNaN(firstDivisor) || isNaN(secondDivisor) || isNaN(thirdDivisor) ) {
        alert("Invalid Input, Please Ensure All Fields Contain a Valid Number.");
        return;
    }

    // Number Output Loop 
    const listLoop = document.getElementById("loop");
    let htmlList = "";
    

    // Updated logic to be more adaptable and modular
    for (let i = 1; i <= limit; i++ ) {
         let outputWord = "";
        if (checkDivision(i, firstDivisor)) {
            outputWord += word1;
        } 
        if (checkDivision(i, secondDivisor)) {
            outputWord += (outputWord ? ", " : "" ) + word2;
        } 
        if (checkDivision(i, thirdDivisor)){
            outputWord += (outputWord ? ", " : "" ) + word3;
        } 
        //If No Match Use defaultWord(blank)
        if (outputWord === "") {
            outputWord = defaultWord;
        }
        //If There is a Match use the Word
        if (outputWord !== "") {
            htmlList += `<li>${outputWord}</li>`;
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