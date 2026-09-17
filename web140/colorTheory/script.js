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

        name: "Palette 1",

        primary: "#2563EB",

        secondary: "#0F766E",

        accent: "#F97316",

        background: "#FFFFFF",

        surface: "#F3F4F6",

        text: "#1F2937"

    },


    palette2: {

        name: "Palette 2",

        primary: "#6D28D9",

        secondary: "#BE185D",

        accent: "#B45309",

        background: "#FFFFFF",

        surface: "#F5F3FF",

        text: "#1F2937"

    },


    palette3: {

        name: "Palette 3",

        primary: "#166534",

        secondary: "#0369A1",

        accent: "#B45309",

        background: "#FFFFFF",

        surface: "#F0FDF4",

        text: "#172018"

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