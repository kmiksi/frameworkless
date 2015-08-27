<?php

class Controller {

    /** @var bool Control the layout rendering of action */
    public $render = true;

    /** @var array Store variables to be passed to view rendering */
    public $viewVars = array();

    /**
     * Store values to be passed to view rendering
     * @param string|array $name The name of variable, or an array with name=>value (php method compact() can help you)
     * @param mixed $value
     */
    public function set($name, $value = null) {
        if (!is_array($name)) {
            $name = array($name => $value);
        }
        $this->viewVars = array_merge($this->viewVars, $name);
    }

    /**
     * Render full layout of specifyed view (once per controller instance)
     * @param string $view View name (action name)
     * @param string $layout Layout name
     */
    public function render($view, $layout = 'default') {
        if ($this->render) { // prevent rendering the same action twice
            $this->view('layout/' . $layout . '_start');
            if (!file_exists(APP . 'View/' . $view . '.php')) {
                $view = get_class($this) . '/' . $view;
            }
            $this->view($view);
            $this->view('layout/' . $layout . '_end');

            $this->render = false; // already rendered
        }
    }

    /**
     * Render a view file
     * @param string $path Path relative to View folder without extension
     */
    public function view($path) {
        extract($this->viewVars);
        require APP . 'View/' . $path . '.php';
    }

    public function requestMethodIs($type) {
        $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
        return strtoupper($request_method) === strtoupper($type);
    }

    public function formData(array $fields, $type = 'post') {
        switch (strtoupper($type)) {
            case 'POST':
                $type = INPUT_POST;
                break;
            case 'GET':
                $type = INPUT_GET;
                break;
        }
        $form_data = array();
        foreach ($fields as $field) {
            $form_data[":$field"] = filter_input($type, $field, FILTER_SANITIZE_STRING);
        }
        return $form_data;
    }

}
