<?php
require 'assets/core/init.php';

if (loggedIn()) {
    $userId = $_SESSION['us3rid'];
    if ($user->logout()) {
        redirectTo('index.php');
    }
}
redirectTo('index.php');