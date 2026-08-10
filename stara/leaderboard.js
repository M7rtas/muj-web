// ==========================================
// SUPABASE
// ==========================================

const supabaseUrl =
    "https://jbkwkjjayraapiuohmwl.supabase.co";

const supabaseKey =
    "sb_publishable_ZKNpTHkIQ8-nxYzHyku2sA_pK3xoKpL";


const db =
    window.supabase.createClient(
        supabaseUrl,
        supabaseKey
    );


// ==========================================
// HTML
// ==========================================

const jmeno =
    document.getElementById("jmeno");

const tlacitko =
    document.getElementById("skore-tlacitko");

const seznam =
    document.getElementById("seznam");

const stav =
    document.getElementById("stav");


// ==========================================
// ULOŽENÍ SKÓRE
// ==========================================

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


    const { error } =
        await db
            .from("leaderboard")
            .insert({

                username: jmenoHrace,

                coins: skore

            });


    if (error) {

        console.error(error);

        stav.textContent =
            "❌ Chyba: " +
            error.message;

        tlacitko.disabled = false;

        return;
    }


    stav.textContent =
        "✅ Skóre uloženo!";


    tlacitko.disabled = false;


    nactiLeaderboard();
}


// ==========================================
// NAČTENÍ LEADERBOARDU
// ==========================================

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

        console.error(error);

        seznam.textContent =
            "❌ Chyba načítání.";

        return;
    }


    seznam.innerHTML = "";


    data.forEach(
        function(hracData, index) {

            const radek =
                document.createElement("div");


            radek.className =
                "hrac-leaderboard";


            radek.textContent =
                `${index + 1}. ` +
                `${hracData.username} - ` +
                `${hracData.coins} 🪙`;


            seznam.appendChild(radek);

        }
    );
}


// ==========================================
// TLAČÍTKO
// ==========================================

tlacitko.addEventListener(
    "click",
    ulozitSkore
);


// ==========================================
// START
// ==========================================

nactiLeaderboard();