const express = require("express");
const path = require("path");

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

// Login page
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "login.html"));
});

// Handle login
app.post("/login", (req, res) => {
  const { username, password } = req.body;

  if (username === "web215user" && password === "LetMeIn!") {
    res.sendFile(path.join(__dirname, "public", "app.html"));
  } else {
    res.send(`
      <h1>Access Denied</h1>
      <p>Incorrect username or password.</p>
      <a href="/">Try Again</a>
    `);
  }
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});

app.get('/api/data', (req, res) => {
    res.json(studyData);
});


const studyData = [
    { id: 1, subject: "Math", task: "Chapter 5 Problems", status: "In Progress" },
    { id: 2, subject: "History", task: "Read Civil War Section", status: "Done" },
    { id: 3, subject: "Web Dev", task: "M11 Assignment", status: "Not Started" }
];
