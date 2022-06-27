<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\StatusSupply;
use App\Models\Supply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.supply.index', [
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
        return view('supplier.supply.create', [
            'title' => 'supply',
            'subtitle' => 'create',
            'active' => 'supply',
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
        // dd($request->qty);

        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:supplies,name',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required',
        ], [
            'name.unique' => 'Tipe Obat sudah ditambahkan',
            'name.regex' => 'Tipe Obat harus huruf',
            'name.required' => 'Nama harap diisi',
            'qty.required' => 'Stok harap diisi',
            'qty.numeric' => 'Stok harus angka',
            'price.required' => 'Harga harap diisi',
            'price.numeric' => 'Harga harus angka',
            'status.required' => 'Status harap diisi',
        ]);
        
        $data = Supply::create([
            'name' => $request->name,
            'stock' => $request->qty,
            'price' => $request->price,
            'status' => $request->status,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('supplier.index')->with('success_msg', 'Bahan Baku ' . $data->name . ' berhasil ditambah');
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
        $data = Supply::where('id', $id)
                    ->where('deleted_at', NULL)
                    ->first();
        $data->status == 1 ? $data->update(['status'=>2]) : $data->update(['status'=>1]);
        return response()->json([
            // 'data' => $this->cekOrderSupply($request->id),
            'message' => 'update data berhasil',
        ]);
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
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $obat = $row->name;
                    return ucfirst($obat);
                })
                ->addColumn('stock', function($row){
                    $stock = $row->stock;
                    return ucfirst($stock);
                })
                ->addColumn('status', function($row){
                    $status = $row->status;
                    return $status == 1 ? 'Tersedia' : 'Tidak Tersedia';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    if ($row->status == 1) {
                        $actionBtn .= '<button type="button" class="btn btn-info btn-sm btn-icon" onclick="updateItem('.$row->id.')">
                                    <i class="fas fa-info"></i>
                                    Ubah ke Tidak Tersedia
                                </button>';
                    } else {
                        $actionBtn .= '<button type="button" class="btn btn-info btn-sm btn-icon" onclick="updateItem('.$row->id.')">
                                    <i class="fas fa-info"></i>
                                    Ubah ke Tersedia
                                </button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getStatusSupply(Request $request)
    {   
        if ($request->ajax()) {
            return StatusSupply::all();
        }
    }
}
