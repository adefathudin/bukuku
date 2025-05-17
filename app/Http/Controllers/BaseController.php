<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{

    public function __construct()
    {
        $menus = [
            'appName' => config('app.name'),
            'appVersion' => config('app.version'),
            'activeMenu' => '/' . request()->segment(1),
            'user' => auth()->user(),
            'menu' => [
                    [
                        'name' => 'Dashboard',
                        'url' => '/home',
                        'icon' => 'fa fa-home',
                    ],
                    [
                        'name' => 'Products',
                        'url' => '/products',
                        'icon' => 'fa fa-box',
                        'access' => 'admin',
                    ],
                    [
                        'name' => 'Transaction',
                        'url' => '/transaction',
                        'icon' => 'fa fa-cash-register',
                    ],
                    [
                        'name' => 'Reports',
                        'url' => '/reports',
                        'icon' => 'fa fa-chart-bar',
                    ],
                    [
                        'name' => 'Users',
                        'url' => '/users',
                        'icon' => 'fa fa-cog',
                    ],
                    [
                        'name' => 'Logout',
                        'url' => '/logout',
                        'icon' => 'fa fa-sign-out-alt',
                    ],
                ],
        ];

        View::share('menus', $menus);
    }
}
