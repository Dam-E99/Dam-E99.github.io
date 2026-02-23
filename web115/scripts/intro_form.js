document.addEventListener("DOMContentLoaded", function() {
    const courseContainer = document.getElementById("courseContainer");
    const addBtn = document.getElementById("addCourseBtn");
    const form = document.getElementById("introForm");
    const outputArea = document.getElementById("outputArea");

// Add New Course Inputs
    addBtn.addEventListener("click", () => {
        const div = document.createElement("div");
        div.className = "course-entry";
        div.innerHTML = `
            <input type="text" class="course-name" placeholder="Course Name" required>
            <input type="text" class="course-desc" placeholder="Why?" required>
            <button type="button" class="remove-btn">X</button>
        `;
        courseContainer.appendChild(div);
    });

// Remove Course Inputs
    courseContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-btn")) {
            e.target.parentElement.remove();
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

    // Build Course List
        const courseNames = document.querySelectorAll(".course-name");
        const courseDescs = document.querySelectorAll(".course-desc");
        let coursesHtml = "<ol>";
        courseNames.forEach((input, i) => {
            coursesHtml += `<li><strong>${input.value}:</strong> ${courseDescs[i].value}</li>`;
        });
        coursesHtml += "</ol>";

    // Mirror the Introduction HTML Structure
        outputArea.innerHTML = `
            <h3>Generated Introduction</h3>
            <p style="text-align:center; font-style:italic;">"${fullName} ~ Dazzling Dodo"</p>
            <ul>
                <li><strong>Personal Background:</strong> ${personal}</li>
                <li><strong>Professional Background:</strong> ${professional}</li>
                <li><strong>Academic Background:</strong> ${academic}</li>
                <li><strong>Primary Computer:</strong> ${computer}</li>
                <li><strong>Courses I’m Taking, & Why:</strong> ${coursesHtml}</li>
            </ul>
        `;
    });
});
