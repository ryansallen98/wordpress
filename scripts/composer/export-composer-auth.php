<?php

declare(strict_types=1);

/**
 * Emit COMPOSER_AUTH JSON for ACF Pro (connect.advancedcustomfields.com).
 *
 * Reads ACF_PRO_LICENSE_KEY and WP_HOME from the environment. When vendor/
 * exists, loads the Bedrock .env via Dotenv so local `composer install` can
 * use the same variables as WordPress without manual export.
 *
 * Usage:
 *   export COMPOSER_AUTH="$(php scripts/composer/export-composer-auth.php)"
 *   composer install
 */

$root = dirname(__DIR__, 2);
$autoload = $root . '/vendor/autoload.php';

if (is_readable($autoload)) {
    require $autoload;

    if (class_exists(\Dotenv\Dotenv::class)) {
        \Dotenv\Dotenv::createImmutable($root)->safeLoad();
    }
}

$user = getenv('ACF_PRO_LICENSE_KEY') ?: '';
$pass = getenv('WP_HOME') ?: '';

if ($user === '' || $pass === '') {
    fwrite(STDERR, "export-composer-auth: set ACF_PRO_LICENSE_KEY and WP_HOME (e.g. in .env).\n");
    fwrite(STDERR, "First-time install without vendor/: export both in the shell or use auth.json.\n");

    exit(1);
}

$payload = [
    'http-basic' => [
        'connect.advancedcustomfields.com' => [
            'username' => $user,
            'password' => $pass,
        ],
    ],
];

echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
