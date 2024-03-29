<?php

namespace Controllers;

defined('ROOTPATH') or exit("Access Denied.");
class Home
{
    use \Core\Controller;
    public function index()
    {
        // show($_SESSION);
        // if (empty($_SESSION['USER'])) {
        //     redirect('login');
        //     $data['username'] = 'User';
        // } else if (!empty($_SESSION['USER']->name)) {
        //     $data['username'] = $_SESSION['USER']->name;
        // } else {
        //     $data['username'] = $_SESSION['USER']['name'];
        // }

        $file = 'assets/images/testing.png';
        $image = new \Core\Image;
        $data['thumbnail'] = $image->getThumbnail($file, 2000, 100);
        $data['file'] = $file;
        $this->view('home', $data);
    }
}
