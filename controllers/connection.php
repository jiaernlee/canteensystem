<?php

$cn = mysqli_connect("localhost","root","","canteen_system");

// check connecting
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL:". mysqli_connect_error();
    die();
} ;
