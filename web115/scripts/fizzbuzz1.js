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

    const startNumber = 1;
    const endNumber = 140;

    const divide1 = 3;
    const word1 = "Whoosh!";

    const divide2 = 5;
    const word2 = "Air Flow!";

    const defaultWord = "Cozy Breeze!";

    for (let i = startNumber; i <= endNumber; i++ ) {
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