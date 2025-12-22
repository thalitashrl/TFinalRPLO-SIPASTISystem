<?php

class Controller {
    // Method untuk memanggil file model
    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    // Method untuk memanggil file view
    public function view($view, $data = []) {
        require_once 'app/views/' . $view . '.php';
    }
}