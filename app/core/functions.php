<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}


function asset($name)
{
    return ROOT . $name;
}
