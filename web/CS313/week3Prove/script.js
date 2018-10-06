function addToCart(item) {
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
        }
    }

    xmlhttp.open("GET", "items.json", true);
    xmlhttp.send();
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