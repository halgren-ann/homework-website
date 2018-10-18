<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TaskMe</title>
    <link rel="stylesheet" type="text/css" href="whole-styles.css">
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
  </head>
  <body>
        <br><br><br><button><a href="TaskMe.php">Home</a></button>
        <br><br><button><a href="addTask.php">Add Task</a></button>

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