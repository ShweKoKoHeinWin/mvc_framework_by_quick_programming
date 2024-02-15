<?php

class Home extends Controller
{
    public function index($name)
    {
        $users = new User;
        // $users->create(['name' => 'Ma Aye', 'age' => 33]);
        // show($users->first(['name' => 'Ma Aye']));
        $this->view('page');
    }
}
