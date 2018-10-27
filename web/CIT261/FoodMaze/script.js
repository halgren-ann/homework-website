function drawCheckeredBackground(can, nRow, nCol) {
    var ctx = can.getContext("2d");
    var w = can.width;
    var h = can.height;

    nRow = nRow || 8;    // default number of rows
    nCol = nCol || 8;    // default number of columns

    w /= nCol;            // width of a block
    h /= nRow;            // height of a block

    for (var i = 0; i < nRow; ++i) {
        for (var j = 0, col = nCol / 2; j < col; ++j) {
            ctx.rect(2 * j * w + (i % 2 ? 0 : w), i * h, w, h);
        }
    }
		ctx.fillStyle ="#D2691E";
    ctx.fill();
}

var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
ctx.fillStyle = "#228B22";
ctx.fillRect(0, 0, canvas.width, canvas.height);
drawCheckeredBackground(canvas, 4, 6);

/*
var cell_width = 100;
var cell_height = 100;
var x_offset = 100;
var y_offset = 100;


function Coordinate(x, y) {
    this.x = x;
    this.y = y;
}

//Define the Food constructor
function Food() {}
Food.prototype.width = cell_width;
Food.prototype.height = cell_height;
Food.location = new Coordinate();
Food.prototype.hideFood = function(element) {
    element.classList.add('hidden');
}
Food.prototype.getScale = 1;

//Define the Broccoli constructor
Broccoli.prototype = new Food();
//Correct the constructor pointer, because it points to Food
Broccoli.prototype.constructor = Broccoli;
Broccoli.getScale = 1.2;
Broccoli.locations = [
    new Coordinate(x_offset + (5*cell_width), y_offset),
    new Coordinate(x_offset + (3*cell_width), y_offset + cell_width),
    new Coordinate(x_offset + cell_width, y_offset + (2*cell_height))
];

//Define the Bread constructor
Bread.prototype = new Food();
//Correct the constructor pointer, because it points to Food
Bread.prototype.constructor = Bread;
Bread.getScale = 1.3;
Bread.locations = [
    new Coordinate(x_offset + (2*cell_width), y_offset),
    new Coordinate(x_offset + (4*cell_width), y_offset + (2*cell_width)),
    new Coordinate(x_offset, y_offset + (3*cell_height))
];

//Define the Coffee constructor
Coffee.prototype = new Food();
//Correct the constructor pointer, because it points to Food
Coffee.prototype.constructor = Coffee;
Coffee.getScale = 0.8;
Coffee.locations = [
    new Coordinate(x_offset + cell_width, y_offset),
    new Coordinate(x_offset + (5*cell_width), y_offset + (2*cell_width)),
    new Coordinate(x_offset + (2*cell_width), y_offset + (3*cell_height))
];
*/

var newImage = document.createElement("IMG");
    newImage.src = "broccoli.png";
    newImage.STYLE="position:absolute; TOP:100px; LEFT:100px; WIDTH:100px; HEIGHT:100px"; 
    var element = document.getElementById("gameboard");
    element.appendChild(newImage);

/*
//make the array of food objects
var foodArray;
for (var i=0; i<3; i++) {
		var newBroccoli = new Broccoli();
    newBroccoli.location = newBroccoli.locations[i];
    foodArray[(i*3)] = newBroccoli;
    var newBread = new Bread();
    newBread.location = newBread.locations[i];
    foodArray[(i*3) + 1] = newBread;
    var newCoffee = new Coffee();
    newCoffee.location = newCoffee.locations[i];
    foodArray[(i*3) + 2] = newCoffee;
}

//now draw the food objects on the board
for (var i=0; i<foodArray.length; i++) {
		var newImage = document.createElement("IMG");
    if (typeOf(foodArray[i]) == "Broccoli") {
    		newImage.src = "broccoli.png";
    }
    else if (typeOf(foodArray[i]) == "Bread") {
    		newImage.src = "bread.png";
    }
    else {
    		newImage.src = "coffee.png";
    }
    //newImage.width = foodArray[i].width;
    //newImage.height = foodArray[i].height;
    newImage.style = "position:absolute; top:" + foodArray[i].location.y + "px; left:" + foodArray[i].locations.x + "px";
    var element = document.getElementById("gameboard");
    element.appendChild(newImage);
}
*/



