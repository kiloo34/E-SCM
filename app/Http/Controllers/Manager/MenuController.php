<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuDetail;
use App\Models\StatusMenu;
use App\Models\Supply;
use Carbon\Carbon;
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
        $request->validate([
            'kategori' => 'required',
            'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:menus,name',
            'harga' => 'required|numeric'
        ], [
            'name.unique' => 'Menu sudah ditambahkan',
            'name.regex' => 'Menu harus huruf',
            'name.required' => 'Menu harap diisi',
            'kategori.required' => 'Field Kategori harap diisi',
            'harga.numeric' => 'Harga harus Angka',
            'harga.required' => 'Harga harap diisi'
        ]);

        Menu::create([
            'name'          => $request->name,
            'harga'         => $request->harga,
            'created_at'    => Carbon::now(),
            'kategori_id'   => $request->kategori,
            'status'        => 2
        ]);
        return redirect()->route('menu.index')->with('success_msg', $request->name.' Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return view('manager.menu_detail.index', [
            'title' => 'menu',
            'subtitle' => 'detail',
            'active' => 'menu',
            'menu' => $menu
        ]);
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
            $data = Menu::where('deleted_at', NULL)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $menu = $row->name;
                    return ucfirst($menu);
                })
                ->addColumn('harga', function($row){
                    $harga = $row->harga;
                    return ucfirst($harga);
                })
                ->addColumn('stock', function($row){
                    $stock = $row->stock;
                    return $stock == 0 ? 'stock kosong' : $stock;
                })
                ->addColumn('status', function($row){
                    $status = StatusMenu::where('id', $row->status)->first();
                    return $status->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href='.route("menu.show", $row->id).' class="btn btn-info btn-sm btn-icon" onclick="" data-toggle="tooltip" data-placement="top" title="Detail Menu">
                                    <i class="fas fa-info"></i>
                                </a>
                                <a href='.route("manager.menu.addStock", $row->id).' class="btn btn-success btn-sm btn-icon mr-1" onclick="" data-toggle="tooltip" data-placement="top" title="Tambah Stok">
                                    <i class="fas fa-plus"></i>
                                </a>';
                    if ($row->status == 1) {
                        $actionBtn .= '<button type="button" class="btn btn-danger btn-sm btn-icon" onclick="emptyStock('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Kosongkan Stok">
                                    <i class="fas fa-trash"></i>
                                </button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getSupplyField(Request $request)
    {   
        if ($request->ajax()) {
            return response(Supply::where('deleted_at', null)->get());
        }
    }

    public function getDetailSupplyMenu(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = MenuDetail::where('menu_id', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $name = $row->supply->name;
                    return ucfirst($name);
                })
                ->addColumn('stock', function($row){
                    $qty = $row->qty;
                    return $qty;
                })
                ->addColumn('action', function($row){
                    // <button type="button" class="btn btn-info btn-sm btn-icon mr-1" onclick="" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                    //                 <i class="fas fa-edit"></i>
                    //             </button>
                    $actionBtn = '
                                <form action="'.route("manager.menu.destroyDetailSupplyMenu", [$row->menu_id, $row->supply_id]).'" method="post">
                                    '.csrf_field().'
                                    '.method_field("DELETE").'
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" onclick="" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addStock(Menu $menu)
    {
        return view('manager.menu_detail.addStock', [
            'title' => 'menu',
            'subtitle' => 'addStock',
            'active' => 'menu',
            'menu' => $menu
        ]);
    }

    public function storeStock(Request $request, Menu $menu)
    {
        $request->validate([
            // 'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:menus,name',
            'kuantitas' => 'required|numeric'
        ], [
            // 'name.unique' => 'Menu sudah ditambahkan',
            // 'name.regex' => 'Menu harus huruf',
            // 'name.required' => 'Menu harap diisi',
            'kuantitas.numeric' => 'Kuantitas harus Angka',
            'kuantitas.required' => 'Kuantitas harap diisi'
        ]);

        $detailMenu = MenuDetail::where('menu_id', $menu->id)->get();

        if (count($detailMenu) != 0) {
            foreach ($detailMenu as $dm) {
                $supply = Supply::where('id', $dm->supply_id)->first();
                if ($supply->stock == 0) {
                    return redirect()->route('manager.menu.addStock', $menu->id)->with('error_msg', 'Bahan Baku Untuk Menu '.$menu->name.' Habis silakan order bahan baku ke supplier');
                } elseif ($supply->stock < $request->kuantitas) {
                    return redirect()->route('manager.menu.addStock', $menu->id)->with('error_msg', 'Tambah Kuantitas '.$menu->name.' Maksimal '.($dm->qty*$supply->stock));
                } else {
                    $total = $supply->stock - ($dm->qty * $request->kuantitas);
                    $supply->update([
                        'stock' => $total
                    ]);
                }
            }
        } else {
            return redirect()->route('manager.menu.addStock', $menu->id)->with('error_msg', 'Data Menu '.$menu->name.' tidak memiliki bahan baku tambahkan di detail menu');
        }

        $stokMenu = $menu->stock + $request->kuantitas;
        $menu->update([
            'stock' => $stokMenu,
            'status' => 1
        ]);

        return redirect()->route('menu.index')->with('success_msg', 'Stok Menu '.$menu->name.' Berhasil ditambahkan');
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            return response(Category::where('deleted_at', null)->get());
        }
    }

    public function addDetailSupplyMenu(Menu $menu)
    {
        return view('manager.menu_detail.create', [
            'title' => 'menu',
            'subtitle' => 'addStock',
            'active' => 'menu',
            'menu' => $menu
        ]);
    }

    public function storeDetailSupplyMenu(Request $request, Menu $menu)
    {
        $request->validate([
            'supply' => 'required',
            'kuantitas' => 'required|numeric'
        ], [
            // 'name.unique' => 'Menu sudah ditambahkan',
            // 'name.regex' => 'Menu harus huruf',
            'supply.required' => 'Bahan Baku Harus diisi',
            'kuantitas.numeric' => 'Field Bahan yang Dibutuhkan harus Angka',
            'kuantitas.required' => 'Field Bahan yang Dibutuhkan harap diisi'
        ]);

        MenuDetail::create([
            'menu_id' => $menu->id,
            'supply_id' => $request->supply,
            'qty' => $request->kuantitas,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('menu.show', $menu->id)->with('success_msg', 'Stok Menu '.$menu->name.' Berhasil ditambahkan');
    }
    
    public function destroyDetailSupplyMenu(Request $request, Menu $menu, $id)
    {
        $target= MenuDetail::where('menu_id', $menu->id)
                        ->where('supply_id', $id)
                        ->first();
        $target->delete();
        return redirect()->route('menu.show', $menu->id)->with('success_msg', 'Berhasil dihapus');
    }

    public function emptyStock(Request $request, Menu $menu)
    {
        $menu->update([
            'stock' => 0,
            'status' => 2
        ]);
        $message = 'Berhasil direset ke habis';
        return response()->json([
            'data' => $menu,
            'message' => $message,
        ]);
    }
}
