const subjectSchema = new mongoose.Schema({
  name: String,
  department: String,
  tasks: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Task' }]
});