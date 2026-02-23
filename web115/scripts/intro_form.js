document.addEventListener("DOMContentLoaded", function() {
    const courseContainer = document.getElementById("courseContainer");
    const addBtn = document.getElementById("addCourseBtn");
    // FIX 1: Use the form element directly or add id="introForm" to HTML
    const form = document.querySelector("form"); 
    const outputArea = document.getElementById("output"); // Matches your id="output"

    // Add New Course Inputs
    addBtn.addEventListener("click", () => {
        const index = courseContainer.querySelectorAll(".course-entry").length + 1;
        const div = document.createElement("div");
        div.className = "course-entry";
        div.innerHTML = `
            <label>Course ${index}:</label>
            <input type="text" class="course-input" placeholder="Course: Reason" required>
            <button type="button" class="remove-btn">X</button>
        `;
        courseContainer.appendChild(div);
    });

    // Remove Course Inputs
    courseContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-btn")) {
            e.target.parentElement.remove();
            // Optional: Re-index labels here if you want them to stay 1, 2, 3
        }
    });

    // Handle Form Submit
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const fName = document.getElementById("first_name").value;
        const mInit = document.getElementById("middle_initial").value;
        const lName = document.getElementById("last_name").value;
        const fullName = `${fName} ${mInit ? mInit + ". " : ""}${lName}`;

        const personal = document.getElementById("personal").value;
        const professional = document.getElementById("professional").value;
        const academic = document.getElementById("academic").value;
        const computer = document.getElementById("computer").value;

        // FIX 2: Build Course List by splitting the single input string at the colon
        const courseInputs = document.querySelectorAll(".course-input");
        let coursesHtml = "<ol>";
        courseInputs.forEach((input) => {
            const parts = input.value.split(':');
            if (parts.length > 1) {
                // Bolds the part before the colon
                coursesHtml += `<li><strong>${parts[0].trim()}:</strong> ${parts.slice(1).join(':').trim()}</li>`;
            } else {
                coursesHtml += `<li>${input.value}</li>`;
            }
        });
        coursesHtml += "</ol>";

        // Mirror the Introduction HTML Structure
        outputArea.innerHTML = `
            <h3 style="text-align:center;">${fullName}</h3>
            <p style="text-align:center; font-style:italic;">~ Dazzling Dodo ~</p>
            <ul style="list-style-type: disc; margin-top: 20px;">
                <li><strong>Personal Background:</strong> ${personal}</li>
                <li><strong>Professional Background:</strong> ${professional}</li>
                <li><strong>Academic Background:</strong> ${academic}</li>
                <li><strong>Primary Computer:</strong> ${computer}</li>
                <li><strong>Courses I’m Taking, & Why:</strong> ${coursesHtml}</li>
            </ul>
        `;
    });
});
