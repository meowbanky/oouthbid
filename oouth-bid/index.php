<?php
//session_destroy();
session_start();
session_unset();

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>OOUTH BID</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!--
      CSS
      =============================================
    -->

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/jquery-1.10.2.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


</head>

<body>
    <section class="home-banner-area">
        <div class="logooouth">
            <img src="img/zzpng.png" style="
            height: 100pt;
        ">
        </div>
        <div class="container" style="
        margin-right: 1px;
    ">

            <div class="row justify-content-center fullscreen align-items-center">
                <div class="col-lg-5 col-md-8 home-banner-left">
                    <h1 class="text-white">
                        OOUTH<br>BID<br>MANAGEMENT<br>SYSTEM
                        <br/>
                    </h1>
                    <p class="mx-auto text-white  mt-20 mb-40"></p>
                        <!--In the history of modern astronomy, there is probably no one greater leap forward than the building and launch of the space telescope known as the Hubble.
                    </p>-->
                </div>
                <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
                    <img class="img-fluid" src="img/header-img.png" alt="" />
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End banner Area ================= -->

    <div class="container-fluid">
        <div class="feature-inner row">
            <div class="col-lg-2 col-md-6">
                <div class="feature-item d-flex">

                    <div class="ml-20">
                        <h1>Log In

                        </h1>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="course-form-section">
        <h3 class="text-white">Courses for Free</h3>
        <p class="text-white">It is high time for learning</p>
        <form id="form1" action="" method="POST">

        <!-- NAME -->
        <div id="name-group" class="form-group">
            <label for="Username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username">
            <!-- errors will go here -->
        </div>

        <!-- EMAIL -->
        <div id="email-group" class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="password">
            <!-- errors will go here -->
        </div>

        

        <button type="submit" class="btn btn-success">Submit <span class="fa fa-arrow-right"></span></button>
        <div id="InvalidCredentials" class="form-group"></div>
    </form>
    </div>



<!---
    <section class="registration-area">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-5" style="
                padding-bottom: 150px;
            ">
                    <div class="section-title text-left text-white" style="display:hidden">
                        <h2 class="text-white">
                            Forgot Password??? <br>
                            <a href="#" class="genric-btn primary circle arrow">Click Here<span class="lnr lnr-arrow-right"></span></a>
                        </h2>

                    </div>
                </div>
                <div class="offset-lg-3 col-lg-4 col-md-6" style="
                padding-bottom: 250px;
            ">
                    <div class="course-form-section">
                        <h3 class="text-white">Sign up Here</h3>
                        <p class="text-white">If you are a new user</p>


                        <div class="col-lg-12 text-center">
                            <a href="signup.html"><button class="btn text-uppercase">SIGN UP</button></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
---->



    Copyright &copy; OOUTH ICT, SAGAMU, OGUN STATE, NIGERIA 2020

</body>
<script>
$(document).ready(function() {

    // process the form
    $('#form1').submit(function(event) {
        event.preventDefault();
    $('.form-group').removeClass('has-error'); // remove the error class
    $('.help-block').remove(); // remove the error text
        
        $('#form1').removeClass('alert alert-success');
        
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'username'              : $('input[name=username]').val(),
            'password'             : $('input[name=password]').val()
        };

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'pro.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data); 

                // here we will handle errors and validation messages
        if ( ! data.success) {

            // handle errors for name ---------------
            if (data.errors.name) {
                $('#name-group').addClass('has-error'); // add the error class to show red input
                $('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // add the actual error message under our input
            }

            // handle errors for email ---------------
            if (data.errors.password) {
                $('#email-group').addClass('has-error'); // add the error class to show red input
                $('#email-group').append('<div class="help-block">' + data.errors.password + '</div>'); // add the actual error message under our input
            }
            if (data.errors.InvalidCredentials) {
                $('#InvalidCredentials').addClass('has-error'); // add the error class to show red input
                $('#InvalidCredentials').append('<div class="help-block">' + data.errors.InvalidCredentials + '</div>'); // add the actual error message under our input
                }
            if (data.errors.FirstLogin) {
               $('#form1').append('<div class="alert alert-success">' + data.message + '</div>');

            // usually after form submission, you'll want to redirect
             window.location = 'changePassword.php'; // redirect a user to another page
            //alert('success'); // for now we'll just alert the user
                }
            // handle errors for superhero alias ---------------
            

        } else {

            // ALL GOOD! just show the success message!
            $('#form1').append('<div class="alert alert-success">' + data.message + '</div>');

            // usually after form submission, you'll want to redirect
             window.location = 'home.php'; // redirect a user to another page
            //alert('success'); // for now we'll just alert the user

        }

    });   
        });

        // stop the form from submitting the normal way and refreshing the page
        
    })
// using the fail promise callback
    .fail(function(data) {

        // show any errors
        // best to remove for production
        console.log(data);
    });

    
</script>
</html>