<!DOCTYPE html>
<html lang="en">
<head>
  <title>Family Discovery Day Admin Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
        <li><a data-toggle="tab" href="#emailattendees">Email Attendees</a></li>
        <li><a data-toggle="tab" href="#editclasses">Edit Classes</a></li>
        <li><a data-toggle="tab" href="#addsubadmins">Add Sub-Admins</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <ul class="nav nav-pills nav-stacked">
      <li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
        <li><a data-toggle="tab" href="#emailattendees">Email Attendees</a></li>
        <li><a data-toggle="tab" href="#editclasses">Edit Classes</a></li>
        <li><a data-toggle="tab" href="#addsubadmins">Add Sub-Admins</a></li>
      </ul><br>
    </div>
    <br>
    

    <div class="tab-content">

        <div id="dashboard" class="container tab-pane fade in active">
            <div class="col-sm-9">
            <div class="well">
                <h4>Dashboard</h4>
                <p>This page contains summarizing numbers for the event as a whole.</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                <div class="well">
                    <h4>Attendees</h4>
                    <p>eg 200</p> 
                </div>
                </div>
                <div class="col-sm-6">
                <div class="well">
                    <h4>Classes</h4>
                    <p>eg 12</p> 
                </div>
                </div>
            </div>

            <div class="row">
            <div class="col-sm-12">
                <div class="well">
                <div class="table-responsive">
                <table class="table">
                <colgroup>
                    <col span="1" class="bg-success"></col>
                    <col span="1" class="bg-info"></col>
                    <col span="1" class="bg-warning"></col>
                    <col span="4"></col>
                </colgroup>
                    <thead>
                    <tr>
                        <th>Email Class</th>
                        <th>Edit Class</th>
                        <th># of Attendees</th>
                        <th>Class</th>
                        <th>Time</th>
                        <th>Presenter</th>
                        <th>Brief Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><button><a data-toggle="tab" href=#emailattendees>Email Class</a></button></td>
                        <td><button><a data-toggle="tab" href=#editclasses>Edit Class</a></button></td>
                        <td>eg 13</td>
                        <td>Intro to Family Search</td>
                        <td>10:00am</td>
                        <td>John Halgren</td>
                        <td>This is a brief description of the material that will be covered</td>
                    </tr>
                    <tr>
                        <td><button><a data-toggle="tab" href=#emailattendees>Email Class</a></button></td>
                        <td><button><a data-toggle="tab" href=#editclasses>Edit Class</a></button></td>
                        <td>eg 13</td>
                        <td>Intro to Family Search</td>
                        <td>10:00am</td>
                        <td>John Halgren</td>
                        <td>This is a brief description of the material that will be covered</td>
                    </tr>
                    <tr>
                        <td><button><a data-toggle="tab" href=#emailattendees>Email Class</a></button></td>
                        <td><button><a data-toggle="tab" href=#editclasses>Edit Class</a></button></td>
                        <td>eg 13</td>
                        <td>Intro to Family Search</td>
                        <td>10:00am</td>
                        <td>John Halgren</td>
                        <td>This is a brief description of the material that will be covered</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                </div> 
            </div>
            </div>
            
            </div>
        </div>
    



        <div id="emailattendees" class="container tab-pane fade in">
            <div class="col-sm-9">
            <div class="well">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Class 
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">Class 1</a></li>
                    <li><a href="#">Class 2</a></li>
                    <li><a href="#">Class 3</a></li>
                    <li class="divider"></li>
                    <li><a href="#">All Classes</a></li>
                </ul>
            </div>
            <br/>
            <form action="/action_page.php">
                <label for="emailcontent">Email Content:</label>
                <br/>
                <textarea class="form-control" id="emailcontent" name="emailcontent" rows="6" required></textarea>
                <br><br>
                <input type="submit" value="Send Email">
            </form>

            </div>
            </div>
        </div>






        <div id="editclasses" class="container tab-pane fade in">
            <div class="col-sm-9">
                <div class="well">
                <button class="bg-success">Add New Class</button>
                <br/><br/>
                <p>OR</p>

                <div class="dropdown">
                    <button class="bg-info btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Class 
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Class 1</a></li>
                        <li><a href="#">Class 2</a></li>
                        <li><a href="#">Class 3</a></li>
                    </ul>
                </div>
                <br/>
                
                <button class="bg-danger">Delete Class</button>
                <br/><br/>
                <p>OR</p>

                <div class="dropdown">
                    <button class="bg-info btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Choose Area to Edit 
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Class Name</a></li>
                        <li><a href="#">Time</a></li>
                        <li><a href="#">Presenter</a></li>
                        <li><a href="#">Description</a></li>
                    </ul>
                </div>
                <br/>

                <form action="/action_page.php">
                    <label for="emailcontent">New Text:</label>
                    <br/>
                    <textarea class="form-control" id="emailcontent" name="emailcontent" rows="2" required></textarea>
                    <br>
                    <input type="submit" class="bg-warning" value="Update/Change">
                </form>

                </div>
            </div>
        </div>
  



  
        <div id="addsubadmins" class="container tab-pane fade in">
            
        </div>
    
    
    
    
    
    </div>
  </div>
</div>

</body>
</html>
