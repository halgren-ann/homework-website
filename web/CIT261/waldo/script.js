function myFunction(item) {
    //capture the chosen item
    var child = document.getElementById(item);
    //remove the chosen item
    child.parentNode.removeChild(child);
    //add the item back in at a new location
    var location = (Math.floor(Math.random() * 6)) * 2;
    child.parentNode.insertBefore(child, list.childNodes[location]);
}