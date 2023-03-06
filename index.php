<?PHP

// =================================================================
// Main App
// =================================================================

include 'validations.php';
include 'session_manager.php';
include 'products_service.php';

session_start();

$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

// =================================================================
// Functions
// =================================================================

function getRequestedPage()
{
    $request_type = $_SERVER['REQUEST_METHOD'];

    if ($request_type == 'POST') {
        $requested_page = getPostVar('page', 'home');
    } else if ($request_type == 'GET') {
        $requested_page = getUrlVar('page', 'home');
    }
    return $requested_page;
}

function getPostVar($key, $default = '')
{
    $value = filter_input(INPUT_POST, $key);
    return isset($value) ? $value : $default;
}

function getUrlVar($key, $default = '')
{
    $value = filter_input(INPUT_GET, $key);
    return isset($value) ? $value : $default;
}

function processRequest($page)
{

    switch ($page) {
        case 'home':
            $page = 'home';
            break;
        case 'about':
            $page = 'about';
            break;
        case 'webshop':
            $data = getWebshopProducts();
            $page = 'webshop';
            break;
        case 'productdetail':
            $id = getUrlVar("id");
            $data = getProductDetails($id);
            $page = 'productdetail';            
            break;
        case 'contact':
            $data = validateContact();
            $page = 'contact';
            break;
        case 'register':
            $data = validateRegistration();
            if ($data['valid']) {
                try {
                    storeUser($data['email'], $data['name'], $data['password']);
                    $page = 'login';
                } catch (Exception $e) {
                    $data['emailErr'] = "Name could not be stored due to a technical error";
                    debug_to_console("Store user failed" . $e->getMessage());
                }
            }
            break;
        case 'login':
            $data = validateLogin();
            if ($data['valid']) {
                logUserIn($data);
                $page = 'home';
            }
            break;
        case 'logout':
            logUserOut();
            $page = 'home';
            break;
        case 'changepassword':
            $data = validateChangePassword();
            if ($data['valid']) {
                try {
                    updatePassword($data['id'], $data['newPassword']);
                    $page = 'home';
                } catch (Exception $e) {
                    $data['passwordErr'] = "Password could not be changed due to a technical error";
                    debug_to_console("Change user password failed" . $e->getMessage());
                }
            }
            break;
        default:
            $page = 'unknown';
    }
    $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'webshop' => 'Webshop');

    if (isUserLoggedIn()) {
        $data['menu']['logout'] = "Logout " . getLoggedInUserName();
        $data['menu']['changepassword'] = "Change Password ";
    } else {
        $data['menu']['register'] = "Register";
        $data['menu']['login'] = "Login";
        /* ... */
    }
    $data['page'] = $page;
    return $data;
}
function showResponsePage($data)
{
    $current_page = $data['page'];
    if ($current_page !== 'unknown') {
        include "$current_page.php";
    }

    beginDocument();
    showHeadSection($current_page);

    if ($current_page !== 'unknown') {
        showBody($current_page, $data);
    } else {
        echo 'No such page.';
    }

    endDocument();
}


function beginDocument()
{
    echo '<!doctype html> 
              <html>';
}

function showHeadSection($page)
{

    echo '<head>
    <title>' . strtoupper($page) . '</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
  </head>';
}

// =================================================================
// Functions for Body
// =================================================================
function showBody($current_page, $data)
{
    showBodyStart();
    showHeader($current_page);
    showMenu($data);
    showContent($data);
    showFooter();
    showBodyEnd();
}


function showBodyStart()
{

    echo '    <body>' . PHP_EOL;
    echo '<div id="page-container">
    <div id="content-wrap">' . PHP_EOL;
}

function showHeader($page)
{
    switch ($page) {
        case 'home':
        case 'about':
        case 'contact':
        case 'register':
        case 'login':
        case 'changepassword':
        case 'webshop':
        case 'productdetail':
            echo '<header>
        <h1>' . strtoupper($page) . '</h1>
      </header>';
            break;
        default:
            echo '<h1>Page not found</h1>';
            break;
    }
}

function showMenu($data)

{
    echo '<ul class="menu"><nav>';
    foreach ($data['menu'] as $link => $label) {
        showMenuItem($link, $label);
    }
    echo '</nav></ul>';
}

function showMenuItem($link, $label)
{
    echo '
        <a href="index.php?page=' . $link . '">
        <li>' . $label .  '</li>
        </a>';
}

function showFooter()
{
    echo '
    </div>
    <footer>
    <p>&copy; <script>
        document.write(new Date().getFullYear())
      </script> Lydia van Gammeren All Rights Reserved</p>
  </footer>';
}

function showBodyEnd()
{
    echo '</div>' . PHP_EOL;
    echo '    </body>' . PHP_EOL;
}



// =================================================================

function endDocument()
{
    echo  '</html>';
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}
