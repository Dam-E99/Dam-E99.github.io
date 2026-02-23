document.addEventListener("DOMContentLoaded", function() {
    const courseContainer = document.getElementById("courseContainer");
    const addBtn = document.getElementById("addCourseBtn");
    const form = document.querySelector("form"); 
    const outputArea = document.getElementById("output");

    // 1. Add New Course Inputs
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

    // 2. Remove Course Inputs
    courseContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-btn")) {
            e.target.parentElement.remove();
        }
    });

    // 3. Handles Form Submit
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

        // Mirrors the Introduction HTML Structure
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
