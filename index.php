<html>
<Head>
    <title>Hra</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1 class="anime-text">Vyber si hru</h1>

<button class="pozice1 anime-button" onclick="window.location.href='https://cestakeklici.dodasvacina.cz/hra/'">
    🎮 Spustit hru o přežití
</button>

<button class="pozice2 anime-button" onclick="window.location.href='https://cestakeklici.dodasvacina.cz/stara/'">
    🎮 Spustit chytání coinů
</button>

</body>
<style>
body {
    background-color: #353434;
}

.anime-text {
    font-family: Impact, fantasy;
    font-size: 60px;
    color: white;
    text-align: center;
    letter-spacing: 4px;

    /* obrys textu */
    -webkit-text-stroke: 2px black;

    /* stín */
    text-shadow:
        4px 4px 0px #ff0066,
        8px 8px 15px black;
}

.pozice1 {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.pozice2 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.anime-button:hover {
    transform: translate(-50%, -50%) scale(1.2);
    
}

.anime-button {
    font-family: Impact, fantasy;
    font-size: 30px;
    color: white;
    letter-spacing: 3px;
 transform-origin: center;
    -webkit-text-stroke: 1px black;

    text-shadow:
        3px 3px 0px #ff0066,
        6px 6px 10px black;

    background: #333;
    border: 2px solid white;
    border-radius: 10px;

    padding: 10px 30px;
    cursor: pointer;
}
</style>
  </html>