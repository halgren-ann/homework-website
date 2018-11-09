//Load LocalStorage stuff
function loadStorage() {
    var array = new Array();
    array = JSON.parse(localStorage["items"]);

    for (var i=0; i<array.length; i++) {
        var li = document.createElement("li");
        var inputValue = array[i];
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        if (inputValue === '') {
            alert("You must write something!");
        } else {
            var list = document.getElementById("myUL");
            list.insertBefore(li, list.childNodes[0]);
        }
        document.getElementById("myInput").value = "";
    }
}

function addtoStorage(text) {
    var array = new Array();
    array = JSON.parse(localStorage["items"]);
    array.push(string);
    localStorage.setItem("items", array);
}

// Create a new list item when clicking on the "Add" button
function newElement() {
    var li = document.createElement("li");
    var inputValue = document.getElementById("myInput").value;
    var t = document.createTextNode(inputValue);
    li.appendChild(t);
    if (inputValue === '') {
      alert("You must write something!");
    } else {
        var list = document.getElementById("myUL");
        list.insertBefore(li, list.childNodes[0]);
        addtoStorage(inputValue);
    }
    document.getElementById("myInput").value = "";
  }
  
  // Get the input field
  var input = document.getElementById("myInput");
  
  // Execute a function when the user releases a key on the keyboard
  input.addEventListener("keyup", function(event) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
      // Trigger the button element with a click
      document.getElementById("addBtn").click();
    }
  });