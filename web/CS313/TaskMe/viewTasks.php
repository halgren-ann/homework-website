<?php
    session_start();
    include 'dbConnect.php';
    include 'cleanupDB.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TaskMe</title>
    <link rel="stylesheet" type="text/css" href="whole-styles.css">
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
  </head>
  <body>
        <br><br><br><br><a href="TaskMe.php"><button>Home</button></a>
        <br><br><a href="addTask.php"><button>Add Task</button></a><br><br>

        <ul>
        <?php
            if ($_POST["callType"] != NULL) { 
                if ($_POST["callType"] == "dueIn7") {
                    //I got here because they want to view tasks due in the next 7 days
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id AND date_due >= :today ORDER BY date_due ASC;');
                    $stmt->execute(array(':user_id' => $_SESSION["user_id"], ':today' => date('Y-m-d')));
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
                }
                else if ($_POST["callType"] == "seeAll") {
                    //I got here because they want to view all the tasks they have
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id;');
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
                        echo "<li>You currently have no tasks!</li>";
                    }
                }
                else {
                    //something weird is going on, go home
                    echo "<script type='text/javascript'>window.location = 'TaskMe.php';</script>";
                    die();
                }
            }
            else if ($_POST["classification"] != NULL) {
                //I got here because the "Go" button was pressed
                if ($_POST["classification"] == "default" && $_POST["difficulty"] == "default") {
                    //Scenario 1: Values were not chosen on either drop-down menu. So just show all tasks.
                    //I got here because they want to view all the tasks they have
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id;');
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
                        echo "<li>You currently have no tasks!</li>";
                    }
                }
                else if ($_POST["classification"] != "default" && $_POST["difficulty"] == "default") {
                    //Scenario 2: A value was chosen for classification, but not for difficulty
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id AND classification = :classification;');
                    $stmt->execute(array(':user_id' => $_SESSION["user_id"], ':classification' => $_POST["classification"]));
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
                        echo "<li>You currently have no tasks in that category.</li>";
                    }
                }
                else if ($_POST["classification"] == "default" && $_POST["difficulty"] != "default") {
                    //Scenario 2: A value was  chosen for difficulty, but not for classification
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id AND difficulty = :difficulty;');
                    $stmt->execute(array(':user_id' => $_SESSION["user_id"], ':difficulty' => $_POST["difficulty"]));
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
                        echo "<li>You currently have no tasks in that category.</li>";
                    }
                }
                else {
                    //Scenario 4: Both classification and difficulty were selected
                    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id AND difficulty = :difficulty AND classification = :classification;');
                    $stmt->execute(array(':user_id' => $_SESSION["user_id"], ':difficulty' => $_POST["difficulty"], 'classification' => $_POST["classification"]));
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
                        echo "<li>You currently have no tasks in that make those criteria.</li>";
                    }
                }

            }
            else {
                //go home
                echo "<script type='text/javascript'>window.location = 'TaskMe.php';</script>";
                die();
            }
        ?>
        </ul>
            
        <div class="titleArea">
            <h1>TaskMe</h1>
        </div>

        <script>
            // Add a "checked" symbol when clicking on a list item
            var list = document.querySelector('ul');
            list.addEventListener('click', function(ev) {
                if (ev.target.tagName === 'LI') {
                    ev.target.classList.toggle('checked');
                    //change the database item is_complete with this information
                    alert("hi");
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

            function isNotChecked(task_text) {
                var httpc = new XMLHttpRequest(); // simplified for clarity
                var url = "isNotChecked.php";
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