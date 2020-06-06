function registerButtonClicked() {
    document.getElementById("registerPopupSection").classList.toggle("hidden");
    for(var i=0; i<document.getElementsByClassName("registrationCol").length; i++) {
        document.getElementsByClassName("registrationCol")[i].style.visibility = "visible";
    }
}