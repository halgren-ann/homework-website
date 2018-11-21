function newGame() {

}

function getInstructions() {

}

//Make the card object
//Valid values are as follows:
//name: 25, 50, 75, 100, 200, Drive, Stop, Gas, OutOfFuel, SpareTire, FlatTire, EndSpeedLimit, SpeedLimit, Repairs, Accident
//type: attack, remedy, mile
//location_class: relevant css classes (eg. UserCard1)
//availableToDraw: true, false
function card(name, type, location_class, availableToDraw) {
    this.name = name;
    this.type = type;
    this.location_class = location_class;
    this.availableToDraw = availableToDraw;
}