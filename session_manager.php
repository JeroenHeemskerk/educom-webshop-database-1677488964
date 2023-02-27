<?php

function logUserIn($data)
{
    $_SESSION['username'] = $data['name'];
}

function logUserOut()
{
    session_unset();
}
