<?php
/*
$secure = false; //https
$httponly = true;
// Force the session to only use cookies, not URL variables.
ini_set('session.use_only_cookies', 1);
// Get session cookie parameters 
$cookieParams = session_get_cookie_params(); 
// Set the parameters
session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
*/
session_start();
session_regenerate_id(true);
?>