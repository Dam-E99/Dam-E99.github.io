require('dotenv').config();
const mongoose = require("mongoose");
const Task = require("./models/Task");
const Subject = require("./models/Subject");

mongoose.connect(process.env.MONGO_URI)
  .then(async () => {
    console.log("Connected to MongoDB...");
    await seedData(); 
    console.log("All done!");
    process.exit();
  })
  .catch(err => console.log("Connection Error:", err));

async function seedData() {
  // Clear existing data to avoid duplicates
  await Task.deleteMany({});
  await Subject.deleteMany({});

  // 1. Create the Subjects first (The 'Many' side)
  const subjects = await Subject.insertMany([
    { name: "Programming", department: "Computer Science" },
    { name: "Web Development", department: "Computer Science" },
    { name: "Math", department: "General Education" },
    { name: "English", department: "Humanities" },
    { name: "Psychology", department: "Social Sciences" },
    { name: "Biology", department: "Science" },
    { name: "Networking", department: "IT" },
    { name: "General", department: "Misc" }
  ]);

  // Create a Map to easily find IDs by name
  const subMap = {};
  subjects.forEach(s => subMap[s.name] = s._id);

  // 2. Create Tasks using the Subject IDs (The 'Many-to-Many' relationship)
  const tasks = [
    {
      title: "Study Chapter 1",
      description: "Read and review notes",
      subjects: [subMap["English"]],
      completed: false
    },
    {
      title: "Complete HTML Assignment",
      description: "Finish webpage project",
      subjects: [subMap["Web Development"]],
      completed: false
    },
    {
      title: "Review JavaScript",
      description: "Functions and arrays",
      subjects: [subMap["Programming"]],
      completed: false
    },
    {
      title: "Practice React Components",
      description: "Build sample UI",
      subjects: [subMap["Programming"], subMap["Web Development"]], // Many-to-Many link
      completed: false
    },
    {
      title: "Read Psychology Chapter",
      description: "Chapter 5 notes",
      subjects: [subMap["Psychology"]],
      completed: false
    },
    {
      title: "Submit Math Homework",
      description: "Assignment 4",
      subjects: [subMap["Math"]],
      completed: true
    },
    {
      title: "Study Biology Quiz",
      description: "Cells and DNA",
      subjects: [subMap["Biology"]],
      completed: false
    },
    {
      title: "Complete CSS Lab",
      description: "Grid practice",
      subjects: [subMap["Web Development"]],
      completed: false
    },
    {
      title: "Review Networking",
      description: "OSI layers",
      subjects: [subMap["Networking"]],
      completed: false
    },
    {
      title: "Work on Final Project",
      description: "Initial planning",
      subjects: [subMap["Programming"], subMap["Web Development"]], // Many-to-Many link
      completed: false
    },
    {
      title: "Practice Coding Problems",
      description: "Algorithms",
      subjects: [subMap["Programming"]],
      completed: false
    },
    {
      title: "Organize Notes",
      description: "Folder cleanup",
      subjects: [subMap["General"]],
      completed: true
    }
  ];

  await Task.insertMany(tasks);
  console.log("Sample data inserted with proper Many-to-Many relationships!");
}
