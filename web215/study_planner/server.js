require('dotenv').config(); 
const express = require("express");
const path = require("path");
const mongoose = require("mongoose");
const Task = require("./models/Task");

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

// Fixed Connection: Use the process.env variable
mongoose.connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB Connected"))
  .catch(err => console.log("Connection Error:", err));

// Routes
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "contract.html"));
});

app.get("/login", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "login.html"));
});

app.post("/login", (req, res) => {
  const { username, password } = req.body;
  if (username === "web215user" && password === "LetMeIn!") {
    res.redirect("/app");
  } else {
    res.send(`<h1>Access Denied</h1><a href="/login">Try Again</a>`);
  }
});

// Display tasks from MongoDB
app.get("/app", async (req, res) => {
  try {
    const tasks = await Task.find();
    let html = `<h1>Study Planner Dashboard</h1><h2>Your Tasks</h2><ul>`;
    tasks.forEach(task => {
      html += `<li><strong>${task.title}</strong><br>Subject: ${task.subject}<br>${task.description}</li><br>`;
    });
    html += `</ul><a href="/login">Logout</a>`;
    res.send(html);
  } catch (error) {
    res.status(500).send("Error loading tasks");
  }
});

app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
