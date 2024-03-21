<?php

namespace Core;

defined('ROOTPATH') or exit("Access Denied.");

class Session
{
    public $mainKey = 'APP';
    public $userKey = 'USER';
    private function start_session()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return 1;
    }

    public function set(mixed $keyOrArray, mixed $value = ''): int
    {
        $this->start_session();
        if (is_array($keyOrArray)) {
            foreach ($keyOrArray as $key => $value) {
                $_SESSION[$this->mainKey][$key] = $value;
            }
            return 1;
        }
        $_SESSION[$this->mainKey][$keyOrArray] = $value;
        return 1;
    }

    public function get(string $key, mixed $default = ''): mixed
    {
        $this->start_session();
        if (isset($_SESSION[$this->mainKey][$key])) {
            return $_SESSION[$this->mainKey][$key];
        }
        return $default;
    }

    public function auth(mixed $user_row): int
    {
        $this->start_session();
        $_SESSION[$this->userKey] = $user_row;
        return 0;
    }

    public function logout(): int
    {
        $this->start_session();
        if (!empty($_SESSION[$this->userKey])) {
            unset($_SESSION[$this->userKey]);
        }
        return 0;
    }

    public function is_logged_in(): bool
    {
        $this->start_session();

        if (!empty($_SESSION[$this->userKey])) {
            return true;
        }
        return false;
    }

    public function is_admin(): bool
    {
        $this->start_session();
        $db = new \Core\Database();
        if (!empty($_SESSION[$this->userKey])) {
            $arr = [];
            $arr['id '] = $_SESSION[$this->userKey]->role_id;
            if ($db->get_row("SELECT * FROM `auth_roles` WHERE id = :id && role = 'admin' LIMIT 1", $arr)) {
                return true;
            }
        }
        return false;
    }

    public function user(string $key = '', mixed $default = ''): mixed
    {
        $this->start_session();
        if (!empty($key) && !empty($_SESSION[$this->userKey])) {
            return  $_SESSION[$this->userKey];
        } else if (!empty($_SESSION[$this->userKey]->$key)) {
            return $_SESSION[$this->userKey]->$key;
        }
        return $default;
    }

    public function pop(string $key, mixed $default = ''): mixed
    {
        $this->start_session();
        if (!empty($_SESSION[$this->mainKey][$key])) {
            $value = $_SESSION[$this->mainKey][$key];
            unset($_SESSION[$this->mainKey][$key]);
            return $value;
        }
        return $default;
    }

    public function all(): mixed
    {
        $this->start_session();
        if (isset($_SESSION[$this->mainKey])) {
            return $_SESSION[$this->mainKey];
        }
        return [];
    }
}
