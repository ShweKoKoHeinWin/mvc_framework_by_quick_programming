<?php
trait Model
{
    use Database;

    protected $limit = 10;
    protected $offset = 0;
    protected $order_type = 'desc';
    protected $order_column = 'id';

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
}
