<?php   
    session_start(); 
    include 'dbConnect.php';
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
        <select class="dropdown">
            <option name="classification" value="default">Choose category</option>
            <option name="classification" value="urgent">This is urgent</option>
            <option name="classification" value="regular">Regular task</option>
            <option name="classification" value="goal">This is a goal</option>
        </select>
        <select class="dropdown">
            <option name="difficulty" value="default">Choose difficulty</option>
            <option name="difficulty" value="easy">Easy</option>
            <option name="difficulty" value="medium">Medium</option>
            <option name="difficulty" value="hard">Hard</option>
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
                    //check if there is a due date
                    if ($row["date_due"] != NULL) {
                        echo " - Due " . $row["date_due"];
                    }       
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
                echo "<li>There are no tasks due in the next 7 days</li>";
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
            ev.target.classList.toggle('checked');
        }
    }, false);
</script>
     
</body>
</html> 
