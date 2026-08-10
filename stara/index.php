<!DOCTYPE html>
<html lang="cs">

<head>

    <meta charset="UTF-8">

    <title>Hra</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div id="leaderboard">

        <h2>🏆 </h2>

        <input
            id="jmeno"
            type="text"
            placeholder="Tvoje jméno"
            maxlength="20"
           
        >

        <button  id="skore-tlacitko">
            Uložit skóre
        </button>

        <div id="stav"></div>

        <div id="seznam">
            Načítám....
        </div>

    </div>


    <p id="pocet-coinu">
        Počet coinů: 0
    </p>


    <div id="hrac"></div>

    <div id="coin"></div>


    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>

    <script src="leaderboard.js"></script>

    <script src="hra.js"></script>

</body>

</html>