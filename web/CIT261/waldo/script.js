function myFunction(item) {
    //capture the chosen item
    var child = document.getElementById(item);
    var parent = child.parentNode;
    //remove the chosen item
    parent.removeChild(child);
    //add the item back in at a new location
    var location = (Math.floor(Math.random() * 6)) * 2;
    var btn = document.createElement("BUTTON");        // Create a <button> element
    var t = document.createTextNode(item);       // Create a text node
    btn.appendChild(t);                                // Append the text to <button>
    parent.insertBefore(child, parent.childNodes[location]);
}