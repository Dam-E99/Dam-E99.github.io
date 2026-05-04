const express = require("express");
const path = require("path");
const mongoose = require("mongoose");
const Task = require("./models/Task");

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB Connected"))
  .catch(err => console.log(err));


// LOGIN PAGE
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
  const tasks = await Task.find();

  let html = `
    <h1>Study Planner Dashboard</h1>

    <h2>Add New Task</h2>
    <form action="/create" method="POST">
      <input type="text" name="title" placeholder="Task Title" required><br><br>
      <input type="text" name="description" placeholder="Description" required><br><br>
      <input type="text" name="subject" placeholder="Subject" required><br><br>
      <button type="submit">Add Task</button>
    </form>

    <h2>Current Tasks</h2>
    <ul>
  `;

  tasks.forEach(task => {
    html += `
      <li>
        <strong>${task.title}</strong><br>
        Subject: ${task.subject}<br>
        ${task.description}<br>

        <a href="/edit/${task._id}">Edit</a>

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
    subject: req.body.subject,
    completed: false
  });

  res.redirect("/app");
});


// EDIT FORM
app.get("/edit/:id", async (req, res) => {
  const task = await Task.findById(req.params.id);

  res.send(`
    <h1>Edit Task</h1>

    <form action="/update/${task._id}" method="POST">
      <input type="text" name="title" value="${task.title}" required><br><br>
      <input type="text" name="description" value="${task.description}" required><br><br>
      <input type="text" name="subject" value="${task.subject}" required><br><br>

      <button type="submit">Update Task</button>
    </form>

    <br>
    <a href="/app">Back</a>
  `);
});


// UPDATE
app.post("/update/:id", async (req, res) => {
  await Task.findByIdAndUpdate(req.params.id, {
    title: req.body.title,
    description: req.body.description,
    subject: req.body.subject
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