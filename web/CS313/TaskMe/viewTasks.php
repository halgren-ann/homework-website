<?php
    session_start();
    include 'dbConnect.php';
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
                    //If I got here because they want to view tasks due in the next 7 days
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
                }
                else {
                    //something weird is going on
                }
            }
            else if ($_POST["classification"] != NULL) {

            }
            else if ($_POST["difficulty"] != NULL) {

            }
            else {
                //go home
            }
        ?>
        </ul>

        <ul>
            <li>Hit the gym - Due Date</li>
            <li>Pay bills
                <ul>
                    <li>Internet</li>
                    <li>Waste Management</li>
                    <li>Water</li>
                    <li>Electricity</li>
                </ul> 
            </li>
            <li>Meet George - Due Date</li>
            <li>Buy eggs</li>
            <li>Read a book</li>
            <li>Organize office</li>
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
                }
            }, false);
        </script>

  </body>
</html>