<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html>
<body>
<input class="nahoreuprostred" type="number" placeholder="cislo" id="cislo" oninput="porovnej()">
<div id="vysledek"></div>
</body>

<script>
function porovnej() {
  var cislo = document.getElementById("cislo").value;
  if (cislo > 10) {
    document.getElementById("vysledek").innerHTML = '<h1 class="uprostred">Číslo je menší</h1>';
} else if (cislo < 10) {
    document.getElementById("vysledek").innerHTML = '<h1 class="uprostred">Číslo je větší</h1>';
  } else if (cislo === "") {
    document.getElementById("vysledek").innerHTML = '<h1 class="uprostred">Zadejte číslo</h1>';
  }
  
  else {
    document.getElementById("vysledek").innerHTML = '<h1 class="uprostred">Číslo je 10</h1>';
  }
}
</script>