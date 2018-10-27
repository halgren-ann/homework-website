var cell_width = 40;
var cell_height = 40;
var x_offset = 40;
var y_offset = 40;
var nRow = 4;
var nCol = 6;


/*
function Coordinate(x, y) {
    this.x = x;
    this.y = y;
}

//Define the Food constructor
function Food() {}
Food.prototype.width = cell_width;
Food.prototype.height = cell_height;
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

    //ctx.fillStyle = "#D2691E";
    ctx.fill();
}

document.write("Hello, you made it to JS!");
window.onload = function() { 
    var canvas = document.getElementById("canvas");
    //var ctx = canvas.getContext("2d");
    //ctx.fillStyle = "#228B22";
    //ctx.fillRect(0, 0, canvas.width, canvas.height);

    drawCheckeredBackground(canvas, nRow, noCol);
}



/*
window.onload=function() {
    var greenArray = document.getElementsByClassName("green");
    for (var i=0; i<greenArray.length; i++) {
        var one = greenArray[i];
        var ctx = one.getContext("2d");
        ctx.fillStyle = "#228B22";
        ctx.fillRect(0, 0, 80, 100);
    }

    var brownArray = document.getElementsByClassName("brown");
    for (var i=0; i<brownArray.length; i++) {
        var one = brownArray[i];
        var ctx = one.getContext("2d");
        ctx.fillStyle = "#D2691E";
        ctx.fillRect(100, 100, 80, 100);
}
}
*/
