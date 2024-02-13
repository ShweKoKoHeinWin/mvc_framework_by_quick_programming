<?php

class Model
{
    use Database;

    protected $table = 'users';
    protected $limit = 10;
    protected $offset = 0;

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

        $query .= " limit {$this->limit} offset {$this->offset}";

        $data = array_merge($data, $data_not);

        return $this->run($query, $data);
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

        $query .= " limit {$this->limit} offset {$this->offset}";

        $data = array_merge($data, $data_not);

        return $this->run($query, $data);
    }

    public function orWhere(array $data, array $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $query = "SELECT * FROM `{$this->table}` WHERE ";

        foreach ($keys as $key) {
            $query .= $key . '= :' . $key . ' OR ';
        }

        foreach ($keys_not as $key) {
            $query .= $key . '!= :' . $key . ' OR ';
        }

        $query = trim($query, ' OR ');

        $query .= " limit {$this->limit} offset {$this->offset}";

        $data = array_merge($data, $data_not);

        return $this->run($query, $data);
    }

    public function create($data)
    {
        $keys = array_keys($data);
        show($keys);
        $query = "INSERT INTO `{$this->table}` ( " . implode(',', $keys) . " ) VALUES ( :" . implode(', :', $keys) . " )";

        return $this->run($query, $data);
    }

    public function update($id, $data)
    {
        $query = "SELECT * FROM `users`";
        $users = $this->query($query);
        return $users;
    }

    public function delete(array $data, array $data_not = [])
    {
        $result = $this->orWhere($data, $data_not);

        $ids = [];
        if ($result) {
            show($result);
            foreach ($result as $val) {
                $ids[] = $val->id;
            }
            $placeHolder = rtrim(str_repeat('?, ', count($ids)), ', ');

            $query = "DELETE FROM `{$this->table}` WHERE id IN ({$placeHolder})";
            show($query);
            $this->run($query, $ids);
        }
    }
}
