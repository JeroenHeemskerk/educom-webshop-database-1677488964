<?php

function logUserIn($data)
{
    $_SESSION['username'] = $data['name'];
    $_SESSION['userid'] = $data['userid'];
}

function getLoggedInUserId()
{
    return $_SESSION['userid'];
}

function logUserOut()
{
    session_unset();
}

function isUserLoggedIn()
{
    return isset($_SESSION['username']);
}
