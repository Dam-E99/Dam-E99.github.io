
function updateGreeting() {
    // Grab values from the form
    const firstName = document.getElementById("firstName").value;
    const middleName = document.getElementById("middleName").value;
    const lastName = document.getElementById("lastName").value;

    // Construct the middle name part with period only if present
    const formattedMiddle = middleName ? `${middleName}. ` : "";

    // Construct final greeting and replace content
    const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
    document.getElementById("greeting").textContent = greetingText;
}

const form = document.getElementById("form");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();
});
