<?php
    $title = "Register";
    function get_content() {
?>

<head>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<div class="row d-flex justify-content-center align-items-center mt-0">
    <div class="col-md-6"></div>
    <div class="col-md-6 p-3 head rounded-3">
        <h1>Register</h1>
        <div class="row">
            <div class="col-md-6 my-5">
                <form method="POST" action="/controllers/users/process_register.php" class="mb-5">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Confirm Password" name="password2">
                    <label for="floatingPassword">Confirm Password</label>
                </div>
                <button class="btn btn-outline-primary">Register</button>
                <a href="/"  class="btn btn-outline-success">Back</a>
                </form>
            </div>
        </div>       
    </div>
</div>

    

<?php
    };
    require_once '../template/layout.php';
?>