<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMe</title>
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
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
    <hr>
    <ul>
        <li>Hit the gym - Due Date</li>
        <li>Pay bills</li>
        <li>Meet George - Due Date</li>
        <li>Buy eggs</li>
        <li>Read a book</li>
        <li>Organize office</li>
    </ul>
    
  </div>
</div>

<div class="titleArea">
  <h1><span style="font-family: 'Caveat', cursive;">Hello, Ann - </span>TaskMe</h1>
</div>


<script>
    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
        if (ev.target.tagName === 'LI') {
            ev.target.classList.toggle('checked');
        }
    }, false);
</script>
     
</body>
</html> 
