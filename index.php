<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Welcome!</title>
    <!-- Bootstrap core CSS -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <link href="css/spage.css" rel="stylesheet">
    <script src="signin.js"></script>
</head>

<body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Travel Planner</a>
        </div>
    </nav>
    <!-- /container -->
    <div class="wide" style="background:background: #0099cc; background: -webkit-linear-gradient(left, #0099cc, #006080); background: -moz-linear-gradient(left, #0099cc, #006080); background: -ms-linear-gradient(left, #0099cc, #006080); background: -o-linear-gradient(left, #0099cc, #006080); background: linear-gradient(to right, #0099cc, #006080);">
        <div class="row">
            <div class="col-md-4 col-xs-1 line" style="padding-top: 30px">
                <hr>
            </div>
            <div class="col-md-4 col-xs-10 logo">
                <font color="white" size="6">Welcome</font>
            </div>
            <div class="col-md-4 col-xs-1 line" style="padding-top: 30px">
                <hr>
            </div>
        </div>
        <div class="row vertical-align">
            <div class="col-md-2 col-xs-1" align="center"></div>
            <div class="col-md-8 col-xs-10" align="center">
                <span style="color: white;font-size: 4vh;"></span>
            </div>
            <div class="col-md-2 col-xs-1" align="center"></div>
        </div>
    </div>
    <div align="center" style="position: relative;top: -12vh;">
        <div class="row" align="center">
            <div class="col-md-2"></div>
            <div class="col-md-8 col-xs-10 col-xs-offset-1 col-md-offset-0">
                <div class="jumbotron" style="box-shadow: 1px 1px 5px #888888;">
                    <div style="width:100%">
                    <form class="form-signin" id="account" visiblity="false">
                    <div>
                    <ul class="nav nav-tabs" style="margin-left:30%;font-size:2vh">
                      <li class="active take-all-space" style="width:30%;"><a href="#search" data-toggle="tab" >
                          <span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                      <li class="take-all-space" style="width:30%;"><a href="#open" data-toggle="tab" ><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    </ul>
                    </div>
                    <div class="tab-content" style="width:100%;">
                        <div class="tab-pane active" id="search">
                            <p style="font-size: 5vh;margin-top:3%;margin-bottom:2%;">Log In</p>
                            <br/>
                            <div class="row">
                                <div class="col-xs-1"></div>
                                <div class="col-xs-10">
                                    <p class="wrong-input" id="wrong-user" hidden></p>
                                  	  <!-- <label for="username" class="sr-only">Username</label> -->
                                  	  <input type="username" id="username" class="form-control" placeholder="Username" required autofocus>
                                  	  <!-- <label for="inputPassword" class="sr-only">Password</label> -->
                                  	  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required style="margin-top:2%;margin-bottom:2%;">
                                      <br/>
                                  	  <button class="btn btn-primary btn-block" onclick="login_func()" type="button">Login</button>

                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                            <br/>
                        </div>
                        <div class="tab-pane" id="open">
                            <p style="font-size: 5vh;margin-top:3%;margin-bottom:2%;">Sign Up</p>
                            <br/>
                            <div class="row">
                                <div class="col-xs-1"></div>
                                <div class="col-xs-10">
                                    <input type="name" id="entername" class="form-control" placeholder="Name" required>
                                 <!-- <label for="enterusername" class="sr-only">Username</label> -->
                                 <input type="username" id="enterusername" class="form-control" placeholder="Username" required style="margin-top:2%;">
                                   <p class="wrong-input" id="wrong-new-user" hidden></p>
                                 <!-- <label for="enterEmail" class="sr-only">Email address</label> -->
                                 <input type="text" id="enterEmail" class="form-control" placeholder="Email address" required style="margin-top:2%;">
                                   <p class="wrong-input" id="wrong-new-email" hidden></p>
                                 <!-- <label for="enterPassword" class="sr-only">Password</label> -->
                                 <input type="password" id="enterPassword" class="form-control" placeholder="Password" required style="margin-top:2%;margin-bottom:3%">
                                 <!-- <label for="enterContact" class="sr-only">Password</label> -->
                                 <br/>
                                 <button class="btn btn-primary btn-block" onclick="signup()" type="button">Sign Up</button>
                                </div>
                                <div class="col-xs-1"></div>
                            </div>
                            <br/>
                        </div>
                </div>
            </div>

        </div>
    </div>

</div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script>

</body>

</html>
