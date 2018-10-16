<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
<style>
body {
    font-family: Arial;
    color: white;
    background-color: #257;
}

.split {
    height: 100%;
    width: 50%;
    position: fixed;
    z-index: 1;
    top: 0;
    overflow-x: hidden;
    padding-top: 100px;
}

.left {
    left: 0;
}

.right {
    right: 0;
}

.centered {
    position: absolute;
    left: 50%;
    transform: translate(-50%, 0%);
    text-align: center;
}

.centered img {
    width: 150px;
    border-radius: 30%;
}

button {
	width: 100%;
    background-color: lightgray;
    color: black;
    padding: 16px;
    font-size: 16px;
    cursor: pointer;
}

.titleArea {
	color: chocolate;
    font-family: 'Yesteryear', cursive;
	min-width: 250px; /* Set a default minimum width */
    margin-left: -125px; /* Divide value of min-width by 2 */
    text-align: center; /* Centered text */
    position: fixed; /* Sit on top of the screen */
    z-index: 1; /* Add a z-index if needed */
    left: 50%; /* Center the snackbar */
    top: 15px; /* 30px from the bottom */
}

.dropdown {
    position: relative;
    display: inline-block;
    width: 100%;
}

.dropdown a:hover {background-color: #ddd;}

a {
	text-decoration: none;
}

.bordered {
	border: 5px solid black;
    padding-left: 15px;
}

</style>
</head>
<body>

<div class="split left">
  <div class="centered">
    <button><a href="">Add Task</a></button>
    <button><a href="">See tasks due in the next 7 days</a></button>
    <button><a href="">See all tasks</a></button>
    <br><br>
    <p>Filter to view tasks:</p>
   	<select class="dropdown">
      <option value="default">Choose category</option>
      <option value="urgent">This is urgent</option>
      <option value="regular">Regular task</option>
      <option value="goal">This is a goal</option>
	</select>
    <select class="dropdown">
      <option value="default">Choose difficulty</option>
      <option value="easy">Easy</option>
      <option value="medium">Medium</option>
      <option value="hard">Hard</option>
	</select>
    <br><br>
    <button type="submit">Go</button>
  </div>
</div>

<div class="split right">
  <div class="bordered">
    <h2>Recently added tasks:</h2>
    <hr style="color: black">
    <input type="checkbox" name="task1" value=""> I have a bike<br>
    <input type="checkbox" name="task2" value=""> I have a car<br>
    <input type="checkbox" name="task3" value=""> I have a boat<br>
    <input type="checkbox" name="task4" value=""> I have a bike<br>
    <input type="checkbox" name="task5" value=""> I have a car<br>
    
  </div>
</div>

<div class="titleArea">
  <h1><span style="font-family: 'Caveat', cursive;">Hello, Ann - </span>TaskMe</h1>
</div>
     
</body>
</html> 
