<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\StatusSupplyOrder;
use App\Models\Supply;
use App\Models\SupplyOrder;
use App\Models\SupplyOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $supplyOrder = SupplyOrder::create([
            'status'        => 4,
            'total'         => 0,
            'created_at'    => Carbon::now()
        ]);
        return redirect()->route('pesanan.show', $supplyOrder->id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SupplyOrder::findOrFail($id);
        return view('manager.pesan.create', [
            'title' => 'pesanan',
            'subtitle' => 'create',
            'active' => 'pesanan',
            'data' => $data
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
    public function update(Request $request, SupplyOrder $pesanan)
    {
        // dd($pesanan);
        $pesanan->update([
            'status' => 1
        ]);
        $status = StatusSupplyOrder::where('id', $pesanan->status)->first();
        return redirect()->route('pesanan.index')->with('success_msg', 'Data Pesanan Bahan Baku berhasil ditambahkan dengan status '.$status->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SupplyOrder::where('id', $id)->first();
        $target = SupplyOrderDetail::where('supply_order_id', $data->id)->get();
        foreach ($target as $t) {
            $t->delete();
        }
        $data->delete();
        return redirect()->route('pesanan.index')->with('success_msg', 'data berhasil dihapus');
    }

    public function getPrice(Request $request, $id){
        if ($request->ajax()) {
            return Supply::where('id', $id)->first();
        }
    }

    public function getAllSupply(Request $request){
        if ($request->ajax()) {
            return Supply::where('status', 1)->get();
        }
    }

    public function getSupplyDetailOrder(Request $request, SupplyOrder $supplyOrder)
    {   
        if ($request->ajax()) {
            $data = SupplyOrderDetail::where('supply_order_id', $supplyOrder->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $name = $row->supply->name;
                    return ucfirst($name);
                })
                ->addColumn('satuan', function($row){
                    $satuan = $row->supply->price;
                    return ucfirst($satuan);
                })
                ->addColumn('qty', function($row){
                    $qty = $row->qty;
                    return ucfirst($qty);
                })
                ->addColumn('price', function($row){
                    $price = $row->total_harga;
                    return ucfirst($price);
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-success btn-sm btn-icon mt-1" onclick="plusItem('.$row->supply->id.')" data-toggle="tooltip" data-placement="top" title="Kurangi Kuantitas">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-icon mt-1" onclick="minusItem('.$row->supply->id.')" data-toggle="tooltip" data-placement="top" title="Kurangi Kuantitas">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-icon mt-1" onclick="removeItem('.$row->supply->id.')" data-toggle="tooltip" data-placement="top" title="Hapus Bahan Baku">
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
                ->addColumn('nama_item', function($row){
                    $nama_item = '<ul>';
                    foreach ($row->order_supply_detail as $a) {
                        $nama_item .= '<li>'.$a->supply->name.' '.$a->qty.' item </li>';
                    };
                    $nama_item .= '</ul>';
                    return $nama_item;
                })
                ->addColumn('price_total', function($row){
                    $satuan = $row->total;
                    return $satuan;
                })
                ->addColumn('status', function($row){
                    // $status = $row->status;
                    $status = StatusSupplyOrder::where('id', $row->status)->first();
                    return $status->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    if ($row->status == 4) {
                        $actionBtn = '<a href='.route("pesanan.show", $row->id).' class="btn btn-info btn-sm btn-icon">
                                    <i class="fas fa-info"></i>
                                    Detail
                                </a>';
                    } elseif ($row->status == 3) {
                        $actionBtn = '<a href=# class="btn btn-primary btn-sm btn-icon" onclick="updateStatus('.$row->id.')">
                                        <i class="fas fa-info"></i>
                                        Selesai
                                    </a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action', 'nama_item'])
                ->make(true);
        }
    }

    public function storeDetailOrderSupply(Request $request)
    {
        if ($request->ajax()) {
            $data = SupplyOrder::where('id', $request->id)->first();
            $data->update(['total' => $data->total += $request->total]);
            SupplyOrderDetail::create([
                'supply_order_id'   => $request->id,
                'supply_id'         => $request->supply_id,
                'total_harga'       => $request->total,
                'qty'               => $request->qty,
            ]);
            return response()->json([
                'message'   => 'Data berhasil ditambahkan ke list order',
            ]);
        } else {
            $message = 'only ajax request';
            return response()->json([
                'message' => $message,
            ]);
        }
    }

    public function deleteDetailOrderSupplyItem(Request $request, SupplyOrder $supplyOrder, Supply $supply)
    {
        if ($request->ajax()) {
            $data = $this->cekDetailOrderSupplyItem($supplyOrder->id, $supply->id);
            $supplyOrder = $this->cekOrderSupply($supplyOrder->id);
            $supplyOrder->total = ($supplyOrder->total - $data->total_harga);
            $supplyOrder->save();
            $data->delete();
            return response()->json([
                'data' => $data,
                'message' => 'hapus detail order supply berhasil',
            ]);
        }
    }

    public function minusDetailOrderSupplyItem(Request $request, SupplyOrder $supplyOrder, Supply $supply)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $data = $this->cekDetailOrderSupplyItem($supplyOrder->id, $supply->id);

            $this->updateOrderSupply($user->id, $supplyOrder->id);
            $this->updateQtyDetailMinus($supplyOrder->id, $supply->id);

            return response()->json([
                // 'obat' => $medicine,
                'data' => $data,
                'message' => 'update detail order supply berhasil',
            ]);
        }
    }

    public function plusDetailOrderSupplyItem(Request $request, SupplyOrder $supplyOrder, Supply $supply)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $data = $this->cekDetailOrderSupplyItem($supplyOrder->id, $supply->id);

            $this->updateOrderSupply($user->id, $supplyOrder->id);
            $this->updateQtyDetailPlus($supplyOrder->id, $supply->id);

            return response()->json([
                'data' => $data,
                'message' => 'update detail order supply berhasil',
            ]);
        }
    }

    public function getSupplyOrder(Request $request)
    {
        return response()->json([
            'data' => $this->cekOrderSupply($request->id),
            'message' => 'update detail order supply berhasil',
        ]);
    }

    protected function cekOrderSupply($supply_order_id)
    {
        return SupplyOrder::where('id', $supply_order_id)->first();
    }

    protected function cekDetailOrderSupplyItem($supply_order_id, $supply_id)
    {
        return SupplyOrderDetail::where('supply_order_id', $supply_order_id)->where('supply_id', $supply_id)->first();
    }

    protected function cekSupplyItem($supply_id)
    {
        return Supply::where('id', $supply_id)->first();
    }

    protected function updateOrderSupply($user_id, $transaction_id)
    {
        $transaksi = SupplyOrder::findOrFail($transaction_id);
        $transaksi->updated_by = $user_id;
        $transaksi->save();
    }

    protected function updateQtyDetailMinus($supply_order_id, $supply_id)
    {
        $supplyOrder = $this->cekOrderSupply($supply_order_id);
        $detail = $this->cekDetailOrderSupplyItem($supply_order_id, $supply_id);
        $supply = $this->cekSupplyItem($supply_id);
        $detail->qty = $detail->qty - 1;
        $detail->total_harga = $detail->total_harga - $supply->price;
        $supplyOrder->total = $supplyOrder->total - $supply->price;
        $supplyOrder->save();
        $detail->save();
    }
    
    protected function updateQtyDetailPlus($supply_order_id, $supply_id)
    {
        $supplyOrder = $this->cekOrderSupply($supply_order_id);
        $detail = $this->cekDetailOrderSupplyItem($supply_order_id, $supply_id);
        $supply = $this->cekSupplyItem($supply_id);
        $detail->qty = $detail->qty + 1;
        $detail->total_harga = $detail->total_harga + $supply->price;
        $supplyOrder->total = $supplyOrder->total + $supply->price;
        $supplyOrder->save();
        $detail->save();
    }

    public function updateStatus(Request $request, $id)
    {
        $data = SupplyOrder::where('id', $id)->first();
        $message = '';
        if ($data) {
            if ($data->status == 3) {
                $detailSupply = SupplyOrderDetail::where('supply_order_id', $data->id)->get();
                foreach ($detailSupply as $d) {
                    $target = Supply::where('id', $d->supply_id)->first();
                    $stockExisting = $target->stock;
                    $target->update([
                        'stock' => $stockExisting + $d->qty
                    ]);
                }
                $data->update([
                        'status' => 5
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
