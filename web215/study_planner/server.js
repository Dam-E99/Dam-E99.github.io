const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Tell Node to serve your CSS/Images from the public folder
app.use(express.static(path.join(__dirname, 'public')));

// Serve your contract/intro as the home page
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'contract.html')); 
});

app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
