<?php

class FrontController {

    /**
     * Centralized entry point for handling requests.
     * Call apropriate controller based on URL
     */
    public function __construct() {
        // filter controller, action and params
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL); // $_GET['url']
        $params = explode('/', trim($url, '/'));

        // store first and seccond params, removing them from params list
        $controller_name = ucfirst(array_shift($params)); // uppercase classname
        $action_name = array_shift($params);

        require_once APP . 'config.php';

        // default controller and action
        if (empty($controller_name)) {
            $controller_name = AppConfig::DEFAULT_CONTROLLER;
        }
        if (empty($action_name)) {
            $action_name = AppConfig::DEFAULT_ACTION;
        }

        // load requested controller
        if (file_exists(APP . "Controller/$controller_name.php")) {
            require CORE . "Controller.php";
            require CORE . "Model.php";
            require APP . "Controller/$controller_name.php";
            $controller = new $controller_name();

            // verify if action is valid
            if (method_exists($controller, $action_name)) {
                call_user_func_array(array($controller, $action_name), $params);
                $controller->render("$controller_name/$action_name"); // skipped if already rendered
            } else {
                // action not found
                $this->notFound();
            }
        } else {
            // controller not found
            $this->notFound();
        }
    }

    /**
     * Show to user an error message
     */
    private function notFound() {
        if (file_exists(APP . 'Controller/error.php')) {
            header('Location: ' . BASE_URL . 'error');
        } else {
            die('Sorry, the requested content could not be found');
        }
    }

}
