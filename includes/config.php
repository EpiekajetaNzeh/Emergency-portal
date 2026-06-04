<?php
// Centralized Database Configuration
// Fallback to environment variables if set (for GCP hosting), otherwise use local constants.
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'ccbd_ambulance');
define('DB_PORT', getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306);
?>
