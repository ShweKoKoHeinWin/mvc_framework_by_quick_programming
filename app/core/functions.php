<?php

defined('ROOTPATH') or exit("Access Denied.");

checkExtension();
function checkExtension()
{
    $required_extensions = [
        // 'gd',
        'mysqli',
        'pdo_mysql',
        'curl',
        'fileinfo',
        'mbstring'
    ];
    $not_loaded = [];
    foreach ($required_extensions as $extension) {
        if (!extension_loaded($extension)) {
            $not_loaded[] = $extension;
        }
    }

    if (!empty($not_loaded)) {
        show("Please load the following Extension in your php.ini file <br> " . implode("<br> ", $not_loaded));
        die();
    }
}

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    header('Location: ' . ROOT . '/' . $path);
    die();
}

// load image if not exist, load placeholder 
function get_image(mixed $file = '', string $type = 'post'): string
{
    $file = $file ?? '';
    if (file_exists($file)) {
        return ROOT . "/" . $file;
    }

    if ($type == 'user') {
        return ROOT . "/assets/images/user.jpg";
    } else {
        return ROOT . "/assets/images/no_image.jpg";
    }
}

function remove_images_from_content($content, $folder = 'uploads/')
{
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        file_put_contents($folder . 'index.php', 'Access Denied!');
    }

    preg_match_all('/<img[^>]+>/', $content, $matches);
    $new_content = $content;

    if (is_array($matches) && count($matches) > 0) {
        $image_class = new \Core\Image();
        foreach ($matches[0] as $match) {
            if (strstr($match, 'http')) {
                continue;
            }

            preg_match('/src="[^"]+/', $match, $matches2);
            preg_match('/data-filename="[^"]+/', $match, $matches3);
            if (strstr($matches2[0], 'data:')) {
                $parts = explode(',', $matches2[0]);
                $basename = $matches3[0] ?? 'basename.jpg';
                $basename = str_replace('data-filename="', "", $basename);

                $filename = $folder . "img_" . sha1(rand(0, 9999999999)) . $basename;

                $new_content = str_replace($parts[0] . "," . $parts[1], 'src="' . $filename, $new_content);
                file_put_contents($filename, base64_decode($parts[1]));

                $image_class->resize($filename, 1000);
            }
        }
    }
    return $new_content;
}

function delete_image_from_content(string $content, string $content_new = ''): void
{
    if (empty($content_new)) {
        preg_match_all('/<img[^>]+>/', $content, $matches);
        if (is_array($matches) && count($matches) > 0) {
            foreach ($matches[0] as $match) {
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);
                if (file_exists($matches2[0])) {
                    unLink($matches2[0]);
                }
            }
        }
    } else {
        preg_match_all('/<img[^>]+>/', $content, $matches);
        preg_match_all('/<img[^>]+>/', $content_new, $matches_new);

        $old_images = [];
        $new_images = [];

        if (is_array($matches) && count($matches) > 0) {
            foreach ($matches[0] as $match) {
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                if (file_exists($matches2[0])) {
                    $old_images[] = $matches2[0];
                }
            }
        }

        if (is_array($matches_new) && count($matches_new) > 0) {
            foreach ($matches_new[0] as $match) {
                preg_match('/src="[^"]+/', "", $matches2[0]);
                if (file_exists($matches2[0])) {
                    $new_images[] = $matches2[0];
                }
            }
        }

        foreach ($old_images as $img) {
            if (!in_array($img, $new_images)) {
                if (file_exists($img)) {
                    unLink($img);
                }
            }
        }
    }
}

function add_root_to_images($contents)
{
    preg_match_all('/<img[^>]+>', $contents, $matches);
    if (is_array($matches) && count($matches) > 0) {
        foreach ($matches[0] as $match) {
            preg_match('/src="[^"]+/', $match, $matches2);

            if (!strstr($matches2[0], 'http')) {
                $contents = str_replace($matches2[0], 'src="' . ROOT . '/' . str_replace('src="', '', $matches2[0]), $contents);
            }
        }
    }
    return $contents;
}

// Pagination
function get_pagination_vars(): array
{
    $vars = [];
    $vars['page'] = $_GET['page'] ?? 1;
    $vars['page'] = (int)$vars['page'];
    $vars['prev_page'] = $vars['page'] <= 1 ? 1 : $vars['page'] - 1;
    $vars['next_page'] = $vars['page'] + 1;
    return $vars;
}


function message(string $msg = null, bool $clear = false)
{
    $ses = new Core\Session();

    if (!empty($msg)) {
        $ses->set('message', $msg);
    } else if (!empty($ses->get('message'))) {
        $msg = $ses->get('message');
        if ($clear) {
            $ses->pop('message');
        }
        return $msg;
    }
    return false;
}

/* Page refresh Old values */
function old_checked(string $key, string $value, string $default = ''): string
{
    if (isset($_POST[$key])) {
        if ($_POST[$key] == $value) {
            return ' checked ';
        }
    } else {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && $default == $value) {
            return ' checked ';
        }
    }
    return '';
}


function old_value(string $key, mixed $default = '', string $mode = 'post'): mixed
{
    $POST = ($mode == 'post') ? $_POST : $_GET;
    if (isset($POST[$key])) {
        return $POST[$key];
    }
    return $default;
}


function old_selected(string $key, mixed $value, mixed $default = '', string $mode = 'post')
{
    $POST = ($mode == 'post') ? $_POST : $_GET;
    if (isset($POST)) {
        if ($POST[$key] == $value) {
            return ' selected ';
        }
    } else if ($default == $value) {
        return ' selected ';
    }
    return '';
}


// date
function get_date($date)
{
    return date('jS M, Y', strtotime($date));
}


function URL($key): mixed
{
    $URL = $_GET['url'] ?? 'home';
    $URL = explode('/', trim($URL, '/'));


    switch ($key) {
        case 'page':
        case 0:
            return $URL[0] ?? null;
            break;

        case 'section':
        case 'slug':
        case 1:
            return $URL[1] ?? null;
            break;

        case 'action':
        case 2:
            return $URL[2] ?? null;
            break;

        case 'id':
        case 3:
            return $URL[3] ?? null;
            break;

        default:
            return null;
            break;
    }
}
