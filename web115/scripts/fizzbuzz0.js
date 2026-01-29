
function updateGreeting() {
    // Grab values from the form
    const firstName = document.getElementById("first_name").value;
    const middleInitial = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    // Construct the middle name part with period only if present
    const formattedMiddle = middleInitial ? `${middleInitial}. ` : "";

    // Construct final greeting and replace content
    const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
    document.getElementById("greeting").textContent = greetingText;
}

const form = document.getElementById("form");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();
});

const listLoop = document.getElementById("loop");
let htmlList = "";

for (let i = 1; i <= 125; i++ ) {
    htmlList += `<li>${i}) Fresh Air</li>`;
}