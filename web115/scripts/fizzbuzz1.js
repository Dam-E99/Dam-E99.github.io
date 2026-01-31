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

    const div1 = 3;
    const div2 = 5;

    for (let i = 1; i <= 140; i++ ) {
         let specialWord = "";
        if (i % div1 === 0 && i % div2 === 0) {
            specialWord = " Whoosh! Air Flow!";
        } else if (i % div1 === 0) {
            specialWord = "Whoosh!";
        } else if (i % div2 === 0) {
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