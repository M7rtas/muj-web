<!DOCTYPE html>
<html>
<body>
<button id="myButton" onclick="prepniObrazek()">Click me</button>
</body>
<img src="emoji.png" alt="Emoji" id="myImage" scale="0.5" width="100" height="100" img style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
<script>
function prepniObrazek() {
    var image = document.getElementById("myImage");
    if (image.src.includes("emoji.png")) {
        image.src = "new_image.png";
    } else {
        image.src = "emoji.png";
    }
}
</script>