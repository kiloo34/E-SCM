<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard', [
            'title' => 'dashboard',
            'subtitle' => '',
            'active' => 'dashboard',
        ]);
    }
}
