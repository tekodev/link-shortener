<?php

try {
    setEnvironment();
    $db = new PDO("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8", getenv('DB_USER_NAME'), getenv('DB_PASSWORD'));
} catch ( PDOException $e ){
    print $e->getMessage();
}

function setEnvironment() {
    $path = '.env';
    if(!empty($path) && !file_exists($path)) {
        $path = __DIR__ . '/.env';
    }
    if(!file_exists($path)) {
        throw new \PDOException(sprintf('%s does not exist', $path));
    }

    if (!is_readable($path)) {
        throw new \PDOException(sprintf('%s file is not readable', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}