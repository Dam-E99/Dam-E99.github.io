/* ========================================
   COLOR THEORY PROJECT
======================================== */


/* ========================================
   COLOR PALETTES

   Students should replace these colors
   with their own colors.
======================================== */

const palettes = {

    palette1: {

        name: "Complementary",

        primary: "#633F30",

        secondary: "#243835",

        accent: "#B8491C",

        background: "#30786D",

        surface: "#F3F4F6",

        text: "#1BB8A0"

    },


    palette2: {

        name: "Analogous",

        primary: "#C98444",

        secondary: "#C96C44",

        accent: "#C95544",

        background: "#C99844",

        surface: "#F5F3FF",

        text: "#C9445B"

    },


    palette3: {

        name: "Triadic",

        primary: "#9D9AD6",

        secondary: "#668160",

        accent: "#D6B09A",

        background: "#A4D79A",

        surface: "#F0FDF4",

        text: "#574032"

    }

};


/* ========================================
   APPLY SELECTED PALETTE
======================================== */

function applyPalette(palette) {

    const root =
        document.documentElement;


    /* Apply palette colors */

    root.style.setProperty(
        "--primary",
        palette.primary
    );


    root.style.setProperty(
        "--secondary",
        palette.secondary
    );


    root.style.setProperty(
        "--accent",
        palette.accent
    );


    root.style.setProperty(
        "--background",
        palette.background
    );


    root.style.setProperty(
        "--surface",
        palette.surface
    );


    root.style.setProperty(
        "--text",
        palette.text
    );


    /* Update HEX values */

    document.getElementById("primaryHex").textContent =
        palette.primary;


    document.getElementById("secondaryHex").textContent =
        palette.secondary;


    document.getElementById("accentHex").textContent =
        palette.accent;


    document.getElementById("backgroundHex").textContent =
        palette.background;


    document.getElementById("textHex").textContent =
        palette.text;

}


/* ========================================
   PALETTE BUTTONS
======================================== */

const paletteButtons =
    document.querySelectorAll("[data-palette]");


paletteButtons.forEach(function(button) {

    button.addEventListener("click", function() {

        const paletteName =
            button.dataset.palette;


        const selectedPalette =
            palettes[paletteName];


        applyPalette(selectedPalette);

    });

});


/* ========================================
   INITIAL PALETTE
======================================== */

applyPalette(palettes.palette1);