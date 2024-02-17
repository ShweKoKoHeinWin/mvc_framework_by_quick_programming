<?php

class User
{
    use Model;
    protected $table = 'users';
    protected $allowedColumns = [
        'name',
        'email',
        'password'
    ];

    public function validate($data)
    {
        $this->errors = [];
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is Required.";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not Valid.';
        }

        if (empty($data['password'])) {
            $this->errors['password'] = "Password is Required.";
        }

        if (empty($data['term'])) {
            $this->errors['term'] = "Term need accept.";
        }
        //   

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }
}
