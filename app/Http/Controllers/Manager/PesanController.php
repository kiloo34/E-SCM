<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.pesan.index', [
            'title' => 'pesanan',
            'subtitle' => '',
            'active' => 'pesanan',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.pesan.create', [
            'title' => 'pesanan',
            'subtitle' => 'create',
            'active' => 'pesanan',
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

    public function getPrice(Request $request, $id){
        if ($request->ajax()) {
            return Supply::findOrFail($id)->first();
        }
    }

    public function getAllSupply(Request $request){
        if ($request->ajax()) {
            return Supply::where('status', 1)->get();
        }
    }

    public function getSupplyDetailOrder(Request $request)
    {   
        if ($request->ajax()) {
            $data = SupplyOrder::where('status', 6)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $name = $row->name;
                    return ucfirst($name);
                })
                ->addColumn('satuan', function($row){
                    $satuan = $row->order_supply_detail->supply->price;
                    return ucfirst($satuan);
                })
                ->addColumn('qty', function($row){
                    $qty = $row->order_supply_detail->qty;
                    return ucfirst($qty);
                })
                ->addColumn('price', function($row){
                    $price = $row->order_supply_detail->total_harga;
                    return ucfirst($price);
                })
                ->addColumn('action', function($row){
                    // $actionBtn = '<button type="button" class="btn btn-danger btn-sm btn-icon" onclick="addDetail('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Tambah Bahan Baku">
                    //                 <i class="fas fa-minus"></i>
                    //             </button>';
                    $actionBtn = '<button type="button" class="btn btn-danger btn-sm btn-icon" onclick="updateItem('.$row->order_supply_detail->id.')" data-toggle="tooltip" data-placement="top" title="Kurangi Kuantitas">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="removeItem('.$row->order_supply_detail->id.')" data-toggle="tooltip" data-placement="top" title="Hapus Bahan Baku">
                                    <i class="fas fa-trash"></i>
                                </button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getAllSupplyOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = SupplyOrder::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_item', function($row){
                    $total_item = count($row->order_supply_detail);
                    return ucfirst($total_item);
                })
                ->addColumn('price_total', function($row){
                    $satuan = $row->total;
                    return ucfirst($satuan);
                })
                ->addColumn('status', function($row){
                    $qty = $row->status;
                    return ucfirst($qty);
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-info btn-sm btn-icon" onclick="updateItem('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Detail Pesanan">
                                    <i class="fas fa-info"></i>
                                </button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
