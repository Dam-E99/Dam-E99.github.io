
function updateGreeting() {
    // Grab Values From the Form
    const firstName = document.getElementById("first_name").value;
    const middleInitial = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    // Construct the Middle Name Part with Period Only if Present
    const formattedMiddle = middleInitial ? `${middleInitial}. ` : "";

    // Construct Final Greeting and Replace Content
    const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
    document.getElementById("greeting").textContent = greetingText;

    //Prompt User for a Number
    let limit = prompt(`How high do you want to count ${firstName}?`);
    limit = parseInt(limit);

    if (limit.trim() === "" || isNaN(limit)) {
        alert("Invalid Input, Please Enter a Number ");
        return;
    }

    // Add User Loop 
    const listLoop = document.getElementById("loop");
    let htmlList = "";

    for (let i = 1; i <= limit; i++ ) {
        let numbertype = (i % 2 === 0 ) ? 'even' : 'odd';
        htmlList += `<li>${i} Fresh Air - the number is ${numbertype}</li>`; //Increments Odd or Even Into Message
    }

    listLoop.innerHTML = htmlList;
}

// Submit Button Does Not Refresh Page
const form = document.getElementById("form");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();   
}


);



