<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\StatusSupplyOrder;
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
        return view('supplier.pesan.index', [
            'title' => 'pesan',
            'subtitle' => '',
            'active' => 'pesan',
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
        $data = SupplyOrder::where('id', $id)
                    ->first();
        $message = '';
        if ($data->status == 1) {
            $data->update([
                'status' => 2
            ]);
            $message = 'status order berhasil diperbarui ke menunggu pengiriman bahan baku';
        } elseif ($data->status == 2) {
            $data->update([
                'status' => 3
            ]);
            $message = 'status order berhasil diupdate menunggu selesai di distributor';
        } elseif ($data == null) {
            $message = 'Server error 505';
        }

        return response()->json([
            'message' => $message,
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

    public function getSupplyOrder(Request $request)
    {   
        if ($request->ajax()) {
            $data = SupplyOrder::whereNotIn('status', [4])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_item', function($row){
                    $nama_item = '<ul>';
                    foreach ($row->order_supply_detail as $a) {
                        $nama_item .= '<li>'.$a->supply->name.' '.$a->qty.' item </li>';
                    };
                    $nama_item .= '</ul>';
                    return $nama_item;
                })
                ->addColumn('total_item', function($row){
                    $total_item = count($row->order_supply_detail);
                    return $total_item;
                })
                ->addColumn('price_total', function($row){
                    $satuan = $row->total;
                    return $satuan;
                })
                ->addColumn('status', function($row){
                    $status = StatusSupplyOrder::where('id', $row->status)->first();
                    return $status->name;
                })
                ->addColumn('action', function($row){
                    // $actionBtn = '<button type="button" class="btn btn-info btn-sm btn-icon mr-1" onclick="updateItem('.$row->id.')">
                    //                 <i class="fas fa-info"></i>
                    //                 Detail
                    //             </button>';
                    $actionBtn = '';
                    if ($row->status == 1) {
                        $actionBtn .= '<button type="button" class="btn btn-primary btn-sm btn-icon mt-1 mr-1" onclick="updateItem('.$row->id.')">
                                        <i class="fas fa-edit"></i>
                                        Terima
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-icon mt-1" onclick="cancelItem('.$row->id.')">
                                        <i class="fas fa-trash"></i>
                                        Tolak
                                    </button>';
                    } elseif ($row->status == 2) {
                        $actionBtn .= '<button type="button" class="btn btn-primary btn-sm btn-icon mr-1" onclick="updateItem('.$row->id.')">
                                        <i class="fas fa-edit"></i>
                                        Kirim
                                    </button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action', 'nama_item'])
                ->make(true);
        }
    }

    public function cancelOrder(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = SupplyOrder::where('id', $id)->first();
            $message = '';
            if ($data) {
                $data->update([
                    'status' => 6
                ]);
                $message = 'Order Bahan Baku Berhasil di Tolak';
            } else {
                $message = 'data tidak ditemukan';
            }
            return response()->json([
                // 'data' => $this->cekOrderSupply($request->id),
                'message' => $message,
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $data = SupplyOrder::where('id', $id)->first();
        $message = '';
        if ($data) {
            if ($data->status == 1) {
                SupplyOrder::where('id', $id)
                    ->update([
                        'status' => 2    
                    ]);
                $message = 'Data Berhasil di Perbarui';
            } elseif ($data->status == 2) {
                SupplyOrder::where('id', $id)
                    ->update([
                        'status' => 3    
                    ]);
                $message = 'Data Berhasil di Perbarui';
            } 
        } else {
            $message = 'data tidak ditemukan';
        }
        return response()->json([
            'data' => $data,
            'message' => $message,
        ]);
    }
}
