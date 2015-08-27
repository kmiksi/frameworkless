<?php

class Controller {

    /** @var Model */
    public $model = null;
    public $render = true;

    public function render($view, $layout = 'default') {
        if ($this->render) { // prevent rendering the same action twice
            $this->view('layout/' . $layout . '_start.php');
            $this->view($view);
            $this->view('layout/' . $layout . '_end.php');

            $this->render = false; // already rendered
        }
    }

    public function view($path) {
        require APP . 'View/' . $path;
    }

}
