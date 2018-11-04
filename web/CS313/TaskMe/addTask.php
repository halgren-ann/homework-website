<?php
    session_start();
    $color = $_SESSION["color"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMe</title>
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <link href="whole-styles.css" rel="stylesheet">
</head>
<body>
    <div class="centered">
        <br><br><br><br><br><br>
        <form action="addTaskToDB.php" method="post">
            <input size="75%" type="text" name="task" placeholder="Enter the main task here" required><br><br>
            <input size="50%" type="text" name="subtask1" placeholder="Enter optional subtask or step"><br><br>
            <input size="50%" type="text" name="subtask2" placeholder="Enter optional subtask or step"><br><br>
            <input size="50%" type="text" name="subtask3" placeholder="Enter optional subtask or step"><br><br>
            <input size="50%" type="text" name="subtask4" placeholder="Enter optional subtask or step"><br><br>
            <select name="classification" class="dropdown">
                <option value="default">Choose category</option>
                <option value="urgent">This is urgent</option>
                <option value="regular">Regular task</option>
                <option value="goal">This is a goal</option>
            </select>
            <br><br>
            <select name="difficulty" class="dropdown">
                <option value="default">Choose difficulty</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
            <br><br>
            <label>Optional: Due Date</label><br>
            <input type="number" name="date_due_month" style="width:30%" placeholder="Enter month MM" maxlength=2 pattern="[0-9]{2}" min="01" max="12">
            <input type="number" name="date_due_day" style="width:30%" placeholder="Enter day DD" maxlength=2 pattern="[0-9]{2}" min="01" max="31">
            <input type="number" name="date_due_year" style="width:30%" placeholder="Enter year YYYY" maxlength=4 pattern="[0-9]{4}"><br><br>
            <input type="submit" style="width:100%">
        </form>
    </div>
    <div class="titleArea">
        <h1>TaskMe</h1>
    </div>

    <script>
        document.body.background = <?php echo $color;?>;
    </script>
     
</body>
</html> 
