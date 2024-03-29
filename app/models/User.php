<?php

namespace Model;

class User
{
    use \Core\Model;
    protected $table = 'users';
    protected $allowedColumns = [
        'name',
        'email',
        'password',
        'updated_at'
    ];

    protected $validationRules = [
        'name' => [
            'required'
        ],
        'email' => [
            'required',
            'email',
            'unique',
        ],
        'password' => [
            'required',
            'min:8'
        ]
    ];

    // public function validate($data)
    // {
    //     $this->errors = [];
    //     if (empty($data['email'])) {
    //         $this->errors['email'] = "Email is Required.";
    //     } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    //         $this->errors['email'] = 'Email is not Valid.';
    //     }

    //     if (empty($data['password'])) {
    //         $this->errors['password'] = "Password is Required.";
    //     }

    //     if (empty($data['term'])) {
    //         $this->errors['term'] = "Term need accept.";
    //     }
    //     //   

    //     if (empty($this->errors)) {
    //         return true;
    //     }
    //     return false;
    // }

    public function signup($data)
    {
        if ($this->validate($data)) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $password;
            $data['updated_at'] = date("Y-m-d H:i:s");
            $this->insert($data);
            redirect('login');
        }
    }

    public function login($data)
    {
        $row = $this->first(['email' => $data['email']]);

        if ($row) {
            if (password_verify($data['password'], $row->password)) {
                $ses = new \Core\Session;
                $ses->auth($row);
                redirect('home');
            } else {
                $this->errors['email'] = "Wrong Email or Paassword";
            }
        } else {
            $this->errors['email'] = "Wrong Email or Paassword";
        }
    }
}
