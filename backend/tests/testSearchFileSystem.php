<?php
define('APP_PATH', str_replace( 'tests', '', __DIR__ ));

$config = require(APP_PATH . 'config/config.php');
define('DB_HOST', $config['db']['host']);
define('DB_NAME', $config['db']['dbname']);
define('DB_PASS', $config['db']['password']);
define('DB_USER', $config['db']['username']);



require_once(APP_PATH . 'core/db/Db.php');
require_once(APP_PATH . 'app/models/ElementService.php');

use core\db\Db;
use FileSystem\Service\ElementService;

function testSearchFileSystem()
{

    
    $db = Db::connectDB();
    $searcher = new ElementService($db);
    $results =  $searcher->getElements('Image');
    $returnArr = [];
    foreach ($results as $result) {
        $path = $result->getName();
        while ($result->getparentID() != null) {

            $result = $searcher->getElement($result->getparentID());

            $fileName  = str_replace(array('/', '\\'), '', $result->getName());
            $path = $fileName . DIRECTORY_SEPARATOR . $path;

        }
        array_push($returnArr, $path);
    }



    $expected = [
        "C:\\Documents\\Images",  
        "C:\\Documents\\Images\\Image1.jpg",
     "C:\\Documents\\Images\\Image2.jpg",
     "C:\\Documents\\Images\\Image3.jpg"

    ];

    if ($returnArr === $expected) {
        echo "Test Passed\n";
    } else {
        echo "Test Failed\n";
    }
}

// Run the test
testSearchFileSystem();
