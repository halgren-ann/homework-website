function addToCart(item) {
    var itemsStr = getFileFromServer();
    var itemsArray = parseItems(itemsStr);
    var index = getItem(itemsArray, item);
    if(index != -1) {
        $_SESSION[itemsArray[index].name] = itemsArray[index].price;   
    }
}

function getDetails(item) {
    var xmlhttp = new XMLHttpRequest ();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var itemsArray = JSON.parse(xmlhttp.responseText);
            var index;
            for(i in itemsArray) {
                if(itemsArray[i].name == item) {
                    index = i;
                }
            }
            if(index != -1) {
                alert("Our " + itemsArray[index].name + " comes brand new. It costs $" + itemsArray[index].price + " and ships free!");
            }
        }
    }

    xmlhttp.open("GET", "items.json", true);
    xmlhttp.send();
}

function getFileFromServer() {
    var xmlhttp = new XMLHttpRequest ();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var itemsStr = xmlhttp.responseText;
            return itemsStr;
        }
    }

    xmlhttp.open("GET", "items.json", true);
    xmlhttp.send();
}

function parseItems(itemsStr) {
    var itemsArray = JSON.parse(itemsStr);
    return itemsArray;
}

function getItem(itemsArray, item) {
    var index;
    for(i in itemsArray) {
        if(itemsArray[i].name == item) {
            index = i;
        }
    }
    return index;
}

function presentDetails(itemsArray, index) {
    alert("Our " + itemsArray[index].name + " comes brand new. It costs $" + itemsArray[index].price + " and ships free!");
}