<!DOCTYPE html>
<html>
<body>

<input type="number" id="textik" oninput="reaguj()" placeholder="Napiš číslo">

<p id="vystup"></p>

<script>
  function reaguj() {
    let text = document.getElementById("textik").value;

    if (text < 5) {
      document.getElementById("vystup").innerText = "míň ⬇️";
    } else if (text == 5) {
      document.getElementById("vystup").innerText = "rovno 5 🎯";
    } else {
      document.getElementById("vystup").innerText = "víc ⬆️";
    }
  }
</script>