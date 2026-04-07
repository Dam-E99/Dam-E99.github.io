document.getElementById("fizzForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let first = document.getElementById("first").value.trim();
    let middle = document.getElementById("middle").value.trim();
    let last = document.getElementById("last").value.trim();

    // Validate middle initial
    if (middle && middle.length !== 1) {
        alert("Middle initial must be one letter.");
        return;
    }

    // Format name
    let fullName = first;
    if (middle) {
        fullName += " " + middle.toUpperCase() + ".";
    }
    fullName += " " + last;

    document.getElementById("welcome").textContent =
        "Welcome, " + fullName + "!";

    let defaultWord = document.getElementById("defaultWord").value;
    let count = parseInt(document.getElementById("count").value);

    let word1 = document.getElementById("word1").value;
    let word2 = document.getElementById("word2").value;
    let word3 = document.getElementById("word3").value;

    let div1 = parseInt(document.getElementById("div1").value);
    let div2 = parseInt(document.getElementById("div2").value);
    let div3 = parseInt(document.getElementById("div3").value);

    let output = document.getElementById("output");
    output.innerHTML = "";

    for (let i = 1; i <= count; i++) {
        let result = "";

        if (i % div1 === 0) result += word1;
        if (i % div2 === 0) result += word2;
        if (i % div3 === 0) result += word3;

        if (result === "") result = defaultWord;

        let li = document.createElement("li");
        li.textContent = i + ": " + result;
        output.appendChild(li);
    }
});