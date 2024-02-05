<?php

namespace core\base;

/**
 * Controller base class
 */
class Controller
{
    protected $_controller;
    protected $_action;

    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }
}
