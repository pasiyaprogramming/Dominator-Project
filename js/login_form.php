<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>

<div class="pt-5">
    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <div id="error-msg" class="alert alert-danger mb-3" role="alert"></div>
                <h3 class="card-title text-center"> Welcome Back! </h3>
                <div class="card-text">
                    <form id="login-form" action="login.php" method="post" name="login-form">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control form-control-sm mb-3" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" name="psw" class="form-control form-control-sm mb-3" id="Password" required>
                        </div>
                        <button type="submit" id="login" class="btn btn-primary btn-block"><i class="fa fa-sign-in"></i> Sign in</button>

                        <div class="sign-up">
                            Don't have an account? <a href="signup.php"> Sign Up </a>
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
        //define function
        $(function() {
            //error alers hide from the front-end
            $("#error-msg").hide();
            $('#login').click(function(e) {

                let self = $(this);

                e.preventDefault(); // prevent default submit behavior

                self.prop('disabled', true);

                var data = $('#login-form').serialize(); // get form data

                // sending ajax request to login.php file, it will process login request and give response.
                $.ajax({
                    url: 'login.php',
                    type: "POST",
                    data: data,
                }).done(function(res) {
                    res = JSON.parse(res);
                    if (res['status']) // if login successful redirect user to secure.php page.
                    {
                        location.href = "dashboard.php"; // redirect user to dashboard.php location/page.
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
                        let timeout = 3000;
                        setTimeout(function() {
                            $("#error-msg").hide();
                        }, 3000)
                        self.prop('disabled', false);
                    }
                }).fail(function() {
                    alert("error");
                }).always(function() {
                    self.prop('disabled', false);
                });
            });
        });
    </script>