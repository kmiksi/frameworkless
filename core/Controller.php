<?php

class Controller {

    /** @var Model */
    public $model = null;
    public $render = true;

    public function render($view = null, $layout = null) {
        if ($this->render) {

            $this->render = false; // already rendered
        }
    }

    public function view($path) {
        require APP . 'View/' . $path;
    }

}
