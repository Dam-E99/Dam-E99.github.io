const taskSchema = new mongoose.Schema({
  title: String,
  description: String,
  completed: Boolean,
  // This array of IDs creates the Many-to-Many link
  subjects: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Subject' }]
});