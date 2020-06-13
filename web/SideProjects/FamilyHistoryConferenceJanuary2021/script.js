function openRegisterPopupSection() {
    document.getElementById("registerPopupSection").classList.toggle("hidden");
    for(var i=0; i<document.getElementsByClassName("registrationCol").length; i++) {
        document.getElementsByClassName("registrationCol")[i].style.visibility = "visible";
        //document.getElementsByClassName("registrationCol")[i].style.display = "block";
    }
}

function closeRegisterPopupSection() {
    document.getElementById("registerPopupSection").classList.toggle("hidden");
    for(var i=0; i<document.getElementsByClassName("registrationCol").length; i++) {
        document.getElementsByClassName("registrationCol")[i].style.visibility = "collapse";
        //document.getElementsByClassName("registrationCol")[i].style.display = "hidden";
    }
}