<?php

/**
 * Laravel - A PHP Framework For Web Artisans.
 *
 * @author   Taylor Otwell <taylor@laravel.com>
 */

use Illuminate\Support\Facades\App;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.App::environment('local') ? '/public' : '../public_html'.$uri)) {
    return false;
}

require_once __DIR__.App::environment('local') ? '/public/index.php' : '../public_html/index.php';
