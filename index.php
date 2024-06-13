<?php
    $title = "Order your food";

    function get_content() {
        
?>
<head>
    <link rel="stylesheet" href="./css/style.css">
</head>

<div class="row d-flex justify-content-center align-items-center index-body mt-0">
    <div class="col-md-6"></div>
    <div class="col-md-6 p-3 head rounded-3">
        <h1>Order food</h1>
        <a href="/views/pages/login.php"  class="btn btn-outline-success">Login</a>
        <a href="/views/pages/register.php" class="btn btn-outline-warning">Register</a>        
    </div>
</div>


<?php
    }
    require_once './views/template/layout.php';
?>