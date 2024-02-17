<?php

class Home
{
    use Controller;
    public function index($name, $h, $i)
    {
        $model = new User;

        show($name);
        show($h);
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));
        // show($model->insert(['name' => 'Mg One', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Two', 'age' => 11]));
        // show($model->insert(['name' => 'Mg Aye', 'age' => 11]));

        $this->view('page');
    }

    public function show($h, $i)
    {
        show('showww');
        show($h);
        show($i);
    }
}
