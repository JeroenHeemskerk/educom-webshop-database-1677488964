<?php

include 'user_service.php';

// secure the user input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateEmail()
{

    $email = $emailErr = '';

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    return array('email' => $email, 'emailErr' => $emailErr);
}

function validateContact()
{
    // initate the variables     

    $name = test_input(getPostVar("name"));
    $email = test_input(getPostVar("email"));
    $phone = test_input(getPostVar("phone"));
    $salutation = test_input(getPostVar("salutation"));
    $contactOption = test_input(getPostVar("contactOption"));
    $message = test_input(getPostVar("message"));

    $nameErr = $emailErr = $phoneErr = $contactOptionErr = $messageErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate the 'POST' data
        if (empty($name)) {
            $nameErr = "Name is required";
        } else if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }

        // validateEmail();
        if (empty($email)) {
            $emailErr = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        if (empty($phone)) {
            $phoneErr = "Phone is required";
        }

        if (empty($contactOption)) {
            $contactOptionErr = "Contact option is required";
        }

        if (empty($message)) {
            $messageErr = "Message is required";
        }

        if (strcmp($nameErr, '') == 0 && strcmp($emailErr, '') == 0 && strcmp($phoneErr, '') == 0 && strcmp($contactOptionErr, '') == 0 && strcmp($messageErr, '') == 0) {
            $valid = true;
        };
    }

    return array("salutation" => $salutation, "name" => $name, "email" => $email, "phone" => $phone, "contactOption" => $contactOption, "message" => $message, "nameErr" => $nameErr, "emailErr" => $emailErr, "phoneErr" => $phoneErr, "contactOptionErr" => $contactOptionErr, "messageErr" => $messageErr, "valid" => $valid);
}

function validateRegistration()
{
    // initate the variables     
    $name = test_input(getPostVar("name"));
    $email = test_input(getPostVar("email"));
    $password = test_input(getPostVar("password"));
    $confirmPassword = test_input(getPostVar("confirmPassword"));

    $nameErr = $emailErr = $passwordErr = $confirmPasswordErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate the 'POST' data

        if (empty($name)) {
            $nameErr = "Name is required";
        } else if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }

        //validateEmail();
        if (empty($email)) {
            $emailErr = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        if (empty($password)) {
            $passwordErr = "Password is required";
        }

        if (empty($confirmPassword)) {
            $confirmPasswordErr = "Please repeat your password";
        } else if (strcmp($confirmPassword, $password) != 0) {
            $confirmPasswordErr = "Passwords does not match";
        }


        // Check if email is already in use, if not: create new user

        if ($name !== "" && $email !== "" && $password !== "" && $confirmPassword !== "" && $nameErr === "" && $emailErr === "" && $passwordErr === "" && $confirmPasswordErr === "") {
            //try catch 
            if (doesEmailExist($email) == true) {
                $emailErr = "An account with this email is already in use";
            }

            if ($emailErr === "") {
                $valid = true;
            }
        }
    }

    return array("name" => $name, "email" => $email, "password" => $password, "confirmPassword" => $confirmPassword, "nameErr" => $nameErr, "emailErr" => $emailErr, "passwordErr" => $passwordErr, "confirmPasswordErr" => $confirmPasswordErr, "valid" => $valid);
}

function validateLogin()
{

    // initiate the variables 
    $userid = $name = $email = $password = '';
    $emailErr = $passwordErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // validate the 'POST' data      

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        // check if all data are valid       
        if ($email !== "" && $password !== "" && $emailErr === "" && $passwordErr === "") {
            try {
                $authenticate = authenticateUser($email, $password);
                switch ($authenticate['result']) {
                    case RESULT_OK:
                        $valid = true;
                        $name = $authenticate['user']['name'];
                        $userid = $authenticate['user']['id'];
                        break;
                    case RESULT_WRONG:
                        $emailErr = "Email does not exist or password does not match";
                        break;
                }
            } catch (Exception $e) {
                $emailErr = "There is a technical issue, please try again later.";
                debug_to_console("Authentication failed: " . $e->getMessage());
            }
        }
    }

    // returning the data
    return array("userid" => $userid, "name" => $name, "email" => $email, "password" => $password, "emailErr" => $emailErr, "passwordErr" => $passwordErr,  "valid" => $valid);
}

function validateChangePassword()
{
    $password = $newPassword = '';
    $passwordErr = $newPasswordErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["newPassword"])) {
            $newPasswordErr = "New password is required";
        } else {
            $newPassword = test_input($_POST["newPassword"]);
        }

        if ($password !== "" && $newPassword !== "" && $passwordErr === "" && $newPasswordErr === "")
            try {
                $authenticate = authenticateCurrentUser(getLoggedInUserId(), $password);
                switch ($authenticate['result']) {
                    case RESULT_OK:
                        $valid = true;
                        break;
                    case RESULT_WRONG:
                        $passwordErr = "Password does not match";
                        break;
                }
            } catch (Exception $e) {
                $passwordErr = "There is a technical issue, please try again later.";
                debug_to_console("Authentication failed: " . $e->getMessage());
            }
    }
    return array("id" => getLoggedInUserId(), "password" => $password, "newPassword" => $newPassword, "passwordErr" => $passwordErr, "newPasswordErr" => $newPasswordErr, "valid" => $valid);
}
