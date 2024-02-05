<?php

namespace core;


defined('CORE_PATH') or define('CORE_PATH', __DIR__);


class bootstrap
{
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    // run the appliocation
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeQuotes();
        $this->setDbConfig();
        $this->route();
    }

    public function loadClass($className)
    {
        $classMap = $this->CorePath();

        if (isset($classMap[$className])) {
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }

        include_once $file;
    }


    private function CorePath()
    {
        return [
            'core\base\Controller' => CORE_PATH . '/base/Controller.php',
            'core\base\Model' => CORE_PATH . '/base/Model.php',
            'core\db\Db' => CORE_PATH . '/db/Db.php',
        ];
    }

    // set global variables
    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }
    // route handling
    public function route()
    {
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        // remove ? and after
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);

        //  index.php/{controller}/{action}
        $position = strpos($url, 'index.php');
        if ($position !== false) {
            $url = substr($url, $position + strlen('index.php'));
        }

        // remove / from the beginning and end
        $url = trim($url, '/');

        if ($url) {
            // split the url
            $urlArray = explode('/', $url);
            // remove empty elements
            $urlArray = array_filter($urlArray);

            // get controller name
            $controllerName = ucfirst($urlArray[0]);

            // get action name
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;

            // get request parameters
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }

        // check if the controller and action exist
        $controller = 'app\\controllers\\' . $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit($controller . ' Controller Not found');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . ' Action Not found');
        }

        $dispatch = new $controller($controllerName, $actionName);


        //$dispatch->$actionName($param)
        call_user_func_array(array($dispatch, $actionName), $param);
    }

    // Enable debug mode
    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    // delete slashes
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    public function removeQuotes()
    {

        $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
        $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
        $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
        $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
    }
}
