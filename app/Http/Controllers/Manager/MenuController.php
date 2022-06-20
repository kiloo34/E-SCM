<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.menu.index', [
            'title' => 'menu',
            'subtitle' => '',
            'active' => 'menu',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.menu.create', [
            'title' => 'menu',
            'subtitle' => 'create',
            'active' => 'menu',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
                    $actionBtn = '<button type="button" class="btn btn-success btn-sm btn-icon" onclick="addDetail('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Tambah Stok">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="" data-toggle="tooltip" data-placement="top" title="Kosongkan Stok">
                                    <i class="fas fa-trash"></i>
                                </button>
                                ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
