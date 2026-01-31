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

    for (let i = 1; i <= 140; i++ ) {
         let specialWord = "";
        if (i % 3 === 0 && i % 5 === 0) {
            specialWord = " Whoosh! Air Flow!";
        } else if (i % 3 === 0) {
            specialWord = "Whoosh!";
        } else if (i % 5 === 0) {
            specialWord = "Air Flow!";
        } else {
            specialWord = "Cozy Breeze!";
        }
         htmlList += `<li>${specialWord} </li>`;
    }

    listLoop.innerHTML = htmlList;

}

    // Submit Button Does Not Refresh Page
const form = document.getElementById("formOne");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();   
});