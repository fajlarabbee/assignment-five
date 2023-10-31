<?php

define("PATH", dirname(__DIR__));
define("APP_NAME", "User Management System");
/**
 * Returns the path of the given filename
 *
 * @param string $filename
 *
 * @return string
 */
function getPath(string $filename): string
{
    $dirSep   = DIRECTORY_SEPARATOR;
    $filename = str_replace(['/', '//'], $dirSep, $filename);

    return PATH . $dirSep . ltrim($filename, '/');
}

/**
 * Include a file if exists.
 *
 * @param string $filename
 */
function inc(string $filename, array $args = [], bool $hasPath = false): void
{
    if ($args) {
        extract($args);
    }
    if ( ! $hasPath) {
        $filepath = getPath($filename);
    } else {
        $filepath = $filename;
    }

    if (file_exists($filepath)) {
        include_once $filepath;
    }
}

/**
 * Requires a file if exists.
 *
 * @param string $filename
 */
function req(string $filename): void
{
    $filepath = getPath($filename);
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

/**
 * Get the header of the
 *
 * @param $filename
 *
 * @return void
 */
function getHeader($filename = '', array $args = []): void
{
    if (empty($filename)) {
        inc(getTemplatePath("common/header.php"), $args);

        return;
    }
    inc(getTemplatePath($filename), $args);
}

function getFooter($filename = '', array $args = []): void
{
    if (empty($filename)) {
        inc(getTemplatePath("common/footer.php"), $args);

        return;
    }
    inc(getTemplatePath($filename), $args);
}

/**
 * Get Template directory.
 *
 * @param $filename
 *
 * @return string
 */
function getTemplatePath($filename): string
{
    $templatePath = "templates/";

    return $templatePath . $filename;
}

function getTemplate($filename, array $args = []): void
{
    inc(getTemplatePath($filename), $args);
}

/**
 * Get the site url.
 * @return string
 */
function siteURI()
{
    $protocol = $_SERVER['REQUEST_SCHEME'] ?? 'http';
    $host     = rtrim($_SERVER['HTTP_HOST'], '/');

    return sprintf("%s://%s/", $protocol, $host);
}

/**
 * Get the asset link.
 *
 * @param $filename
 * @param bool $echo
 *
 * @return string|null
 */
function asset(string $resourcePath, bool $echo = true): ?string
{
    if ( ! $echo) {
        return sprintf('%s%s', siteURI(), $resourcePath);
    }

    printf('%s%s', siteURI(), $resourcePath);

    return null;
}


/**
 * Dump and Die.
 *
 * @param $data
 *
 * @return void
 *
 */
function dd(): void
{
    array_map(function ($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }, func_get_args());
    die();
}

function classes(null|string|array $classes): void
{
    if (is_null($classes)) {
        $classes = '';
    }
    if (is_array($classes)) {
        $classes = join(' ', $classes);
    }
    echo $classes;
}

function isRole($role, $userRole): bool
{
    return $role === $userRole;
}

function redirectToDashboard($role): void
{
    switch (strtolower($role)) {
        case 'admin':
            redirect('/dashboard/admin/');
            break;
        case 'manager':
            redirect('/dashboard/manager');
            break;
        default:
            redirect('/dashboard/user');
            break;
    }
}

function redirect($location)
{
    header("Location: {$location}");
}


function urlIs($url): bool
{
    return parse_url($_SERVER['REQUEST_URI'])['path'] === $url;
}