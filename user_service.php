<?PHP

include 'file_repository.php';

define("RESULT_OK", 0);
define("RESULT_WRONG", -1);


function authenticateUser($email, $password)
{
    $user = findUserByEmail($email);
    if (empty($user) || $user['password'] != $password) {
        return array("result" => RESULT_WRONG, "user" => $user);
    }
    return array("result" => RESULT_OK, "user" => $user);
}

function doesEmailExist($email)
{
    if (empty(findUserByEmail($email))) {
        return false;
    } else {
        return true;
    };
}

function storeUser($email, $name, $password)
{
    saveUser($email, $name, $password);
}
