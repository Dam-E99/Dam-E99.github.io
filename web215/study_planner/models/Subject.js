const mongoose = require("mongoose");

const subjectSchema = new mongoose.Schema({
  name: { type: String, required: true },
  department: String
});

module.exports = mongoose.model("Subject", subjectSchema);
