<?php
require_once 'auth.php'; //check user sign in
require_once 'header.php'; //header file
?>


<!--css file-->
<link rel="stylesheet" href="css/login.css">
<!--form-->
<div class="pt-5">
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <div id="error-msg" class="alert alert-danger mb-3" role="alert"></div>
                <div id="success-msg" class="alert alert-success mb-3" role="alert"></div>
                <h3 class="card-title text-center"> Change Your Password! </h3>
                <div class="card-text">
                    <form id="login-form" action="change_pass_process.php" method="post" name="login-form">
                        <div class="form-group">
                            <label for="txt_password">New Password</label>
                            <input type="password" name="psw" class="form-control form-control-sm mb-3" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="txt_cpassword">Confirm New Password</label>
                            <input type="password" name="cpsw" class="form-control form-control-sm mb-3" id="cpassword" required>
                        </div>
                        <button type="submit" id="change" class="btn btn-success btn-block">Change</button>
                        <button type="submit" id="cancel" class="btn btn-danger btn-block">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/form-->

    <script>
        //define function
        $(function() {

            //error alers hide from the front-end
            $("#error-msg").hide();
            $("#success-msg").hide();

            //cancel button process
            $('#cancel').click(function() {

                window.location.href = 'dashboard.php'; //redirect to dashbord

            })
            //Ajax Process when click change button
            $('#change').click(function(e) {

                let self = $(this);

                e.preventDefault(); // prevent default submit behavior


                var data = $('#login-form').serialize(); // get form data

                // sending ajax request to login.php file, it will process login request and give response.
                $.ajax({
                    url: 'change_pass_process.php',
                    type: "POST",
                    data: data,
                    cache: false,
                }).done(function(res) {
                    res = JSON.parse(res);
                    if (res['status']) // if login successful redirect user to secure.php page.
                    {
                        var errorMessage = '';
                        // if there is any errors convert array of errors into html string, 
                        //here we are wrapping errors into a paragraph tag.
                        console.log(res.msg);
                        $.each(res['msg'], function(index, message) {
                            errorMessage += '<div>' + message + '</div>';
                        });
                        // place the errors inside the div#error-msg.
                        $("#success-msg").html(errorMessage);
                        $("#success-msg").show();

                        let delay = 2800; //timer

                        //automatically hide message
                        setTimeout(function() {
                            $("#success-msg").hide();
                        }, 2800)

                        let url = 'dashboard.php';
                        let timeout = 3000;
                        setTimeout(function(redirect) {
                            location = url; // redirect user to dashboard.php location/page.
                        }, 3000)
                    } else {

                        var errorMessage = '';
                        // if there is any errors convert array of errors into html string, 
                        //here we are wrapping errors into a paragraph tag.


                        console.log(res.msg);
                        $.each(res['msg'], function(index, message) {
                            errorMessage += '<div>' + message + '</div>';
                        });

                        // place the errors inside the div#error-msg.
                        $("#error-msg").html(errorMessage);
                        $("#error-msg").show();
                        // show it on the browser, default state, hide
                        // remove disable attribute to the login button, 
                        //to prevent multiple form submissions 
                        //we have added this attribution on login from submit
                        self.prop('disabled', false);
                        //automatically hide message
                        setTimeout(function() {
                            $("#error-msg").hide();
                        }, 3000)
                    }

                }).fail(function() {
                    alert("error");
                }).always(function() {
                    self.prop('disabled', false);
                });
            });
        });
    </script>