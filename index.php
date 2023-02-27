<?PHP

// =================================================================
// Main App
// =================================================================

include 'validations.php';
include 'session_manager.php';
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
        case 'contact':
            $data = validateContact();
            $page = 'contact';
            break;
        case 'register':
            $data = validateRegistration();
            if ($data['valid']) {
                $page = 'login';
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
        default:
            $page = 'unknown';
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
    <link rel="icon" type="image/x-icon" href="C:\xampp\htdocs\educom-webshop-basis\favicon.ico">
  </head>';
}

// =================================================================
// Functions for Body
// =================================================================
function showBody($current_page, $data)
{
    showBodyStart();
    showHeader($current_page);
    showMenu();
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
            echo '<header>
        <h1>' . strtoupper($page) . '</h1>
      </header>';
            break;
        default:
            echo '<h1>Page not found</h1>';
            break;
    }
}

function showMenu()

{
    $pages = ['home', 'about', 'contact', 'register', 'login', 'logout'];
    echo '<ul class="menu"><nav>';

    foreach ($pages as $page) {
        if ($page === 'logout') {
            if (isset($_SESSION['username'])) {
                echo '
                    <a
                    href="index.php?page=' . $page . '"
                    ><li>' . strtoupper($page) . " " . strtoupper($_SESSION['username'])  . '</li></a>';
            }
        } elseif ($page === 'login' || $page === 'register') {
            if (!isset($_SESSION['username'])) {
                echo '
                    <a
                    href="index.php?page=' . $page . '"
                    ><li>' . strtoupper($page) .  '</li></a>
                    ';
            }
        } else {
            echo '
                <a
                href="index.php?page=' . $page . '"
                ><li>' . strtoupper($page) . '</li></a>
                 ';
        }
    };
    echo "</nav></ul>";
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
