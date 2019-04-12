<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 19:59
 */

namespace App\Http\Controllers;

use Backpack\MenuCRUD\app\Models\MenuItem;
use Illuminate\Support\Facades\View;


class BaseController extends Controller
{
    public function __construct()
    {
        $menuItems = MenuItem::all();
        View::share('menuItems', $menuItems);
    }
}