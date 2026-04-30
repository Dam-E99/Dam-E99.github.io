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