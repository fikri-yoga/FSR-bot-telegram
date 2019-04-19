<?php

class Controller{
    public function view($view)
    {
        require_once 'app/views/' . $view . '.php';
        return new $view;
    }

    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model;
    }
}
