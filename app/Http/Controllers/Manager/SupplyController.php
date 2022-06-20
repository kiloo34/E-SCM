<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.supply.index', [
            'title' => 'supply',
            'subtitle' => '',
            'active' => 'supply',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function getSupply(Request $request)
    {   
        if ($request->ajax()) {
            $data = Supply::where('deleted_at', NULL)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $obat = $row->name;
                    return ucfirst($obat);
                })
                ->addColumn('stock', function($row){
                    $stock = $row->stock;
                    return $stock;
                })
                ->addColumn('status', function($row){
                    $status = $row->status;
                    return $status == 1 ? 'Tersedia di Supplier' : 'Tidak Tersedia di Supplier';
                })
                // ->addColumn('action', function($row){
                //     $actionBtn = '<button type="button" class="btn btn-success btn-sm btn-icon" onclick="addDetail('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Tambah Bahan Baku">
                //                     <i class="fas fa-plus"></i>
                //                 </button>';
                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
        }
    }
}
