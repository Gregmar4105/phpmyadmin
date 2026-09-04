<?php
/**
 * phpMyAdmin configuration with dynamic .env and environment variable support.
 * Compatible with local environments (Laragon/Herd/XAMPP) and Coolify/Docker/Cloudflare deployments.
 */

// -----------------------------------------------------------------------------
// Environment Loader & Helper Functions
// -----------------------------------------------------------------------------

if (!function_exists('pma_load_env')) {
    /**
     * Parse a .env file and load variables into putenv, $_ENV, and $_SERVER
     * if they are not already set in the environment.
     */
    function pma_load_env(string $filePath): void
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0 || strpos($line, ';') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $val = trim($parts[1]);

            // Strip surrounding quotes
            $len = strlen($val);
            if ($len >= 2 && (($val[0] === '"' && $val[$len - 1] === '"') || ($val[0] === "'" && $val[$len - 1] === "'"))) {
                $val = substr($val, 1, -1);
            }

            // Container / system environment takes precedence
            if (getenv($key) === false && !array_key_exists($key, $_ENV) && !array_key_exists($key, $_SERVER)) {
                putenv("{$key}={$val}");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
    }
}

if (!function_exists('pma_env')) {
    /**
     * Retrieve an environment variable by name or alias, falling back to a default.
     */
    function pma_env($keys, $default = null)
    {
        $keyList = is_array($keys) ? $keys : [$keys];
        foreach ($keyList as $key) {
            $val = getenv($key);
            if ($val !== false && $val !== '') {
                return $val;
            }
            if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
                return $_ENV[$key];
            }
            if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
                return $_SERVER[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('pma_env_bool')) {
    /**
     * Retrieve an environment variable as a boolean.
     */
    function pma_env_bool($keys, bool $default = false): bool
    {
        $val = pma_env($keys, null);
        if ($val === null) {
            return $default;
        }
        if (is_bool($val)) {
            return $val;
        }
        $val = strtolower(trim((string)$val));
        return in_array($val, ['1', 'true', 'yes', 'on'], true);
    }
}

if (!function_exists('pma_env_int')) {
    /**
     * Retrieve an environment variable as an integer.
     */
    function pma_env_int($keys, int $default = 0): int
    {
        $val = pma_env($keys, null);
        if ($val === null) {
            return $default;
        }
        return (int)$val;
    }
}

// Load .env file from project root if present
pma_load_env(__DIR__ . '/.env');

// -----------------------------------------------------------------------------
// Reverse Proxy & HTTPS Detection (Cloudflare Tunnel, Coolify/Traefik, Nginx)
// -----------------------------------------------------------------------------
$isHttpsProxy = (
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ||
    (!empty($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false) ||
    (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') ||
    (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) === 'on') ||
    pma_env_bool(['PMA_IS_HTTPS', 'IS_HTTPS'], true)
);

if ($isHttpsProxy) {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
}
$cfg['is_https'] = $isHttpsProxy;
$cfg['CookieSecure'] = $isHttpsProxy;

// Synchronize session cookie names between phpMyAdmin and phpMyAdmin_https
if (isset($_COOKIE['phpMyAdmin_https']) && !isset($_COOKIE['phpMyAdmin'])) {
    $_COOKIE['phpMyAdmin'] = $_COOKIE['phpMyAdmin_https'];
}
if (isset($_COOKIE['phpMyAdmin']) && !isset($_COOKIE['phpMyAdmin_https'])) {
    $_COOKIE['phpMyAdmin_https'] = $_COOKIE['phpMyAdmin'];
}

// Force HTTPS redirect if requested and client reached via plain HTTP
if (
    pma_env_bool(['PMA_FORCE_SSL', 'FORCE_SSL'], false) &&
    !$isHttpsProxy &&
    (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') &&
    !empty($_SERVER['HTTP_HOST'])
) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
    exit;
}

// Set Absolute URI for consistent cookies, form actions, and redirects
$pmaAbsoluteUri = pma_env(['PMA_ABSOLUTE_URI', 'PMA_URL']);
if (!empty($pmaAbsoluteUri)) {
    $cfg['PmaAbsoluteUri'] = rtrim($pmaAbsoluteUri, '/') . '/';
} elseif (!empty($_SERVER['HTTP_HOST'])) {
    $scheme = $isHttpsProxy ? 'https' : ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http');
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'];
    $cfg['PmaAbsoluteUri'] = $scheme . '://' . $host . '/';
} else {
    $cfg['PmaAbsoluteUri'] = 'https://vince-larable-dbadmin.larable.dev/';
}

// Whitelist Cloudflare Insights / Analytics in Content Security Policy
$cfg['CSPAllow'] = 'static.cloudflareinsights.com';

// -----------------------------------------------------------------------------
// Cookie Encryption Secret (Blowfish Secret)
// -----------------------------------------------------------------------------
$cfg['blowfish_secret'] = pma_env(
    ['PMA_BLOWFISH_SECRET', 'BLOWFISH_SECRET'],
    'xampp'
);

// -----------------------------------------------------------------------------
// Servers Configuration
// -----------------------------------------------------------------------------
$i = 0;

// Support comma-separated PMA_HOSTS if provided (Docker standard)
$pmaHosts = pma_env('PMA_HOSTS');
if (!empty($pmaHosts)) {
    $hosts = array_map('trim', explode(',', $pmaHosts));
    $ports = array_map('trim', explode(',', (string)pma_env('PMA_PORTS', '')));
    $verboses = array_map('trim', explode(',', (string)pma_env('PMA_VERBOSES', '')));
    $user = pma_env(['PMA_USER', 'DB_USER'], 'root');
    $password = pma_env(['PMA_PASSWORD', 'DB_PASSWORD'], '');
    $ssl = pma_env_bool(['PMA_SSL', 'DB_SSL'], false);
    $sslVerify = pma_env_bool(['PMA_SSL_VERIFY', 'DB_SSL_VERIFY'], false);

    foreach ($hosts as $idx => $host) {
        $i++;
        $cfg['Servers'][$i]['host'] = $host;
        $cfg['Servers'][$i]['port'] = isset($ports[$idx]) && $ports[$idx] !== '' ? (int)$ports[$idx] : 3306;
        $cfg['Servers'][$i]['verbose'] = isset($verboses[$idx]) && $verboses[$idx] !== '' ? $verboses[$idx] : $host;
        $cfg['Servers'][$i]['auth_type'] = pma_env('PMA_AUTH_TYPE', 'cookie');
        $cfg['Servers'][$i]['user'] = $user;
        $cfg['Servers'][$i]['password'] = $password;
        $cfg['Servers'][$i]['extension'] = 'mysqli';
        $cfg['Servers'][$i]['connect_type'] = 'tcp';
        $cfg['Servers'][$i]['ssl'] = $ssl;
        $cfg['Servers'][$i]['ssl_verify'] = $sslVerify;
        $cfg['Servers'][$i]['hide_db'] = pma_env('HIDE_DB', '^(information_schema|mysql|performance_schema|sys)$');
    }
} else {
    // Server 1 (Local / Primary Database)
    $server1Enable = pma_env_bool(['SERVER1_ENABLE', 'ENABLE_SERVER_1'], true);
    if ($server1Enable) {
        $i++;
        $cfg['Servers'][$i]['verbose'] = pma_env(['SERVER1_VERBOSE', 'DB_VERBOSE'], 'Local MySQL');
        $cfg['Servers'][$i]['auth_type'] = pma_env(['SERVER1_AUTH_TYPE', 'DB_AUTH_TYPE'], 'cookie');
        $cfg['Servers'][$i]['user'] = pma_env(['SERVER1_USER', 'DB_USER'], 'root');
        $cfg['Servers'][$i]['password'] = pma_env(['SERVER1_PASSWORD', 'DB_PASSWORD'], 'root');
        $cfg['Servers'][$i]['extension'] = 'mysqli';
        $cfg['Servers'][$i]['AllowNoPassword'] = pma_env_bool(['SERVER1_ALLOW_NO_PASSWORD', 'ALLOW_NO_PASSWORD'], false);
        $cfg['Servers'][$i]['host'] = pma_env(['SERVER1_HOST', 'DB_HOST'], '127.0.0.1');
        $cfg['Servers'][$i]['port'] = pma_env_int(['SERVER1_PORT', 'DB_PORT'], 3306);
        $cfg['Servers'][$i]['connect_type'] = pma_env('SERVER1_CONNECT_TYPE', 'tcp');
        $cfg['Servers'][$i]['ssl'] = pma_env_bool(['SERVER1_SSL', 'DB_SSL'], false);
        $cfg['Servers'][$i]['ssl_verify'] = pma_env_bool(['SERVER1_SSL_VERIFY', 'DB_SSL_VERIFY'], false);
        $cfg['Servers'][$i]['hide_db'] = pma_env(
            ['SERVER1_HIDE_DB', 'HIDE_DB'],
            '^(information_schema|mysql|performance_schema|sys)$'
        );

        // Optional phpMyAdmin configuration storage
        $pmadb = pma_env('SERVER1_PMADB', 'phpmyadmin');
        if (!empty($pmadb)) {
            $cfg['Servers'][$i]['controluser'] = pma_env('SERVER1_CONTROLUSER', 'root');
            $cfg['Servers'][$i]['controlpass'] = pma_env('SERVER1_CONTROLPASS', 'root');
            $cfg['Servers'][$i]['pmadb'] = $pmadb;
            $cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
            $cfg['Servers'][$i]['relation'] = 'pma__relation';
            $cfg['Servers'][$i]['table_info'] = 'pma__table_info';
            $cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
            $cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
            $cfg['Servers'][$i]['column_info'] = 'pma__column_info';
            $cfg['Servers'][$i]['history'] = 'pma__history';
            $cfg['Servers'][$i]['designer_coords'] = 'pma__designer_coords';
            $cfg['Servers'][$i]['tracking'] = 'pma__tracking';
            $cfg['Servers'][$i]['userconfig'] = 'pma__userconfig';
            $cfg['Servers'][$i]['recent'] = 'pma__recent';
            $cfg['Servers'][$i]['table_uiprefs'] = 'pma__table_uiprefs';
            $cfg['Servers'][$i]['users'] = 'pma__users';
            $cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
            $cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
            $cfg['Servers'][$i]['savedsearches'] = 'pma__savedsearches';
            $cfg['Servers'][$i]['central_columns'] = 'pma__central_columns';
            $cfg['Servers'][$i]['designer_settings'] = 'pma__designer_settings';
            $cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';
            $cfg['Servers'][$i]['favorite'] = 'pma__favorite';
        }
    }

    // Server 2 (Remote / Aiven / Secondary Database)
    $server2Host = pma_env(
        ['SERVER2_HOST', 'DB2_HOST'],
        'larable-mysql-service-larablenetwork-2db5.f.aivencloud.com'
    );
    $server2Enable = pma_env_bool(
        ['SERVER2_ENABLE', 'ENABLE_SERVER_2'],
        !empty($server2Host)
    );

    if ($server2Enable && !empty($server2Host)) {
        $i++;
        $cfg['Servers'][$i]['verbose'] = pma_env(['SERVER2_VERBOSE', 'DB2_VERBOSE'], 'Larable Remote MySQL (Aiven)');
        $cfg['Servers'][$i]['host'] = $server2Host;
        $cfg['Servers'][$i]['port'] = pma_env_int(['SERVER2_PORT', 'DB2_PORT'], 20707);
        $cfg['Servers'][$i]['connect_type'] = pma_env('SERVER2_CONNECT_TYPE', 'tcp');
        $cfg['Servers'][$i]['auth_type'] = pma_env(['SERVER2_AUTH_TYPE', 'DB2_AUTH_TYPE'], 'cookie');
        $cfg['Servers'][$i]['user'] = pma_env(['SERVER2_USER', 'DB2_USER'], 'avnadmin');
        $cfg['Servers'][$i]['password'] = pma_env(['SERVER2_PASSWORD', 'DB2_PASSWORD'], 'AVNS_3c6BireRDm5jncJM3ke');
        $cfg['Servers'][$i]['ssl'] = pma_env_bool(['SERVER2_SSL', 'DB2_SSL'], true);
        $cfg['Servers'][$i]['ssl_verify'] = pma_env_bool(['SERVER2_SSL_VERIFY', 'DB2_SSL_VERIFY'], false);
        $cfg['Servers'][$i]['extension'] = 'mysqli';
        $cfg['Servers'][$i]['hide_db'] = pma_env(
            ['SERVER2_HIDE_DB', 'DB2_HIDE_DB', 'HIDE_DB'],
            '^(information_schema|mysql|performance_schema|sys)$'
        );
    }
}

// -----------------------------------------------------------------------------
// Security & Reverse Proxy Settings
// -----------------------------------------------------------------------------
// Allow manual server entry on login screen
$cfg['AllowArbitraryServer'] = pma_env_bool(['PMA_ARBITRARY', 'ALLOW_ARBITRARY_SERVER'], false);

// Session and Cookie configuration
$sessionSavePath = pma_env(['PMA_SESSION_SAVE_PATH', 'SESSION_SAVE_PATH']);
$cfg['SessionSavePath'] = !empty($sessionSavePath) ? $sessionSavePath : sys_get_temp_dir();
$cfg['CookieSameSite'] = pma_env(['PMA_COOKIE_SAMESITE', 'COOKIE_SAMESITE'], 'Lax');

// Temporary directory for Twig and uploads
$cfg['TempDir'] = __DIR__ . '/tmp';

// -----------------------------------------------------------------------------
// Appearance & Custom Titles
// -----------------------------------------------------------------------------
$cfg['ThemeDefault'] = pma_env(['PMA_THEME', 'THEME_DEFAULT'], 'boodark-orange');
$title = pma_env(['PMA_TITLE', 'TITLE_DEFAULT'], 'Larable');
$cfg['TitleTable'] = pma_env('PMA_TITLE_TABLE', $title);
$cfg['TitleDatabase'] = pma_env('PMA_TITLE_DATABASE', $title);
$cfg['TitleServer'] = pma_env('PMA_TITLE_SERVER', $title);
$cfg['TitleDefault'] = $title;
$cfg['Lang'] = pma_env('PMA_LANG', '');

?>
