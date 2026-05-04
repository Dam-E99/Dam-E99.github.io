const express = require("express");
const path = require("path");
const mongoose = require("mongoose");
const Task = require("./models/Task");
const Subject = require("./models/Subject");

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

// Connect using environment variable (No quotes!)
mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB Connected"))
  .catch(err => console.log("Connection Error:", err));


// LOGIN PAGE (Root)
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "login.html"));
});


// LOGIN HANDLER
app.post("/login", (req, res) => {
  const { username, password } = req.body;

  if (username === "web215user" && password === "LetMeIn!") {
    res.redirect("/app");
  } else {
    res.send(`
      <h1>Access Denied</h1>
      <p>Incorrect username or password.</p>
      <a href="/">Try Again</a> 
    `);
  }
});


// READ + DISPLAY + CREATE FORM
app.get("/app", async (req, res) => {
  // Populate allows the "Join" to show Subject names instead of IDs
  const tasks = await Task.find().populate("subjects");
  const allSubjects = await Subject.find();

  let html = `
    <h1>Study Planner Dashboard</h1>

    <h2>Add New Task</h2>
    <form action="/create" method="POST">
      <input type="text" name="title" placeholder="Task Title" required><br><br>
      <input type="text" name="description" placeholder="Description" required><br><br>
      
      <p>Select Subjects (Many-to-Many):</p>
      ${allSubjects.map(sub => `
        <input type="checkbox" name="subjects" value="${sub._id}"> ${sub.name}
      `).join('<br>')}
      
      <br><br>
      <button type="submit">Add Task</button>
    </form>

    <h2>Current Tasks</h2>
    <ul>
  `;

  tasks.forEach(task => {
    // Convert array of subject objects into a string of names
    const subjectNames = task.subjects.map(s => s.name).join(", ");

    html += `
      <li>
        <strong>${task.title}</strong><br>
        Subjects: <em>${subjectNames || "No subjects assigned"}</em><br>
        ${task.description}<br>

        <a href="/edit/${task._id}">Edit</a> | 
        <form action="/delete/${task._id}" method="POST" style="display:inline;">
          <button type="submit">Delete</button>
        </form>
      </li><br>
    `;
  });

  html += `</ul>`;
  res.send(html);
});


// CREATE
app.post("/create", async (req, res) => {
  await Task.create({
    title: req.body.title,
    description: req.body.description,
    subjects: req.body.subjects, // Array of IDs from checkboxes
    completed: false
  });

  res.redirect("/app");
});


// EDIT FORM
app.get("/edit/:id", async (req, res) => {
  const task = await Task.findById(req.params.id);
  const allSubjects = await Subject.find();

  let html = `
    <h1>Edit Task</h1>
    <form action="/update/${task._id}" method="POST">
      <input type="text" name="title" value="${task.title}" required><br><br>
      <input type="text" name="description" value="${task.description}" required><br><br>

      <p>Update Subjects:</p>
  `;

  allSubjects.forEach(sub => {
    // Check the box if the task already has this subject ID
    const isChecked = task.subjects.some(s => s.toString() === sub._id.toString()) ? "checked" : "";
    html += `<input type="checkbox" name="subjects" value="${sub._id}" ${isChecked}> ${sub.name}<br>`;
  });

  html += `
      <br><button type="submit">Update Task</button>
    </form>
    <br><a href="/app">Back</a>
  `;

  res.send(html);
});


// UPDATE
app.post("/update/:id", async (req, res) => {
  await Task.findByIdAndUpdate(req.params.id, {
    title: req.body.title,
    description: req.body.description,
    subjects: req.body.subjects // Updated ID array
  });

  res.redirect("/app");
});


// DELETE
app.post("/delete/:id", async (req, res) => {
  await Task.findByIdAndDelete(req.params.id);
  res.redirect("/app");
});


app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
