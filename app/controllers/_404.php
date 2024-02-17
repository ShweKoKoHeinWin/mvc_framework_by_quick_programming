<?php

class _404
{
    use Controller;
    public function index($name)
    {
        $this->view('404');
    }
}
