<?php
require_once 'auth.php'; //check user sign in
require_once 'header.php'; //header file
?>

<!--style files-->
<style>
    .nav-item {
        margin-right: 5px;
    }

    h3 {
        text-align: center;
    }

    .box {
        border-style: solid;
        border-color: black;
        width: 35em;
        padding-top: 50px;
        padding-bottom: 50px;
        padding-right: 15px;
        padding-left: 15px;

    }
</style>
<!--/style files-->

<!--Dashboard UI-->
<div class="box position-absolute top-50 start-50 translate-middle">
    <h3>Your Account</h3>

    <ul class="nav justify-content-center mt-3">
        <li class="nav-item ">
            <button type="button" class="btn btn-danger "><a class="text-decoration-none text-white" href="delete_acc.php">Delete Account</a></button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-success"><a class="text-decoration-none text-white" href="change_pass.php">Change Password</a></button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-secondary"><a class="text-decoration-none text-white" href="logout.php">Logout</a></button>
        </li>
    </ul>
</div>
<!--/Dashboard UI-->