require('dotenv').config();
const mongoose = require("mongoose");
const Task = require("./models/Task");

mongoose.connect(process.env.MONGO_URI)
  .then(async () => {
    console.log("Connected to MongoDB...");
    
    // Now that we are connected, run the function
    await seedData(); 
    
    console.log("All done!");
    process.exit();
  })
  .catch(err => console.log("Connection Error:", err));

const tasks = [
  {
    title: "Study Chapter 1",
    description: "Read and review notes",
    subject: "English",
    completed: false
  },
  {
    title: "Complete HTML Assignment",
    description: "Finish webpage project",
    subject: "Web Development",
    completed: false
  },
  {
    title: "Review JavaScript",
    description: "Functions and arrays",
    subject: "Programming",
    completed: false
  },
  {
    title: "Practice React Components",
    description: "Build sample UI",
    subject: "Programming",
    completed: false
  },
  {
    title: "Read Psychology Chapter",
    description: "Chapter 5 notes",
    subject: "Psychology",
    completed: false
  },
  {
    title: "Submit Math Homework",
    description: "Assignment 4",
    subject: "Math",
    completed: true
  },
  {
    title: "Study Biology Quiz",
    description: "Cells and DNA",
    subject: "Biology",
    completed: false
  },
  {
    title: "Complete CSS Lab",
    description: "Grid practice",
    subject: "Web Development",
    completed: false
  },
  {
    title: "Review Networking",
    description: "OSI layers",
    subject: "Networking",
    completed: false
  },
  {
    title: "Work on Final Project",
    description: "Initial planning",
    subject: "Programming",
    completed: false
  },
  {
    title: "Practice Coding Problems",
    description: "Algorithms",
    subject: "Programming",
    completed: false
  },
  {
    title: "Organize Notes",
    description: "Folder cleanup",
    subject: "General",
    completed: true
  }
];

async function seedData() {
  await Task.deleteMany({});
  await Task.insertMany(tasks);
  console.log("Sample data inserted!");
}