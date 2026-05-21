<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Session Security Configuration
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $request_uri_segments = explode('/', $_SERVER['REQUEST_URI']);
    $first_segment = '/' . $request_uri_segments[1];
    $url_config = "https://" . $_SERVER['HTTP_HOST'] . $first_segment . "";

    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $path = parse_url($current_url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $last_segment = end($segments);

    $request_uri_segments = explode('/', $_SERVER['REQUEST_URI']);
    $first_segment = '/' . $request_uri_segments[1];
    $url_config = "https://" . $_SERVER['HTTP_HOST'] . $first_segment . "";

    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $path = parse_url($current_url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $last_segment = end($segments);
    $server = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $database_name = $_ENV['DB_NAME'];

} elseif ($_SERVER['HTTP_HOST'] == 'scansworldonchamiersroad.com') {
    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $path = parse_url($current_url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $last_segment = end($segments);

    $server = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $database_name = $_ENV['DB_NAME'];

} else {

}

$con = mysqli_connect("$server", "$username", "$password", "$database_name");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Cloudflare Turnstile Settings
$cloudflare_site_key = $_ENV['TURNSTILE_SITE_KEY'];
$cloudflare_secret_key = $_ENV['TURNSTILE_SECRET_KEY'];

// Blacklist Words
$blacklist_words = [
    'select',
    'update',
    'delete',
    'set',
    'drop',
    'truncate',
    'insert',
    'union',
    'where',
    'from',
    'join',
    'having',
    'group',
    'order',
    'by',
    'limit',
    'offset',
    'and',
    'or',
    'not',
    'like',
    'in',
    'exists',
    'between',
    'create',
    'alter',
    'rename',
    'replace',
    'grant',
    'revoke',
    'exec',
    'execute',
    'call',
    'sleep',
    'benchmark',
    '--',
    '#',
    '/*',
    '*/',
    '/',
    '\\',
    ';',
    'xp_',
    'load_file',
    'outfile',
    'dumpfile',
    'information_schema',
    'table_schema',
    'column_name',
    'concat',
    'substring',
    'ascii',
    'char',
    'length',
    'version',
    'database',
    'user',
    'current_user',
    'eval',
    'script',
    'shell',
    'base64',
    'encode',
    'decode',
    'backup',
    'max',
    "' or 1=1 --",
    "' or 'a'='a",
    'union select',
    'select * from',
    'drop table',
    'insert into',
    'update set',
    'delete from',
    'xp_cmdshell',
    'information_schema',
    '<script>',
    '</script>',
    'javascript:',
    'onerror=',
    'onload=',
    'alert(',
    'document.cookie',
    'eval(',
    'iframe',
    '<svg',
    '<iframe>',
    'http://',
    'https://',
    'www.',
    'bit.ly',
    'tinyurl',
    'redirect=',
    'base64,',
    'data:text/html',
    'free money',
    'earn cash',
    'work from home',
    'click here',
    'subscribe now',
    'buy now',
    'cheap price',
    'loan offer',
    'crypto profit',
    'bitcoin',
    'casino',
    'porn',
    'xxx'
];

if (!function_exists('containsBlacklistedWords')) {
    function containsBlacklistedWords($str, $words)
    {
        foreach ($words as $word) {
            if (preg_match("/\b" . preg_quote($word, '/') . "\b/i", $str)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('verifyCloudflareTurnstile')) {
    function verifyCloudflareTurnstile($cf_turnstile_response, $secret_key)
    {
        if (empty($cf_turnstile_response)) {
            return false;
        }

        // Start session if not already started to track used tokens
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['used_turnstile_tokens'])) {
            $_SESSION['used_turnstile_tokens'] = array();
        }

        // Reject if token has already been submitted in this session
        if (in_array($cf_turnstile_response, $_SESSION['used_turnstile_tokens'])) {
            return false;
        }

        $data = array(
            'secret' => $secret_key,
            'response' => $cf_turnstile_response
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        curl_close($verify);
        $responseData = json_decode($response);

        $success = $responseData->success ?? false;
        if ($success) {
            // Register token as used
            $_SESSION['used_turnstile_tokens'][] = $cf_turnstile_response;
            // Limit session array size
            if (count($_SESSION['used_turnstile_tokens']) > 15) {
                array_shift($_SESSION['used_turnstile_tokens']);
            }
        }
        return $success;
    }
}
if (!function_exists('getUserIP')) {
    /**
     * Gets the user's real IP address, accounting for Cloudflare.
     * @return string
     */
    function getUserIP()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}

if (!function_exists('checkAdminLogin')) {
    function checkAdminLogin()
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php');
            exit();
        }
        $timeout = 1800;
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            session_unset();
            session_destroy();
            echo "<script>alert('Session expired. Please login again.'); window.location.href = 'index.php';</script>";
            exit();
        }
        $_SESSION['last_activity'] = time();
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($username, $permission_column)
    {
        global $con;
        $allowed = ['dashboard', 'settings', 'general', 'seo_management', 'reports'];
        if (!in_array($permission_column, $allowed))
            return false;
        $stmt = $con->prepare("SELECT $permission_column FROM admin WHERE user_name = ? AND del_i = 0");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row[$permission_column] == 1;
            }
        }
        return false;
    }
}
