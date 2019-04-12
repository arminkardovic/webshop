<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 20:00
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return view("welcome");
    }
}