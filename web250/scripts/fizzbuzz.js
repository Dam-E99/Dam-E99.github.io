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

    const isClassic = document.getElementById("classicMode").checked;
    
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
    rules.forEach((rule) => {
        if (i % rule.div === 0) result += rule.word;
    });

    if (isClassic) {
            // Classic Logic: 1, 2, Fizz, 4, Buzz...
            // If there's a result (word), show ONLY the word. 
            // If no match, show ONLY the number.
            listItems += `<li>${result || i}</li>`;
        } else {
            // Your Current Logic: 1: Dodo, 2: Dodo, 3: Fizz...
            const finalOutput = result || defaultWord;
            listItems += `<li>${i}: ${finalOutput}</li>`;
        }
}

    document.getElementById("output").innerHTML = listItems;
});
