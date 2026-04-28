const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// This line allows you to serve ALL files in the 'public' folder (CSS, Images, etc.)
app.use(express.static(path.join(__dirname, 'public')));

// Specific route for your "Primitive App" home page
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'contract.html'));
});

app.listen(PORT, () => {
    console.log(`Study Planner running at http://localhost:${PORT}`);
});
