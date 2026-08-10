// ==========================================
// HTML
// ==========================================

const hrac =
    document.getElementById("hrac");

const coin =
    document.getElementById("coin");

const pocetCoinu =
    document.getElementById("pocet-coinu");

const jmenoInput =
    document.getElementById("jmeno");


// ==========================================
// HRÁČ
// ==========================================

let x =
    window.innerWidth / 2;

let y =
    window.innerHeight / 2;


// ==========================================
// RYCHLOST
// ==========================================

let rychlost = 5;


// ==========================================
// SKÓRE
// ==========================================

let skore = 0;


// ==========================================
// KLÁVESY
// ==========================================

const klavesy = {};


// ==========================================
// KEYDOWN
// ==========================================

document.addEventListener(
    "keydown",
    function(event) {

        // Pokud píšeme jméno,
        // hra nereaguje na klávesnici

        if (
            document.activeElement === jmenoInput
        ) {
            return;
        }


        const klavesa =
            event.key.toLowerCase();


        klavesy[klavesa] = true;

    }
);


// ==========================================
// KEYUP
// ==========================================

document.addEventListener(
    "keyup",
    function(event) {

        if (
            document.activeElement === jmenoInput
        ) {
            return;
        }


        const klavesa =
            event.key.toLowerCase();


        klavesy[klavesa] = false;

    }
);


// ==========================================
// RYCHLOST
// ==========================================

function kontrolaRychlosti() {

    if (klavesy["shift"]) {

        rychlost = 10;

    } else {

        rychlost = 5;

    }
}


// ==========================================
// KOLIZE
// ==========================================

function kolize(a, b) {

    return (

        a.left < b.right &&
        a.right > b.left &&
        a.top < b.bottom &&
        a.bottom > b.top

    );
}


// ==========================================
// RANDOM
// ==========================================

function random(min, max) {

    return Math.floor(
        Math.random() *
        (max - min + 1)
    ) + min;

}


// ==========================================
// NOVÁ POZICE COINU
// ==========================================

function novaPoziceCoinu() {

    const novaX =
        random(
            0,
            window.innerWidth - 50
        );


    const novaY =
        random(
            0,
            window.innerHeight - 50
        );


    coin.style.left =
        novaX + "px";


    coin.style.top =
        novaY + "px";

}


// ==========================================
// KONTROLA COINU
// ==========================================

function kontrolaCoinu() {

    const hracRect =
        hrac.getBoundingClientRect();


    const coinRect =
        coin.getBoundingClientRect();


    if (
        kolize(
            hracRect,
            coinRect
        )
    ) {

        skore++;


        pocetCoinu.textContent =
            "Počet coinů: " + skore;


        novaPoziceCoinu();

    }

}


// ==========================================
// POHYB
// ==========================================

function pohyb() {

    kontrolaRychlosti();


    if (klavesy["w"]) {
        y -= rychlost;
    }


    if (klavesy["s"]) {
        y += rychlost;
    }


    if (klavesy["a"]) {
        x -= rychlost;
    }


    if (klavesy["d"]) {
        x += rychlost;
    }


    // ======================================
    // HRANICE OBRAZOVKY
    // ======================================

    x = Math.max(
        25,
        Math.min(
            window.innerWidth - 25,
            x
        )
    );


    y = Math.max(
        25,
        Math.min(
            window.innerHeight - 25,
            y
        )
    );


    // ======================================
    // POZICE HRÁČE
    // ======================================

    hrac.style.left =
        x + "px";


    hrac.style.top =
        y + "px";


    // ======================================
    // COIN
    // ======================================

    kontrolaCoinu();


    requestAnimationFrame(
        pohyb
    );

}


// ==========================================
// ZABRÁNĚNÍ POSUNU STRÁNKY
// ==========================================

document.addEventListener(
    "keydown",
    function(event) {

        if (
            document.activeElement === jmenoInput
        ) {
            return;
        }


        const klavesa =
            event.key.toLowerCase();


        if (
            klavesa === "w" ||
            klavesa === "a" ||
            klavesa === "s" ||
            klavesa === "d" ||
            event.key === "Shift"
        ) {

            event.preventDefault();

        }

    }
);


// ==========================================
// START
// ==========================================

novaPoziceCoinu();

pohyb();