<?php
class School
{
    use Model;
    protected $table = 'users';
    protected $allowedColumns = [
        'name',
        'age'
    ];
}
