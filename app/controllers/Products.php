<?php

class Products extends Controller
{
    public function index($name)
    {
        $this->view('products/index');
    }
}
