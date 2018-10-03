function getFileFromServer() {
    var xmlhttp = new XMLHttpRequest ();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var items = xmlhttp.responseText;
            parseItems(items);
        }
    }

    xmlhttp.open("GET", "items.json", true);
    xmlhttp.send();
}

function parseItems(items) {
    var itemsArray = JSON.parse(items);
    var index = itemsArray.indexOf('fabric');
    alert("gotcha" + index);
}