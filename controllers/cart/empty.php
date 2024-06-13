<?php

session_start();

unset($_SESSION['cart']);

header("Location: /views/pages/home.php");