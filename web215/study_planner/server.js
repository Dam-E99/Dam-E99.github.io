const express = require("express");
const path = require("path");
const mongoose = require("mongoose");
const session = require('express-session');
const Task = require("./models/Task");
const Subject = require("./models/Subject");

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

// Database Connection
mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB Connected"))
  .catch(err => console.log("Connection Error:", err));

// 1. Setup session middleware
app.use(session({
  secret: 'study-planner-secret', 
  resave: false,
  saveUninitialized: false,
  cookie: { maxAge: 600000 } // Session expires in 10 minutes
}));

// 2. Middleware to protect routes
const checkAuth = (req, res, next) => {
  if (req.session.isLoggedIn) {
    next(); 
  } else {
    res.redirect('/'); 
  }
};

// LOGIN PAGE (Public)
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "login.html"));
});

// LOGIN HANDLER (Public)
app.post("/login", (req, res) => {
  const { username, password } = req.body;

  if (username === "web215user" && password === "LetMeIn!") {
    req.session.isLoggedIn = true; // Save session
    res.redirect("/app");
  } else {
    res.send(`
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <title>Access Denied</title>
        <link rel="stylesheet" href="/styles.css">
      </head>
      <body>
        <header><h1>Access Denied</h1></header>
        <div class="container">
          <p>Incorrect username or password.</p>
          <a href="/">Try Again</a>
        </div>
      </body>
      </html>
    `);
  }
});

// LOGOUT ROUTE
app.get("/logout", (req, res) => {
  req.session.destroy();
  res.redirect("/");
});

// DASHBOARD (Protected)
app.get("/app", checkAuth, async (req, res) => {
  const tasks = await Task.find().populate("subjects");
  const allSubjects = await Subject.find();

  let html = `
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Study Planner Dashboard</title>
      <link rel="stylesheet" href="/styles.css">
  </head>
  <body>
  <header>
      <div style="float: right; margin-right: 20px;"><a href="/logout" style="color: white;">Logout</a></div>
      <h1>Study Planner Dashboard</h1>
  </header>
  <div class="container">
      <h2>Add New Task</h2>
      <form action="/create" method="POST" class="add-task-form">
        <input type="text" name="title" placeholder="Task Title" required>
        <input type="text" name="description" placeholder="Description" required>
        <p>Select Subjects:</p>
        <div class="subject-checkboxes">
  `;

  allSubjects.forEach(sub => {
    html += `<label><input type="checkbox" name="subjects" value="${sub._id}"> ${sub.name}</label>`;
  });

  html += `
      </div>
      <button type="submit">Add Task</button>
      </form>
      <h2>Current Tasks</h2>
      <div class="task-grid">
  `;

  tasks.forEach(task => {
    html += `
      <div class="task-card">
        <strong>${task.title}</strong><br><br>
        ${task.subjects.map(subject => `<span class="subject-tag">${subject.name}</span>`).join("")}
        <p>${task.description}</p>
        <a href="/edit/${task._id}">Edit</a>
        <form action="/delete/${task._id}" method="POST" style="display:inline;">
          <button type="submit" style="background-color: #ff4d4d; padding: 5px 10px;">Delete</button>
        </form>
      </div>
    `;
  });

  html += `</div></div></body></html>`;
  res.send(html);
});

// CREATE (Protected)
app.post("/create", checkAuth, async (req, res) => {
  const selectedSubjects = Array.isArray(req.body.subjects)
    ? req.body.subjects
    : req.body.subjects ? [req.body.subjects] : [];

  await Task.create({
    title: req.body.title,
    description: req.body.description,
    subjects: selectedSubjects,
    completed: false
  });
  res.redirect("/app");
});

// EDIT PAGE (Protected)
app.get("/edit/:id", checkAuth, async (req, res) => {
  const task = await Task.findById(req.params.id);
  const allSubjects = await Subject.find();

  let html = `
  <!DOCTYPE html>
  <html lang="en">
  <head><title>Edit Task</title><link rel="stylesheet" href="/styles.css"></head>
  <body>
  <header><h1>Edit Task</h1></header>
  <div class="container">
      <form action="/update/${task._id}" method="POST">
          <input type="text" name="title" value="${task.title}" required>
          <input type="text" name="description" value="${task.description}" required>
          <p>Update Subjects:</p>
  `;

  allSubjects.forEach(sub => {
    const isChecked = task.subjects.some(s => s.toString() === sub._id.toString()) ? "checked" : "";
    html += `<label><input type="checkbox" name="subjects" value="${sub._id}" ${isChecked}> ${sub.name}</label><br>`;
  });

  html += `<br><button type="submit">Update Task</button></form><br><a href="/app">Back to Dashboard</a></div></body></html>`;
  res.send(html);
});

// UPDATE (Protected)
app.post("/update/:id", checkAuth, async (req, res) => {
  const selectedSubjects = Array.isArray(req.body.subjects)
    ? req.body.subjects
    : req.body.subjects ? [req.body.subjects] : [];

  await Task.findByIdAndUpdate(req.params.id, {
    title: req.body.title,
    description: req.body.description,
    subjects: selectedSubjects
  });
  res.redirect("/app");
});

// DELETE (Protected)
app.post("/delete/:id", checkAuth, async (req, res) => {
  await Task.findByIdAndDelete(req.params.id);
  res.redirect("/app");
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
