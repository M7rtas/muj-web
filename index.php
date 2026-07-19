<!DOCTYPE html>
<html>
<body>
<button id="myButton" onclick="prepniObrazek()">Click me</button>
</body>
<img src="emoji.png" alt="Emoji" id="myImage">
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