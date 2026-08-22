<?php
/** Shared connection helper: reads database.default.* out of the project's .env. */

function projectRoot(): string {
    return dirname(__DIR__, 4);
}

function connectDb(): mysqli {
    $envPath = projectRoot() . '/.env';
    if (!is_readable($envPath)) {
        fwrite(STDERR, "cannot read $envPath\n");
        exit(1);
    }
    $config = [];
    foreach (file($envPath) as $line) {
        if (preg_match('/^\s*database\.default\.(\w+)\s*=\s*(.*?)\s*$/', $line, $m)) {
            $config[$m[1]] = trim($m[2], "'\"");
        }
    }
    foreach (['hostname', 'database', 'username', 'password'] as $key) {
        if (!isset($config[$key])) {
            fwrite(STDERR, "missing database.default.$key in .env\n");
            exit(1);
        }
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
    $db->set_charset('utf8mb4');
    return $db;
}
