function loadStorage() {
    //first, remove all the existinig elements
    document.getElementById("myUL").innerHTML = "";

    //test localStorage understanding
    //var testArray = {"This is some task text":"unchecked","This is a task that has been checked off":"checked"};
    //localStorage.setItem("taskArray", JSON.stringify(testArray));

    //then, loop through LocalStorage to add the existing elements
    var array = JSON.parse(localStorage["taskArray"]);
    for (var key in array) {
        var li = document.createElement("li");
        var inputValue = key;
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        document.getElementById("myUL").appendChild(li);
        if (array[key] == "checked") {
            li.classList.add("checked");
        }
        /*document.getElementById("myInput").value = "";
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        li.appendChild(span);

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
            }
        }*/
    }
}

//let the user hit "Enter" to add a task
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

// Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item and remove it from localStorage
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    //remove this item from localStorage
    /*var text = div.textContent;
    var array = JSON.parse(localStorage["taskArray"]);
    localStorage.removeItem("taskArray");
    delete array[text];
    localStorage.setItem("taskArray", JSON.stringify(array));*/
    //stop displaying this item on the webpage
    div.style.display = "none";
  }
}

// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
    //tell localStorage whether this item is checked or not
    var text = ev.target.childNodes[0];
    var array = JSON.parse(localStorage["taskArray"]);
    localStorage.removeItem("taskArray");
    if(array[text] == "checked") array[text] = "unchecked";
    else array[text] = "checked";
    localStorage.setItem("taskArray", JSON.stringify(array));
  }
}, false);

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
    //add to localStorage
    /*var text = li.textContent;
    var array = JSON.parse(localStorage["taskArray"]);
    localStorage.removeItem("taskArray");
    array[text] = "unchecked";
    localStorage.setItem("taskArray", JSON.stringify(array));*/
  }
  document.getElementById("myInput").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}