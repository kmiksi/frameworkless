<?php

class FrontController {

    /**
     * Centralized entry point for handling requests.
     * Call apropriate controller based on URL
     */
    public function __construct() {
        // filter controller, action and params
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL); // $_GET['url']
        $url_params = explode('/', trim($url, '/'));

        // store first and seccond params, removing them from params list
        $url_controller = array_shift($url_params);
        $url_action = array_shift($url_params);

        require_once APP . 'config.php';

        // default method and action
        if (empty($url_controller)) {
            $url_controller = AppConfig::DEFAULT_CONTROLLER;
        }
        if (empty($url_action)) {
            $url_action = AppConfig::DEFAULT_ACTION;
        }

        // load requested controller
        if (file_exists(APP . "Controller/$url_controller.php")) {
            require CORE . "Controller.php";
            require CORE . "Model.php";
            require APP . "Controller/$url_controller.php";
            $controller = new $url_controller();

            // verify if action is valid
            if (method_exists($controller, $url_action)) {
                call_user_func_array(array($controller, $url_action), $url_params);
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
            header('location: ' . BASE_URL . 'error');
        } else {
            die('Sorry, the requested content could not be found');
        }
    }

}
