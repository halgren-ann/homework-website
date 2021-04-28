<!DOCTYPE html>
<html lang="en">
<head>
  <title>Event Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    .carousel-inner img {
      width: 100%; /* Set width to 100% */
      min-height: 200px;
    }

    /* Hide the carousel text when the screen is less than 600 pixels wide */
    @media (max-width: 600px) {
      .carousel-caption {
        display: none; 
      }
    }

    .signup-form .btn {        
        font-size: 16px;
        font-weight: bold;		
        min-width: 140px;
        outline: none !important;
    }
    .signup-form .row div:first-child {
        padding-right: 10px;
    }
    .signup-form .row div:last-child {
        padding-left: 10px;
    }    	
    .signup-form a {
        color: #fff;
        text-decoration: underline;
    }
    .signup-form a:hover {
        text-decoration: none;
    }
    .signup-form form a {
        color: #5cb85c;
        text-decoration: none;
    }	
    .signup-form form a:hover {
        text-decoration: underline;
    }

    .login-form {
        width: 340px;
        margin: 50px auto;
        font-size: 15px;
    }
    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
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
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#registration">Registration</a></li>
        <li><a data-toggle="tab" href="#faqs">FAQs</a></li>
        <li><a data-toggle="tab" href="#contact">Contact</a></li>
        <!--Only include these if they are logged in-->
        <li><a data-toggle="tab" href="#myeventschedule"><mark>My Event Schedule</mark></a></li>
        <li><a data-toggle="tab" href="#myaccount">My Account</a></li>
        <!--//-->
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<!--Only include this next one if they are NOT logged in-->
      	<li><a data-toggle="tab" href="#createaccount">Create Account</a></li>
        <li><a data-toggle="tab" href="#login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="tab-content">
<div id="home" class="container tab-pane fade in active">
<div class="row">
  <div class="col-sm-8">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="family-pic.jpg" alt="Image">
          <div class="carousel-caption">
            <h3>Family Discovery Day!</h3>
            <p>Come discover more about the roots of your family tree - where and how they lived, what challenges they had to overcome, and what brought them joy.</p>
          </div>      
        </div>

        <div class="item">
          <img src="family-circle.jpg" alt="Image">
          <div class="carousel-caption">
            <h3>Become More Connected</h3>
            <p>Past, Present, and Future</p>
          </div>      
        </div>
      </div>
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="well">
      <p>Click the Menu item in the upper right to get more information on this exciting free conference and how to sign up.</p>
    </div>
    <div class="well">
       <p>Upcoming Events...</p>
       <div class="well">Family Discovery Day, October 15, 2021
           <button>Sign Up</button>
       </div>
    </div>
  </div>
</div>
<hr>
</div>

<div id="registration" class="container tab-pane fade">
  <h2>Family Discovery Day Schedule</h2>
  <p>This schedule includes the initial welcome and keynote address, the classes offered, and the list of unscheduled booths available in the culteral hall.</p>
  <p>First, create an account or login, and then you will be able to sign up for classes and "favorite" booths you want to make sure to see.</p>
  <p>Click the checkboxes next to the classes you would like to sign up for and the booths you want to make sure to see. After clicking "SAVE", you will be sent an email with more information.</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th> <!--checkboxes-->
        <th>Class</th>
        <th>Time</th>
        <th>Presenter</th>
        <th>Brief Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="checkbox" name="checkbox1"></td>
        <td>Intro to Family Search</td>
        <td>10:00am</td>
        <td>John Halgren</td>
        <td>This is a brief description of the material that will be covered</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="checkbox2"></td>
        <td>Intro to Family Search</td>
        <td>10:00am</td>
        <td>John Halgren</td>
        <td>This is a brief description of the material that will be covered</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="checkbox3"></td>
        <td>Intro to Family Search</td>
        <td>10:00am</td>
        <td>John Halgren</td>
        <td>This is a brief description of the material that will be covered</td>
      </tr>
    </tbody>
  </table>
  
  <br/>
  <p>Booths (Available in the Cultural Hall)</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th> <!--checkboxes-->
        <th>Booth</th>
        <th>Brief Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="checkbox" name="checkbox3"></td>
        <td>Indexing</td>
        <td>Come learn about indexing digital records</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="checkbox4"></td>
        <td>Indexing</td>
        <td>Come learn about indexing digital records</td>
    </tr>
    </tbody>
  </table>

  <Button>SAVE</button>
<hr>
</div>



<div id="faqs" class="container tab-pane fade">
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        Can I get a free account to FamilyTree?</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">Yes. Include details about how to do that.</div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        What if I don't know my grandfather's birthdate - can I still find information about him?</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">Answer that question here.</div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
        Do I have to sign up for an account here if I want to attend Family Discovery Day?</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">Answer that question here.</div>
    </div>
  </div>
</div>
<hr>
</div>



<div id="contact" class="container tab-pane fade">
  <div class="col-sm-12">
    <div class="well">
      <p>The following individuals are family history consultants for the Arvada Stake, and would love to help you with any questions you may have:</p>
      <p>John Doe</p>
      <p>Jane Doe</p>
    </div>
    <div class="well">
       <p>Email a family history consultant at youremail@example.com</p>
    </div>
  </div>
<hr>
</div>


<div id="myeventschedule" class="container tab-pane fade">
  <div class="col-sm-12">
    <div class="well">
        <h2>My Family Discovery Day Schedule</h2>
        <p>This schedule includes the initial welcome and keynote address, along with any classes you signed up for or booths you favorited.</p>
        <p>If you would like to change your selections, just revisit the Registration tab.</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Class</th>
                <th>Time</th>
                <th>Presenter</th>
                <th>Brief Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Intro to Family Search</td>
                <td>10:00am</td>
                <td>John Halgren</td>
                <td>This is a brief description of the material that will be covered</td>
            </tr>
            <tr>
                <td>Intro to Family Search</td>
                <td>10:00am</td>
                <td>John Halgren</td>
                <td>This is a brief description of the material that will be covered</td>
            </tr>
            <tr>
                <td>Intro to Family Search</td>
                <td>10:00am</td>
                <td>John Halgren</td>
                <td>This is a brief description of the material that will be covered</td>
            </tr>
            </tbody>
        </table>

        <p>Booths (Available in the Cultural Hall)</p>            
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Booth</th>
                <th>Brief Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Indexing</td>
                <td>Come learn about indexing digital records</td>
            </tr>
            <tr>
                <td>Indexing</td>
                <td>Come learn about indexing digital records</td>
            </tr>
            </tbody>
        </table>
    </div>
  </div>
<hr>
</div>



<div id="myaccount" class="container tab-pane fade">
  <div class="col-sm-12">
    <div class="well">
      <table class="table">
          <tr>
              <td>Your email:</td>
              <td>youremail@example.com</td>
              <td><button>Change</button></td>
          </tr>
          <tr>
              <td>Your password:</td>
              <td>examplepassword</td>
              <td><button>Change</button></td>
          </tr>
      </table>
    </div>
    <div class="well">
        <table class="table">
            <tr class="danger">
                <td>Delete your account:</td>
                <td>All your data will be deleteled, including your login credentials.</td>
                <td><button class="danger">Delete</button></td>
            </tr>
        </table>
    </div>
  </div>
<hr>
</div>




<div id="createaccount" class="container tab-pane fade">
<div class="signup-form">
    <form action="/examples/actions/confirmation.php" method="post">
		<h2>Create Account</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required"></div>
				<div class="col"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
        </div>
		<div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block">Register Now</button>
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="#">Sign in</a></div>
</div>
<hr>
</div>



<div id="login" class="container tab-pane fade">
    <div class="login-form">
        <form action="/examples/actions/confirmation.php" method="post">
            <h2 class="text-center">Log in</h2>       
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
            <div class="clearfix">
                <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
                <a href="#" class="float-right">Forgot Password?</a>
            </div>        
        </form>
        <p class="text-center"><a href="#">Create an Account</a></p>
    </div>
<hr>
</div>

<!--
<div id="classtablepane" class="container tab-pane fade">
  <h2>Striped Rows</h2>
  <p>The .table-striped class adds zebra-stripes to a table:</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
<hr>
</div>
-->






</div>
<br>
<footer class="container-fluid text-center">
  <p>Church of Jesus Christ, Arvada Stake, Family Discovery Day</p>
</footer>

</body>
</html>
