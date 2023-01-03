<?php

/**
 * @file
 * Provides HTTP Basic Authentication when included.
 */

isset($_SERVER['PHP_AUTH_USER'])? $user = $_SERVER['PHP_AUTH_USER'] : $user = "";
isset($_SERVER['PHP_AUTH_PW'])? $pass = $_SERVER['PHP_AUTH_PW'] : $pass = "";

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="Bikalite Web Services"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You are not authorized";
    exit;
}
