<?php   
    session_start(); 
    include 'dbConnect.php';
    include 'cleanupDB.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMe</title>
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <link href="split-styles.css" rel="stylesheet">
</head>
<body>

<div class="split left">
  <div class="centered">
    <a href="addTask.php"><button>Add Task</button></a>
    <form action="viewTasks.php" method="POST">
        <input type="hidden" name="callType" value="dueIn7">
        <button type="submit">See tasks due in the next 7 days</button>
    </form>
    <form action="viewTasks.php" method="POST">
        <input type="hidden" name="callType" value="seeAll">
        <button type="submit">See all tasks</button>
    </form>
    <br><br>
    <p>Filter to view tasks:</p>
    <form action="viewTasks.php" method="POST">
        <select name="classification" class="dropdown">
            <option value="default">Choose category</option>
            <option value="urgent">This is urgent</option>
            <option value="regular">Regular task</option>
            <option value="goal">This is a goal</option>
        </select>
        <select name="difficulty" class="dropdown">
            <option value="default">Choose difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <br><br>
        <button type="submit">Go</button>
    </form>
  </div>
</div>

<div class="split right">
  <div class="bordered">
    <h2>Recently added tasks:</h2>
    <hr>
    <ul>
        <?php 
            //Get the 5 most recently added tasks
            $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id ORDER BY date_added DESC LIMIT 5;');
            $stmt->execute(array(':user_id' => $_SESSION["user_id"]));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows[0]) {
                foreach ($rows as $row) {
                    //For each task
                    echo "<li>" . $row["task_text"];
                           
                    //check for subtasks associated with this task
                    $stmt = $db->prepare('SELECT * FROM public.subtask WHERE task_id = :task_id');
                    $stmt->execute(array(':task_id' => $row["id"]));
                    $subrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($subrows[0]) {
                        echo "<ul>";
                        foreach ($subrows as $subrow) {
                            //For each subtask
                            echo "<li>" . $subrow["task_text"] . "</li>";
                        }
                        echo "</ul>";
                    }
                    
                    echo "</li>";
                }
            }
            else {
                echo "<li>You have no recent tasks.</li>";
            }
        ?>
    </ul>
    
    </div>
        <p>Click on a task when it is completed and it will be removed when the page is reloaded.</p>
    </div>

<div class="titleArea">
  <h1><span style="font-family: 'Caveat', cursive;">Hello, 
  <?php  
    $stmt = $db->prepare('SELECT * FROM public.user WHERE id = :id');
    $stmt->execute(array(':id' => $_SESSION["user_id"]));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows[0]) {
        echo $rows[0]["first_name"];
    }
  ?> 
  - </span>TaskMe</h1>
</div>


<script>
    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
        if (ev.target.tagName === 'LI') {
            ev.target.classList.add('checked');
            //change the database item is_complete with this information
            isChecked(ev.target.textContent);
        }
    }, false);

    function isChecked(task_text) {
        var httpc = new XMLHttpRequest(); // simplified for clarity
        var url = "isChecked.php";
        httpc.open("POST", url, true); // sending as POST

        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        httpc.setRequestHeader("Content-Length", task_text.length); // POST request MUST have a Content-Length header (as per HTTP/1.1)

        httpc.onreadystatechange = function() { //Call a function when the state changes.
            if(httpc.readyState == 4 && httpc.status == 200) { }
        }
        httpc.send(task_text);
    }
</script>
     
</body>
</html> 
