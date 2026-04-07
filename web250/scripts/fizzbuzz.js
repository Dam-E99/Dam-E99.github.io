document.getElementById("fizzForm").addEventListener("submit", function(e) {
    e.preventDefault();

    // Get Name Values
    const first = document.getElementById("first").value.trim();
    const middle = document.getElementById("middle").value.trim();
    const last = document.getElementById("last").value.trim();

    // Proper Name Punctuation Logic
    const middleDisplay = middle ? ` ${middle.toUpperCase()}. ` : " ";
    document.getElementById("welcome").textContent = `Welcome, ${first}${middleDisplay}${last}!`;

    // Get Config Values
    const defaultWord = document.getElementById("defaultWord").value;
    const count = parseInt(document.getElementById("count").value);
    
    // Put divisors/words in an array for cleaner looping
    const rules = [
        { word: document.getElementById("word1").value, div: parseInt(document.getElementById("div1").value) },
        { word: document.getElementById("word2").value, div: parseInt(document.getElementById("div2").value) },
        { word: document.getElementById("word3").value, div: parseInt(document.getElementById("div3").value) }
    ];

    let listItems = "";
    for (let i = 1; i <= count; i++) {
    let result = "";
    
    // Check divisors
    rules.forEach(rule => {
        if (i % rule.div === 0) result += rule.word;
    });

    // If no divisors were hit, use only the default word
    // This removes the extra count and parentheses
    const finalOutput = result || defaultWord;

    // Use a single instance of the number at the start of the list item
    listItems += `<li>${i}: ${finalOutput}</li>`;
}

    document.getElementById("output").innerHTML = listItems;
});
