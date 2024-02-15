<?php

trait Model
{
    use Database;

    protected $table = 'users';
    protected $limit = 10;
    protected $order_type = 'ASC';
    protected $order_column = 'id';
    protected $offset = 0;

    public function __construct()
    {
        $this->table =  strtolower(pluralize(__CLASS__));
    }

    public function all()
    {
        $query = "SELECT * FROM `{$this->table}` ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";
        return $this->query($query);
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

        return $this->run($query, $data)[0];
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

        $query .= " ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";

        $data = array_merge($data, $data_not);

        return $this->run($query, $data);
    }

    public function create($data)
    {
        $keys = array_keys($data);
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
            foreach ($result as $val) {
                $ids[] = $val->id;
            }
            $placeHolder = rtrim(str_repeat('?, ', count($ids)), ', ');

            $query = "DELETE FROM `{$this->table}` WHERE id IN ({$placeHolder})";
            $this->run($query, $ids);
        }
    }
}
