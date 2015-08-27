<?php

class Todo extends Controller {

    /** @var Model */
    public $Model = null;

    public function __construct() {
        $this->Model = new Model();
    }

    public function index($id = null) {
        $todos = $this->Model->query("SELECT * FROM todos ORDER BY created DESC, finished DESC");

        $this->set(compact('todos'));
    }

    public function add() {
        if ($this->requestMethodIs('post')) {
            $form_data = $this->formData(['description', 'finished']);
            $form_data[':finished'] = empty($form_data[':finished']) ? NULL : date('c');
            $result = $this->Model->query('INSERT INTO todos (description, finished) VALUES (:description, :finished)', $form_data);
            if ($result === FALSE) {
                $message = 'ERROR: Error inserting data, please try again.';
            } else {
                $message = 'SUCCESS!';
            }
            $todo = new stdClass();
            $todo->description = $form_data[':description'];
            $todo->finished = $form_data[':finished'];
        }
        $this->set(compact('todo', 'message'));
        $this->render('form');
    }

    public function copy($id = null) {
        if (!empty($id) && !$this->requestMethodIs('post')) {
            $todo = $this->Model->query('SELECT id, description FROM todos WHERE id = :id', array(':id' => $id));
            $todo = array_shift($todo);
            $this->set(compact('todo'));
        }
        $this->add();
    }

    public function edit($id = null) {
        if ($this->requestMethodIs('post')) {
            $form_data = $this->formData(['description', 'finished']);
            $form_data[':id'] = $id;
            $form_data[':finished'] = empty($form_data[':finished']) ? NULL : date('c');
            $result = $this->Model->query('UPDATE todos SET description = :description, finished = :finished WHERE id = :id', $form_data);
            if ($result === FALSE) {
                $message = 'ERROR: Error updating data, please try again.';
            } else {
                $message = 'SUCCESS!';
            }
            $todo = new stdClass();
            $todo->description = $form_data[':description'];
            $todo->finished = $form_data[':finished'];
        } else if (!empty($id)) {
            $todo = $this->Model->query('SELECT id, description, finished FROM todos WHERE id = :id', array(':id' => $id));
            $todo = array_shift($todo);
        }
        $this->set(compact('todo', 'message'));
        $this->render('form');
    }

    public function delete($id = null) {
        if (!empty($id)) {
            $result = $this->Model->query('DELETE FROM todos WHERE id = :id', array(':id' => $id));
            if ($result === FALSE) {
                $message = 'ERROR: Error deleting data, please try again.';
            } else {
                $message = 'TODO DELETED!';
            }
        }
        $this->set(compact('message'));
        $this->index();
        $this->render('index');
    }

    public function finish($id = null) {
        if (!empty($id)) {
            $result = $this->Model->query('UPDATE todos SET finished = :finished WHERE id = :id', array(':id' => $id, ':finished' => date('c')));
            if ($result === FALSE) {
                $message = 'ERROR: Error updating data, please try again.';
            } else {
                $message = 'SUCCESS!';
            }
        }
        $this->set(compact('message'));
        $this->index();
        $this->render('index');
    }

}
