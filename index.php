```html
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Moje hra</title>

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
            width: 50px;
            height: 50px;

            background-image: url("coin.png");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;

            left: 100px;
            top: 100px;
        }

        #leaderboard {
            position: absolute;
            right: 20px;
            top: 20px;

            width: 250px;
            padding: 15px;

            background: #333;
            color: white;

            border-radius: 10px;
            font-family: Arial, sans-serif;

            z-index: 10;
        }

        #leaderboard h2 {
            margin-top: 0;
        }

        #jmeno {
            width: 140px;
            padding: 7px;
        }

        #leaderboard button {
            padding: 7px;
            cursor: pointer;
        }

        #seznam {
            margin-top: 15px;
        }

        #stav {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <!-- LEADERBOARD -->

    <div id="leaderboard">

        <h2>🏆 Leaderboard</h2>

        <input
            id="jmeno"
            type="text"
            placeholder="Tvoje jméno"
            maxlength="20"
        >

        <button id="ulozit">
            Uložit skóre
        </button>

        <div id="stav"></div>

        <div id="seznam"></div>

    </div>


    <!-- POČET COINŮ -->

    <p
        style="
            text-align: center;
            color: white;
            font-size: 20px;
        "
        id="pocet-coinu"
    >
        Počet coinů: 0
    </p>


    <!-- HRÁČ -->

    <div id="hrac"></div>


    <!-- COIN -->

    <div id="coin"></div>


    <!-- SUPABASE KNIHOVNA -->

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>


    <script>

        // ==========================================
        // SUPABASE
        // ==========================================

       // const supabaseUrl =
      //      "https://jbkwkjjayraapiuohmwl.supabase.co";

      //  const supabaseKey =
       //     "sb_publishable_ZKNpTHkIQ8-nxYzHyku2sA_pK3xoKpL";

      //  const supabase = window.supabase.createClient(
      //    supabaseUrl,
  //  supabaseKey
           
      //  );


        // ==========================================
        // HTML PRVKY
        // ==========================================

        const hrac =
            document.getElementById("hrac");

        const coin =
            document.getElementById("coin");

        const pocetCoinu =
            document.getElementById("pocet-coinu");

        const jmeno =
            document.getElementById("jmeno");

        const tlacitkoUlozit =
            document.getElementById("ulozit");

        const seznam =
            document.getElementById("seznam");

        const stav =
            document.getElementById("stav");


        // ==========================================
        // HRÁČ
        // ==========================================

        let x =
            window.innerWidth / 2;

        let y =
            window.innerHeight / 2;


        let rychlost = 5;


        // ==========================================
        // SKÓRE
        // ==========================================

        let skore = 0;


        // ==========================================
        // KLÁVESY
        // ==========================================

        const klavesy = {};


        document.addEventListener(
            "keydown",
            function(event) {

                klavesy[
                    event.key.toLowerCase()
                ] = true;

            }
        );


        document.addEventListener(
            "keyup",
            function(event) {

                klavesy[
                    event.key.toLowerCase()
                ] = false;

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


            // W

            if (klavesy["w"]) {

                y -= rychlost;

            }


            // S

            if (klavesy["s"]) {

                y += rychlost;

            }


            // A

            if (klavesy["a"]) {

                x -= rychlost;

            }


            // D

            if (klavesy["d"]) {

                x += rychlost;

            }


            // Hranice obrazovky

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


            // Nastavení pozice

            hrac.style.left =
                x + "px";

            hrac.style.top =
                y + "px";


            // Kontrola coinu

            kontrolaCoinu();


            // Další snímek

            requestAnimationFrame(
                pohyb
            );

        }


        // ==========================================
        // ULOŽENÍ SKÓRE
        // ==========================================

        async function ulozitSkore() {

            const jmenoHrace =
                jmeno.value.trim();


            if (jmenoHrace === "") {

                alert(
                    "Zadej jméno!"
                );

                return;

            }


            stav.textContent =
                "Ukládám...";


            const { error } =
                await supabase
                    .from("leaderboard")
                    .insert({

                        username:
                            jmenoHrace,

                        coins:
                            skore

                    });


            if (error) {

                console.error(
                    "Chyba při ukládání:",
                    error
                );

                stav.textContent =
                    "❌ Chyba při ukládání.";

                return;

            }


            stav.textContent =
                "✅ Skóre uloženo!";


          //  nactiLeaderboard();

        }


        // ==========================================
        // TLAČÍTKO ULOŽIT
        // ==========================================

        tlacitkoUlozit.addEventListener(
            "click",
            ulozitSkore
        );


        // ==========================================
        // LEADERBOARD
        // ==========================================

        async function nactiLeaderboard() {

            const { data, error } =
                await supabase
                    .from("leaderboard")
                    .select("*")
                    .order(
                        "coins",
                        {
                            ascending: false
                        }
                    )
                    .limit(10);


            if (error) {

                console.error(
                    "Chyba leaderboardu:",
                    error
                );

                stav.textContent =
                    "❌ Nelze načíst leaderboard.";

                return;

            }


            seznam.innerHTML = "";


            data.forEach(
                function(hracData, index) {

                    const radek =
                        document.createElement(
                            "div"
                        );


                    radek.textContent =
                        `${index + 1}. ${hracData.username} - ${hracData.coins} 🪙`;


                    seznam.appendChild(
                        radek
                    );

                }
            );

        }


        // ==========================================
        // SPUŠTĚNÍ HRY
        // ==========================================

        novaPoziceCoinu();

        pohyb();

        // nactiLeaderboard();

    </script>

</body>
</html>
```
