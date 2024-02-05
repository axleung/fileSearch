<?php

namespace app\controllers;

/**
 * Home controller
 */

use app\models\Home;
use core\base\Controller;


class HomeController extends Controller
{
    public function index()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        if (empty(trim($keyword))) {
            $items = ['Invalid keyword'];
        } else {
            $items = (new Home())->search($keyword);
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($items);
        exit;
    }
}
