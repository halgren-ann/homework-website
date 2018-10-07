function hello() {
    return 7.99;
}

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
            if(index != -1) {        
                // Get the snackbar DIV
                var x = document.getElementById("snackbar");
        
                // Add the "show" class to DIV
                x.className = "show";
        
                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
        }
    }

    xmlhttp.open("GET", "items.json", true);
    xmlhttp.send();
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