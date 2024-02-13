<?php

trait Database
{
    private function connect()
    {
        $string = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $con = new PDO($string, DB_USER, DB_PASSWORD);
        return $con;
    }

    public function query($query, $data = [])
    {
        $con = $this->connect();

        $stm = $con->prepare($query);
        show($stm);
        $check = $stm->execute($data);
        show($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }
        return false;
    }

    public function get($query, $data = [])
    {
        $con = $this->connect();

        $stm = $con->prepare($query);
        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }
        return false;
    }

    public function run($query, $data)
    {
        $result = $this->query($query, $data);
        if ($result) {
            return $result;
        }
        return false;
    }
}