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

    public function getMenu(Request $request)
    {   
        if ($request->ajax()) {
            $data = Menu::where('deleted_at', NULL)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $menu = $row->name;
                    return ucfirst($menu);
                })
                ->addColumn('stock', function($row){
                    $stock = $row->stock;
                    return $stock == 0 ? 'stock kosong' : $stock;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-success btn-sm btn-icon" onclick="addDetail('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Tambah Menu">
                                    <i class="fas fa-plus"></i>
                                </button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
