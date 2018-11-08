function changeTransformation(letterValue) {
    var element = document.getElementById("transformation");
    element.classList = "";
    element.classList.add("object");
    element.classList.add(letterValue);
}

function changeTransition(letterValue) {
    var element = document.getElementById("transition");
    element.classList = "";
    element.classList.add("object");
    element.classList.add(letterValue);
}

function changeAnimation(letterValue) {
    var element = document.getElementById("animation");
    element.classList = "";
    element.classList.add("object");
    element.classList.add(letterValue);
}

function playCombo() {
    var element = document.getElementById("combo");
     element.classList.add(document.getElementById("transformation").classList.item(1));
    element.classList.add(document.getElementById("transition").classList.item(1));
    element.classList.add(document.getElementById("animation").classList.item(1));
}