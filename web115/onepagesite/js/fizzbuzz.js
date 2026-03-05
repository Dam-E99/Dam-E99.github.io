function checkDivision(number, divisor) {
    return number % divisor === 0;
}

document.addEventListener('DOMContentLoaded', () => {
    // --- FizzBuzz 0 Logic ---
    const form0 = document.getElementById("formZero0");

    if (form0) {
        form0.addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            // Grab Values From the Form using the IDs in your HTML
            const firstName = document.getElementById("first_name0").value;
            const middleInitial = document.getElementById("middle_initial0").value;
            const lastName = document.getElementById("last_name0").value;

            // Construct the Middle Name Part
            let formattedMiddle = "";
            if (middleInitial) {
                formattedMiddle = middleInitial.charAt(0).toUpperCase() + ". ";
            }

            // Update Greeting
            const greetingText = `Welcome to Refresh Air HVAC, ${firstName} ${formattedMiddle}${lastName}!`;
            document.getElementById("greeting0").textContent = greetingText;

            // Prompt User for a Number
            let userInput = prompt(`How high do you want to count, ${firstName}?`);
            
            // Validation 
            if (userInput === null || userInput.trim() === "" || isNaN(userInput)) {
                alert("Invalid Input, Please Enter a Number.");
                return;
            }

            let limit = parseInt(userInput);
            const listLoop = document.getElementById("loop0");
            let htmlList = "";

            // The Loop
            for (let i = 1; i <= limit; i++) {
                let numberType = (i % 2 === 0) ? 'even' : 'odd';
                htmlList += `<li>${i}. Fresh Air - the number is ${numberType}</li>`;
            }

            listLoop.innerHTML = htmlList;
        });
    }

        // --- FizzBuzz 1 Logic ---
    const form1 = document.getElementById("formOne1");

    if (form1) {
        form1.addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            // Grab Values From the Form 1 IDs
            const firstName = document.getElementById("first_name1").value;
            const middleInitial = document.getElementById("middle_initial1").value;
            const lastName = document.getElementById("last_name1").value;

            let formattedMiddle = "";
            if (middleInitial) {
                formattedMiddle = middleInitial.charAt(0).toUpperCase() + ". ";
            }

            // Update Greeting 1
            const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
            document.getElementById("greeting1").textContent = greetingText;

            // Prompt for Limit
            let userInput = prompt(`How high do you want to count, ${firstName}?`);
            if (userInput === null || userInput.trim() === "" || isNaN(userInput)) {
                alert("Invalid Input, Please Enter a Number.");
                return;
            }
            let limit = parseInt(userInput);

            // Prompt for First Divisor
            let firstDivInput = prompt("Enter your first divisor:");
            if (firstDivInput === null || firstDivInput.trim() === "" || isNaN(firstDivInput)) {
                alert("Invalid Input, Please Enter a Number.");
                return;
            }
            const divide1 = parseInt(firstDivInput);

            // Prompt for Second Divisor
            let secondDivInput = prompt("Enter your second divisor:");
            if (secondDivInput === null || secondDivInput.trim() === "" || isNaN(secondDivInput)) {
                alert("Invalid Input, Please Enter a Number.");
                return;
            }
            const divide2 = parseInt(secondDivInput);

            // Branding Words
            const word1 = "Whoosh!";
            const word2 = "Air Flow!";
            const defaultWord = "Cozy Breeze!";

            const listLoop = document.getElementById("loop1");
            let htmlList = "";

            // Loop Logic
            for (let i = 1; i <= limit; i++) {
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
                htmlList += `<li>${i}. ${outputWord}</li>`;
            }

            listLoop.innerHTML = htmlList;
        });
    }

    // --- FizzBuzz 2 Logic ---
    const form2 = document.getElementById("formTwo2");

    if (form2) {
        form2.addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            // Grab Values From the Form 2 IDs
            const firstName = document.getElementById("first_name2").value;
            const middleInitial = document.getElementById("middle_initial2").value;
            const lastName = document.getElementById("last_name2").value;

            let formattedMiddle = "";
            if (middleInitial) {
                formattedMiddle = middleInitial.charAt(0).toUpperCase() + ". ";
            }

            // Update Greeting 2
            const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
            document.getElementById("greeting2").textContent = greetingText;

            // Prompt for Limit
            let userInput = prompt(`How high do you want to count, ${firstName}?`);
            if (userInput === null || userInput.trim() === "" || isNaN(userInput)) {
                alert("Invalid Input.");
                return;
            }
            let limit = parseInt(userInput);

            // Prompt for Divisors
            let firstDivInput = prompt("Enter your first divisor:");
            let secondDivInput = prompt("Enter your second divisor:");
            
            if (!firstDivInput || !secondDivInput || isNaN(firstDivInput) || isNaN(secondDivInput)) {
                alert("Invalid Input. Please enter numbers for divisors.");
                return;
            }

            const firstDivisor = parseInt(firstDivInput);
            const secondDivisor = parseInt(secondDivInput);

            // Branding Words
            const word1 = "Whoosh!";
            const word2 = "Air Flow!";
            const defaultWord = "Cozy Breeze!";

            const listLoop = document.getElementById("loop2");
            let htmlList = "";

            // Loop using the checkDivision helper function
            for (let i = 1; i <= limit; i++) {
                let outputWord = "";
                if (checkDivision(i, firstDivisor) && checkDivision(i, secondDivisor)) {
                    outputWord = `${word1} ${word2}`;
                } else if (checkDivision(i, firstDivisor)) {
                    outputWord = word1;
                } else if (checkDivision(i, secondDivisor)){
                    outputWord = word2;
                } else {
                    outputWord = defaultWord;
                }
                htmlList += `<li>${i}. ${outputWord}</li>`;
            }

            listLoop.innerHTML = htmlList;
        });
    }

    const form3 = document.getElementById("formThree3");

    if (form3) {
        form3.addEventListener("submit", function(event) {
            event.preventDefault(); 
            
            // Grab Values From the Form 3 IDs
            const firstName = document.getElementById("first_name3").value;
            const middleInitial = document.getElementById("middle_initial3").value;
            const lastName = document.getElementById("last_name3").value;

            let formattedMiddle = "";
            if (middleInitial) {
                formattedMiddle = middleInitial.charAt(0).toUpperCase() + ". ";
            }

            // Update Greeting 3
            const greetingText = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;
            const greetingElem = document.getElementById("greeting3");
            if (greetingElem) greetingElem.textContent = greetingText;

            // Prompt for Limit
            let userInput = prompt(`How high do you want to count, ${firstName}?`);
            if (!userInput || isNaN(userInput)) {
                alert("Invalid Input.");
                return;
            }
            let limit = parseInt(userInput);

            // Prompt for Three Divisors
            let firstDivInput = prompt("Enter your first divisor:");
            let secondDivInput = prompt("Enter your second divisor:");
            let thirdDivInput = prompt("Enter your third divisor:");
            
            if (isNaN(firstDivInput) || isNaN(secondDivInput) || isNaN(thirdDivInput)) {
                alert("Invalid Input. Please enter numbers.");
                return;
            }

            const firstDivisor = parseInt(firstDivInput);
            const secondDivisor = parseInt(secondDivInput);
            const thirdDivisor = parseInt(thirdDivInput);

            // Branding Words
            const word1 = "Whoosh!";
            const word2 = "Air Flow!";
            const word3 = "BANG!";
            const defaultWord = "Cozy Breeze!";

            const listLoop = document.getElementById("loop3");
            let htmlList = "";

            // Updated Concatenation Logic
            for (let i = 1; i <= limit; i++) {
                let outputWord = "";
                
                if (checkDivision(i, firstDivisor)) {
                    outputWord += word1 + " ";
                } 
                if (checkDivision(i, secondDivisor)) {
                    outputWord += word2 + " ";
                } 
                if (checkDivision(i, thirdDivisor)){
                    outputWord += word3 + " ";
                } 
                if (outputWord === "") {
                    outputWord = defaultWord;
                }

                htmlList += `<li>${i}. ${outputWord.trim()}</li>`;
            }

            listLoop.innerHTML = htmlList;
        });
    }

        // --- FizzBuzz 4 Logic ---
    const form4 = document.getElementById("formFour4");

    if (form4) {
        form4.addEventListener("submit", function(event) {
            event.preventDefault(); 

            // Grab Name Values
            const firstName = document.getElementById("first_name4").value;
            const middleInitial = document.getElementById("middle_initial4").value;
            const lastName = document.getElementById("last_name4").value;

            // Grab Settings Values
            const limit = parseInt(document.getElementById("limit4").value);
            const firstDivisor = parseInt(document.getElementById("divisor_one4").value);
            const word1 = document.getElementById("word_one4").value;
            const secondDivisor = parseInt(document.getElementById("divisor_two4").value);
            const word2 = document.getElementById("word_two4").value;
            const thirdDivisor = parseInt(document.getElementById("divisor_three4").value);
            const word3 = document.getElementById("word_three4").value;
            const defaultWord = document.getElementById("default_word4").value;

            // Update Greeting
            let formattedMiddle = middleInitial ? middleInitial.charAt(0).toUpperCase() + ". " : "";
            document.getElementById("greeting4").textContent = `Welcome to Refresh Air HVAC ${firstName} ${formattedMiddle}${lastName}!`;

            // Validation 
            if (isNaN(limit) || isNaN(firstDivisor) || isNaN(secondDivisor) || isNaN(thirdDivisor)) {
                alert("Please ensure all numeric fields are filled.");
                return;
            }

            const listLoop = document.getElementById("loop4");
            let htmlList = "";

            for (let i = 1; i <= limit; i++) {
                let outputWord = "";
                if (checkDivision(i, firstDivisor)) outputWord += word1;
                if (checkDivision(i, secondDivisor)) outputWord += (outputWord ? ", " : "") + word2;
                if (checkDivision(i, thirdDivisor)) outputWord += (outputWord ? ", " : "") + word3;
                
                if (outputWord === "") outputWord = defaultWord;
                
                htmlList += `<li>${i}. ${outputWord}</li>`;
            }

            listLoop.innerHTML = htmlList;
        });
    }

        // --- Intro Form Logic ---
    const introForm = document.getElementById("introduction_form_actual");
    const courseContainer = document.getElementById("courseContainer");
    const addBtn = document.getElementById("addCourseBtn");
    const outputArea = document.getElementById("intro_output");

    if (addBtn) {
        addBtn.addEventListener("click", () => {
            const div = document.createElement("div");
            div.className = "course-entry";
            div.style.marginBottom = "10px";
            div.style.display = "flex";
            div.innerHTML = `
                <input type="text" class="course-input" placeholder="Course: Reason" required style="flex-grow: 1; margin-right: 10px;">
                <button type="button" class="remove-btn button primary small">X</button>
            `;
            courseContainer.appendChild(div);
        });
    }

    if (courseContainer) {
        courseContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("remove-btn")) {
                e.target.parentElement.remove();
            }
        });
    }

    if (introForm) {
        introForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const fName = document.getElementById("intro_first_name").value;
            const mInit = document.getElementById("intro_middle_initial").value;
            const lName = document.getElementById("intro_last_name").value;
            const fullName = `${fName} ${mInit ? mInit + ". " : ""}${lName}`;

            const personal = document.getElementById("intro_personal").value;
            const professional = document.getElementById("intro_professional").value;
            const academic = document.getElementById("intro_academic").value;
            const computer = document.getElementById("intro_computer").value;

            const courseInputs = document.querySelectorAll(".course-input");
            let coursesHtml = "<ol>";
            courseInputs.forEach((input) => {
                const parts = input.value.split(':');
                if (parts.length > 1) {
                    coursesHtml += `<li><strong>${parts[0].trim()}:</strong> ${parts.slice(1).join(':').trim()}</li>`;
                } else {
                    coursesHtml += `<li>${input.value}</li>`;
                }
            });
            coursesHtml += "</ol>";

            outputArea.innerHTML = `
                <header class="major">
                    <h3>Generated Introduction</h3>
                    <p>${fullName}</p>
                </header>
                <ul>
                    <li><strong>Personal Background:</strong> ${personal}</li>
                    <li><strong>Professional Background:</strong> ${professional}</li>
                    <li><strong>Academic Background:</strong> ${academic}</li>
                    <li><strong>Primary Computer:</strong> ${computer}</li>
                    <li><strong>Courses I’m Taking & Why:</strong> ${coursesHtml}</li>
                </ul>
            `;
            
            // Optional: Scroll to output
            outputArea.scrollIntoView({ behavior: 'smooth' });
        });
    }



});
