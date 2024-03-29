<?php

namespace Core;

defined('ROOTPATH') or exit("Access Denied.");

trait Model
{
    use \Core\Database;

    public $limit = 10;
    public $offset = 0;
    public $order_type = 'desc';
    public $order_column = 'id';
    public $errors = [];

    public function findAll()
    {
        $query = "SELECT * FROM `{$this->table}` ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";

        $result = $this->query($query);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function where(array $data, array $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $query = "SELECT * FROM `{$this->table}` WHERE ";

        foreach ($keys as $key) {
            $query .= $key . '= :' . $key . ' && ';
        }

        foreach ($keys_not as $key) {
            $query .= $key . '!= :' . $key . ' && ';
        }

        $query = trim($query, ' && ');

        $query .= " ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";

        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function first(array $data, array $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $query = "SELECT * FROM `{$this->table}` WHERE ";

        foreach ($keys as $key) {
            $query .= $key . '= :' . $key . ' && ';
        }

        foreach ($keys_not as $key) {
            $query .= $key . '!= :' . $key . ' && ';
        }

        $query = trim($query, ' && ');

        $query .= " ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";

        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        }
        return false;
    }


    public function insert($data)
    {
        // Removed Unallow Columns
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);

        $query = "INSERT INTO `{$this->table}` ( " . implode(',', $keys) . " ) VALUES ( :" . implode(', :', $keys) . " )";
        $result = $this->query($query, $data);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function update($id, $data, $id_column = 'id')
    {
        // Removed Unallow Columns
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);
        $query = "UPDATE {$this->table} SET ";
        foreach ($keys as $key) {
            $query .= $key . ' = :' . $key . ', ';
        }
        $query = trim($query, ', ');
        $query .= " WHERE $id_column = :$id_column";
        $data[$id_column] = $id;

        $this->query($query, $data);
    }

    public function delete($id, $data, $id_column = 'id')
    {
        $data[$id_column] = $id;
        $query = "DELETE FROM `{$this->table}` WHERE $id_column = :$id_column";
        $this->query($query, $data);
    }

    public function validate($data)
    {
        $this->errors = [];

        if (!empty($this->validationRules)) {
            foreach ($this->validationRules as $col => $rules) {
                $rules = array_reverse($rules);
                foreach ($rules as $rule) {
                    if (!isset($data[$col])) {
                        continue;
                    }

                    $value = trim($data[$col]);
                    $ruleName = $rule;

                    if (preg_match("/^min:[0-9]+$/", $rule)) {
                        $rule = 'min';
                    } elseif (preg_match("/^max:[0-9]+$/", $rule)) {
                        $rule = 'max';
                    } else {
                        $rule = $rule; // Use the rule directly if it's not a min/max rule
                    }

                    switch ($rule) {
                        case 'required':
                            if (empty($value))
                                $this->errors[$col] = "The " . $col . ' is required.';
                            break;

                        case 'unique':
                            if ($this->first([$col => $value])) {
                                $this->errors[$col] = "The " . $col . ' must be unique.';
                            }
                            break;

                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL))
                                $this->errors[$col] = "The " . $col . ' must be a validate email.';
                            break;

                        case 'alpha':
                            if (!preg_match("/^[a-zA-Z]+$/", $value))
                                $this->errors[$col] = "The " . $col . ' must be alphabet only.';
                            break;

                        case 'alpha_space':
                            if (!preg_match("/^[a-zA-Z ]+$/", $value))
                                $this->errors[$col] = "The " . $col . ' must be alphabet and spaces only.';
                            break;

                        case 'alpha_numeric':
                            if (!preg_match("/^[a-zA-Z0-9]+$/", $value))
                                $this->errors[$col] = "The " . $col . ' must be alphabet with numbers only.';
                            break;

                        case 'alpha_symbol':
                            if (!preg_match("/^[a-zA-Z\-\_\%\?\!\[\]\{\}\(\)]+$/", $value))
                                $this->errors[$col] = "The " . $col . ' must be alphabet with symbols only.';
                            break;

                        case 'min':
                            show($rule);
                            $string_with_number = $ruleName;
                            $parts = explode(":", $string_with_number);
                            show($parts);
                            if (isset($parts[1])) {
                                $number_part = $parts[1];
                                if (strlen($value) < $number_part) {
                                    $this->errors[$col] = "The " . $col . ' must be at least ' . $number_part . ' characters.';
                                }
                            } else {
                                $this->errors[$col] = "Invalid rule format.";
                            }
                            break;

                        case 'max':
                            $string_with_number = $ruleName;
                            $parts = explode(":", $string_with_number);
                            $number_part = $parts[1];
                            if (strlen($value) > $number_part) {
                                $this->errors[$col] = "The " . $col . ' must no longer than ' . $number_part . ' characters.';
                            }
                            break;

                        default:
                            $this->errors['rules'] = "The Rule " . $rule . ' was not found!';
                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }

    public function getError($key)
    {
        if (!empty($this->errors[$key])) {
            return $this->errors[$key];
        }
        return '';
    }
}
