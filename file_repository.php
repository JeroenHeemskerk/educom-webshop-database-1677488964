<?php

function findUserByEmail($email)
{
    $file = fopen('users/users.txt', 'r');
    $user = NULL;
    $line = fgets($file);

    while (!feof($file)) {
        $line = fgets($file);
        $user_data = explode("|", $line);
        if ($email === $user_data[0]) {
            $user = array("email" => $user_data[0], "name" => $user_data[1], "password" => $user_data[2]);
        }
    }
    fclose($file);
    return $user;
}

function saveUser($email, $name, $password)
{
    $file = fopen('users/users.txt', 'a');
    $newUser = $email . '|' . $name .  '|' . $password;
    fwrite($file, PHP_EOL . $newUser);
    fclose($file);
}
