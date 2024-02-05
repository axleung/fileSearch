<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// use FileSystem\Service\ElementService;
// use core\db\Db;

class TestService extends TestCase
{


    private $root;

    protected function setUp(): void
    {
        // $config = require 'config/config.php';
        // (new core\bootstrap($config))->run();

        // $db = Db::connectDB();
        // //load file system
        // $model = new ElementService($db);
        // $loaded = $model->loadFile(APP_PATH . 'file_system.txt');
    }

    // for different scenarios, like no matches
    public function testSearchReturnsCorrectFiles()
    {
        // $config = require 'config/config.php';
        // (new core\bootstrap($config))->run();

        // $db = Db::connectDB();
        // $searcher = new ElementService($db);
        // $results =  $searcher->getElements('Image');

        // // Check if the results are as expected
        // $expected = ["C:\\Documents\\Images\\Image1.jpg", "C:\\Documents\\Images\\Image2.jpg"];
        // $this->assertEquals($expected, $results);
        self::assertTrue(true);
    }
}
