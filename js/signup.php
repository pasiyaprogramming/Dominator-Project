<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Google Recaptcha CDN-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Signup Here</title>
</head>

<div class="pt-5">
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <div id="error-msg" class="alert alert-danger mb-3" role="alert"></div>
                <div id="success-msg" class="alert alert-success mb-3" role="alert"></div>
                <h3 class="card-title text-center"> Signup Here! </h3>
                <div class="card-text">
                    <form id="registraion_form" action="signup-process.php" method="post" name="reg-form">
                        <div class="form-group">
                            <label for="txt_username">Your Name</label>
                            <input type="text" name="uname" class="form-control form-control-sm mb-2" id="txt_username" required>
                        </div>
                        <div class="form-group">
                            <label for="txt_email">Email address</label>
                            <input type="email" name="email" class="form-control form-control-sm mb-2" id="txt_email" required>
                        </div>
                        <div class="form-group">
                            <label for="txt_password">Password</label>
                            <input type="password" name="psw" class="form-control form-control-sm mb-2" id="txt_password" required>
                        </div>
                        <div class="form-group">
                            <label for="txt_cpassword">Confirm Password</label>
                            <input type="password" name="cpsw" class="form-control form-control-sm mb-3" id="txt_cpassword" required>
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="your-site-key" data-callback="enableBtn"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" disabled="disabled" id="btn_register"><i class="fa fa-lock"></i> Sign up</button>

                        <div class="sign-up">
                            Are you already have an account? <a href="login_form.php"> Login Here </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Bootstap & jQuery CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        //check recaptcha is verified and submit button will enabled
        function enableBtn() {
            document.getElementById("btn_register").disabled = false;
        }
    </script>

    <script>
        //define function
        $(function() {
            //error alers hide from the front-end
            $("#error-msg").hide();
            $("#success-msg").hide();

            $('#btn_register').click(function(e) {

                let self = $(this);

                e.preventDefault(); // prevent default submit behavior


                var data = $('#registraion_form').serialize(); // get form data
                // sending ajax request to signup-process.php file, it will process login request and give response.
                $.ajax({
                    url: 'signup-process.php',
                    type: "POST",
                    data: data,
                }).done(function(res) {
                    res = JSON.parse(res);
                    if (res['status']) // if login successful redirect user to login_form.php page.
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

                        // storing url and time
                        let delay = 2800;
                        let url = "http://localhost/login2/login_form.php";
                        setTimeout(function() {
                            location = url;
                        }, 2800)

                        let timeout = 3000;
                        setTimeout(function() {
                            $("#error-msg").hide();
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
                        $("#error-msg").show(); // show it on the browser, default state, hide
                        // remove disable attribute to the login button, 
                        //to prevent multiple form submissions 
                        //we have added this attribution on login from submit
                        let delay = 2800;
                        setTimeout(function() {
                            $("#error-msg").hide();
                        }, 2800)
                    }
                }).fail(function() {
                    alert("error");
                }).always(function() {
                    self.prop('disabled', false);
                });
            });
        });
    </script>