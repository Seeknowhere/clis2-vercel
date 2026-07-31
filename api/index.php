<?php
/**
 * Single entry point for the whole app on Vercel.
 * vercel.json sends every request here — no static file handler runs
 * first — so this file is also responsible for serving CSS/JS/images
 * itself. Only files with an extension on the allowlist below are ever
 * streamed as raw bytes; everything else must be an executable .php
 * route or a directory with an index.php. This is what stops files
 * like /config.php or /db/clis_db.sql from being served as plain text.
 */

define('ROOT_PATH', dirname(__DIR__) . '/');

// Keep old code that still reads DOCUMENT_ROOT (e.g. vendor libs) working.
$_SERVER['DOCUMENT_ROOT'] = rtrim(ROOT_PATH, '/');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');

// Block path traversal (../) before touching the filesystem.
if ($path !== '' && strpos($path, '..') !== false) {
    http_response_code(400);
    exit('Bad request');
}

$STATIC_MIME_TYPES = [
    'css' => 'text/css',
    'js' => 'application/javascript',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',
    'ico' => 'image/x-icon',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'otf' => 'font/otf',
    'eot' => 'application/vnd.ms-fontobject',
];

$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

if ($path === '') {
    $target = ROOT_PATH . 'index.php';
} elseif (isset($STATIC_MIME_TYPES[$extension])) {
    $file = ROOT_PATH . $path;
    if (!is_file($file)) {
        http_response_code(404);
        exit('Not found');
    }
    header('Content-Type: ' . $STATIC_MIME_TYPES[$extension]);
    header('Cache-Control: public, max-age=31536000, immutable');
    readfile($file);
    exit;
} else {
    $candidate = ROOT_PATH . $path;
    if (is_dir($candidate)) {
        $target = rtrim($candidate, '/') . '/index.php';
    } elseif ($extension === 'php') {
        $target = $candidate;
    } else {
        // Anything else (.sql, dotfiles, extensionless non-route paths,
        // etc.) is never served.
        http_response_code(404);
        exit('Not found');
    }
}

if (!is_file($target)) {
    http_response_code(404);
    exit('Not found');
}

chdir(dirname($target));
require $target;
