<!DOCTYPE html>
<html>
<body>
<input type="number" placeholder="cislo" id="cislo" oninput="porovnej()">
</body>

<script>
function porovnej() {
  var cislo = document.getElementById("cislo").value;
  if (cislo > 10) {
    alert("Číslo je větší");
  } else if (cislo < 10) {
    alert("Číslo je menší");
  } else {
    alert("Číslo je rovno 10");
  }
}
</script>