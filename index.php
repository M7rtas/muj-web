<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>WASD pohyb</title>

    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: #222;
        }

        #hrac {
            position: absolute;
            width: 50px;
            height: 50px;
            background: red;
            border-radius: 10px;

            left: 50%;
            top: 50%;

            transform: translate(-50%, -50%);
        }

        #coin {
            position: absolute;
            width: 30px;
            height: 30px;
    background-image: url("coin.png");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
        }
    </style>
</head>

<body>

<p   style="text-align: center;  color: white; font-size: 20px;" id="pocetcoinu">Počet mincí: 0</p>
<div id="hrac"></div>
<div id="coin"></div>

<script>

const hrac = document.getElementById("hrac");
const coin = document.getElementById("coin");
const pocetCoinu = document.getElementById("pocetcoinu");

let x = window.innerWidth / 2;
let y = window.innerHeight / 2;

let rychlost = 5;

const klavesy = {};

document.addEventListener("keydown", function(event) {
    klavesy[event.key.toLowerCase()] = true;
});

document.addEventListener("keyup", function(event) {
    klavesy[event.key.toLowerCase()] = false;
});

function kolize(a, b) {
    return (
        a.left < b.right &&
        a.right > b.left &&
        a.top < b.bottom &&
        a.bottom > b.top
    );
}

function kontrolaCoinu() {
    const hracRect = document.getElementById("hrac").getBoundingClientRect();
    const coin = document.getElementById("coin");

    if (coin.style.display === "none") {
        return;
    }

    const coinRect = coin.getBoundingClientRect();

    if (kolize(hracRect, coinRect)) {
        coin.style.display = "none";
        pocetCoinu.textContent = "Počet mincí: " + (parseInt(pocetCoinu.textContent.split(": ")[1]) + 1);
    }
}

function pohyb() {

kontrolaCoinu();

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

    // Nepustíme hráče mimo obrazovku
    x = Math.max(25, Math.min(window.innerWidth - 25, x));
    y = Math.max(25, Math.min(window.innerHeight - 25, y));

    hrac.style.left = x + "px";
    hrac.style.top = y + "px";

    requestAnimationFrame(pohyb);
}

pohyb();

</script>

</body>
</html>