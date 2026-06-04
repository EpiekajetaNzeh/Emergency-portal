<?php
// Centralized Database Configuration
// Fallback to environment variables if set, otherwise detect environment automatically.
$is_local = false;
if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1' || strpos($_SERVER['HTTP_HOST'], '192.168.') === 0)) {
    $is_local = true;
}

define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: ($is_local ? 'root' : 'ambulance_user'));
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($is_local ? '' : 'Ambulance@2026'));
define('DB_NAME', getenv('DB_NAME') ?: 'ccbd_ambulance');
define('DB_PORT', getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306);
?>
