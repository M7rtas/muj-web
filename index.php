
<!DOCTYPE html>
<html lang="cs">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Moje hra</title>


    <style>

        body {

            margin: 0;

            overflow: hidden;

            background: #222;

            font-family: Arial, sans-serif;

        }


        /* =========================================
           HRÁČ
        ========================================= */

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


        /* =========================================
           COIN
        ========================================= */

        #coin {

            position: absolute;

            width: 50px;
            height: 50px;

            background-image: url("coin.png");

            background-size: contain;

            background-repeat: no-repeat;

            background-position: center;

        }


        /* =========================================
           POČET COINŮ
        ========================================= */

        #pocet-coinu {

            position: absolute;

            top: 10px;
            left: 50%;

            transform: translateX(-50%);

            margin: 0;

            color: white;

            font-size: 20px;

            z-index: 5;

        }


        /* =========================================
           LEADERBOARD
        ========================================= */

        #leaderboard {

            position: absolute;

            right: 20px;
            top: 20px;

            width: 250px;

            padding: 15px;

            background: #333;

            color: white;

            border-radius: 10px;

            z-index: 10;

        }


        #leaderboard h2 {

            margin-top: 0;

        }


        #jmeno {

            width: 140px;

            padding: 7px;

            box-sizing: border-box;

        }


        #skore-tlacitko {

            padding: 7px;

            cursor: pointer;

        }


        #seznam {

            margin-top: 15px;

        }


        .hrac-leaderboard {

            padding: 5px 0;

            border-bottom: 1px solid #555;

        }


        #stav {

            margin-top: 10px;

            font-size: 13px;

        }

    </style>

</head>


<body>


    <!-- =========================================
         LEADERBOARD
    ========================================== -->

    <div id="leaderboard">

        <h2>🏆 Leaderboard</h2>


        <input
            id="jmeno"
            type="text"
            placeholder="Tvoje jméno"
            maxlength="20"
        >


        <button id="skore-tlacitko">

            Uložit skóre

        </button>


        <div id="stav"></div>


        <div id="seznam">

            Načítám...

        </div>

    </div>



    <!-- =========================================
         POČET COINŮ
    ========================================== -->

    <p id="pocet-coinu">

        Počet coinů: 0

    </p>



    <!-- =========================================
         HRÁČ
    ========================================== -->

    <div id="hrac"></div>



    <!-- =========================================
         COIN
    ========================================== -->

    <div id="coin"></div>



    <!-- =========================================
         SUPABASE
    ========================================== -->

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>


    <script>


        // =====================================================
        // SUPABASE
        // =====================================================

        const supabaseUrl =
            "https://jbkwkjjayraapiuohmwl.supabase.co";


        const supabaseKey =
            "sb_publishable_ZKNpTHkIQ8-nxYzHyku2sA_pK3xoKpL";


        const db =
            window.supabase.createClient(
                supabaseUrl,
                supabaseKey
            );



        // =====================================================
        // HTML PRVKY
        // =====================================================

        const hrac =
            document.getElementById("hrac");


        const coin =
            document.getElementById("coin");


        const pocetCoinu =
            document.getElementById("pocet-coinu");


        const jmeno =
            document.getElementById("jmeno");


        const tlacitko =
            document.getElementById("skore-tlacitko");


        const seznam =
            document.getElementById("seznam");


        const stav =
            document.getElementById("stav");



        // =====================================================
        // POZICE HRÁČE
        // =====================================================

        let x =
            window.innerWidth / 2;


        let y =
            window.innerHeight / 2;



        // =====================================================
        // RYCHLOST
        // =====================================================

        let rychlost = 5;



        // =====================================================
        // SKÓRE
        // =====================================================

        let skore = 0;



        // =====================================================
        // KLÁVESY
        // =====================================================

        const klavesy = {};



        // =====================================================
        // STISK KLÁVESY
        // =====================================================

        document.addEventListener(
            "keydown",
            function(event) {

                // Pokud právě píšeme jméno,
                // hra nebude reagovat na klávesy

                if (
                    document.activeElement === jmeno
                ) {

                    return;

                }


                const klavesa =
                    event.key.toLowerCase();


                klavesy[klavesa] = true;

            }
        );



        // =====================================================
        // UVOLNĚNÍ KLÁVESY
        // =====================================================

        document.addEventListener(
            "keyup",
            function(event) {

                // Pokud právě píšeme jméno,
                // hra nebude reagovat na klávesy

                if (
                    document.activeElement === jmeno
                ) {

                    return;

                }


                const klavesa =
                    event.key.toLowerCase();


                klavesy[klavesa] = false;

            }
        );



        // =====================================================
        // RYCHLOST / SHIFT
        // =====================================================

        function kontrolaRychlosti() {


            if (klavesy["shift"]) {

                rychlost = 10;

            }

            else {

                rychlost = 5;

            }

        }



        // =====================================================
        // KOLIZE
        // =====================================================

        function kolize(a, b) {


            return (

                a.left < b.right &&

                a.right > b.left &&

                a.top < b.bottom &&

                a.bottom > b.top

            );

        }



        // =====================================================
        // RANDOM
        // =====================================================

        function random(min, max) {


            return Math.floor(

                Math.random() *
                (max - min + 1)

            ) + min;

        }



        // =====================================================
        // NOVÁ POZICE COINU
        // =====================================================

        function novaPoziceCoinu() {


            const novaX = random(

                0,

                window.innerWidth - 50

            );


            const novaY = random(

                0,

                window.innerHeight - 50

            );


            coin.style.left =
                novaX + "px";


            coin.style.top =
                novaY + "px";

        }



        // =====================================================
        // KONTROLA COINU
        // =====================================================

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



        // =====================================================
        // POHYB HRÁČE
        // =====================================================

        function pohyb() {


            kontrolaRychlosti();



            // ==========================================
            // W
            // ==========================================

            if (klavesy["w"]) {

                y -= rychlost;

            }



            // ==========================================
            // S
            // ==========================================

            if (klavesy["s"]) {

                y += rychlost;

            }



            // ==========================================
            // A
            // ==========================================

            if (klavesy["a"]) {

                x -= rychlost;

            }



            // ==========================================
            // D
            // ==========================================

            if (klavesy["d"]) {

                x += rychlost;

            }



            // =================================================
            // HRANICE OBRAZOVKY
            // =================================================

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



            // =================================================
            // POZICE HRÁČE
            // =================================================

            hrac.style.left =
                x + "px";


            hrac.style.top =
                y + "px";



            // =================================================
            // KONTROLA COINU
            // =================================================

            kontrolaCoinu();



            // =================================================
            // DALŠÍ FRAME
            // =================================================

            requestAnimationFrame(
                pohyb
            );

        }



        // =====================================================
        // ULOŽENÍ SKÓRE
        // =====================================================

        async function ulozitSkore() {


            const jmenoHrace =
                jmeno.value.trim();



            if (jmenoHrace === "") {


                stav.textContent =
                    "❌ Zadej jméno!";


                return;

            }



            stav.textContent =
                "🔄 Ukládám...";


            tlacitko.disabled = true;



            const { data, error } =
                await db

                    .from("leaderboard")

                    .insert({

                        username:
                            jmenoHrace,

                        coins:
                            skore

                    })

                    .select();



            if (error) {


                console.error(
                    "Chyba při ukládání:",
                    error
                );


                stav.textContent =
                    "❌ Chyba při ukládání:\n" +
                    error.message;


                tlacitko.disabled = false;


                return;

            }



            stav.textContent =
                "✅ Skóre uloženo!";


            tlacitko.disabled = false;


            nactiLeaderboard();

        }



        // =====================================================
        // NAČTENÍ LEADERBOARDU
        // =====================================================

        async function nactiLeaderboard() {


            const { data, error } =
                await db

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


                seznam.textContent =
                    "❌ Chyba načítání.";


                return;

            }



            seznam.innerHTML = "";



            if (
                !data ||
                data.length === 0
            ) {


                seznam.textContent =
                    "Zatím nikdo nemá skóre.";


                return;

            }



            data.forEach(
                function(hracData, index) {


                    const radek =
                        document.createElement(
                            "div"
                        );


                    radek.className =
                        "hrac-leaderboard";


                    radek.textContent =

                        `${index + 1}. ` +

                        `${hracData.username}` +

                        ` - ` +

                        `${hracData.coins}` +

                        ` 🪙`;


                    seznam.appendChild(
                        radek
                    );

                }
            );

        }



        // =====================================================
        // TLAČÍTKO ULOŽIT
        // =====================================================

        tlacitko.addEventListener(

            "click",

            ulozitSkore

        );



        // =====================================================
        // ZABRÁNĚNÍ POSUNU STRÁNKY
        // =====================================================

        document.addEventListener(
            "keydown",
            function(event) {


                // Pokud píšeme jméno,
                // NESMÍME blokovat klávesnici inputu

                if (
                    document.activeElement === jmeno
                ) {

                    return;

                }


                if (

                    event.key.toLowerCase() === "w" ||

                    event.key.toLowerCase() === "a" ||

                    event.key.toLowerCase() === "s" ||

                    event.key.toLowerCase() === "d" ||

                    event.key === "Shift"

                ) {

                    event.preventDefault();

                }

            }
        );



        // =====================================================
        // START HRY
        // =====================================================

        novaPoziceCoinu();


        pohyb();


        nactiLeaderboard();


    </script>


</body>

</html>

