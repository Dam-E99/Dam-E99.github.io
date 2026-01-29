
function updateGreeting() {
    // Grab values from the form
    const firstName = document.getElementById("first_name").value;
    const middleName = document.getElementById("middle_initial").value;
    const lastName = document.getElementById("last_name").value;

    // Construct the middle name part with period only if present
    const formattedMiddle = middle_initial ? `${middle_initial}. ` : "";

    // Construct final greeting and replace content
    const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
    document.getElementById("greeting").textContent = greetingText;
}

const form = document.getElementById("form");

form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    updateGreeting();
});
