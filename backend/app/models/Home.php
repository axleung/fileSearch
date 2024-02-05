<?php

namespace app\models;

/**
 * Home model
 */
require_once 'ElementService.php';

use FileSystem\Service\ElementService;

use core\base\Model;
use core\db\Db;


class Home extends Model
{

    public function __construct()
    {
        if (is_null(parent::$db)) {
            parent::$db = Db::connectDB();
            //load file system
            parent::$model = new ElementService(parent::$db);
            parent::$model->loadFile(APP_PATH . 'file_system.txt');
        }
    }
    public function search($keyword)
    {

        $array = parent::$model->getElements($keyword);
        $returnArr = [];

        // print_r($array);
        foreach ($array as $result) {
            $path = $result->getName();
            while ($result->getparentID() != null) {

                $result = parent::$model->getElement($result->getparentID());
                $fileName  = str_replace(array('/', '\\'), '', $result->getName());
                $path = $fileName . DIRECTORY_SEPARATOR . $path;
            }
            array_push($returnArr, $path);
        }
        //retrun array with name to the client
        //returnArr length is 0 if no result found
        if (count($returnArr) == 0)
            return ['Not Found'];
        else
            return $returnArr;
    }
}
