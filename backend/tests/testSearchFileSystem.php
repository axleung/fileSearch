<?php
require_once('ElementService.php');

function testSearchFileSystem()
{


    $db = Db::connectDB();
    $searcher = new ElementService($db);
    $results =  $searcher->getElements('Image');
    $expected = ["C:\\Documents\\Images\\Image1.jpg", "C:\\Documents\\Images\\Image2.jpg"];

    if ($results === $expected) {
        echo "Test Passed\n";
    } else {
        echo "Test Failed\n";
    }
}

// Run the test
testSearchFileSystem();
