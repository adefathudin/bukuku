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
                        'url' => '/',
                        'icon' => 'fa fa-home',
                    ],
                    [
                        'name' => 'Kategori',
                        'url' => '/kategori',
                        'icon' => 'fa fa-table-columns',
                    ],
                    [
                        'name' => 'Laporan',
                        'url' => '/transaksi',
                        'icon' => 'fa fa-chart-pie',
                        'access' => 'admin',
                    ],
                    [
                        'name' => 'Users',
                        'url' => '/users',
                        'icon' => 'fa fa-cog',
                        'role' => ['admin'],
                    ]
                ],
        ];

        View::share('menus', $menus);
    }
}
