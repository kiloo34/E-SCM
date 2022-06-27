<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaction::where('status', 2)->first();
        // var_dump($transaksi);
        // dd($transaksi);
        $id = '';
        if ($transaksi != null) {
            $id = $transaksi->id;
        } 
        return view('kasir.transaksi.index', [
            'title' => 'transaksi',
            'subtitle' => '',
            'active' => 'transaksi',
            'transaksi' => $transaksi,
            'transaksi_js' => $id == '' ? json_encode($transaksi) : $id
        ]);
        // } else {
            // return redirect()->route('kasir_transaksi.store');
        // }
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
        $transaksi = Transaction::create([
            'status'        => 2,
            'total'         => 0,
            'created_at'    => Carbon::now()
        ]);
        return redirect()->route('kasir_transaksi.index');
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
        $data = Transaction::where('id',$id)->first();
        $detail = TransactionDetail::where('transaction_id', $id)->get();
        if (count($detail)==0) {
            return redirect()->route('kasir_transaksi.index')->with('error_msg', 'Data detail transaksi masih kosong');
        } else {
            $data->update([
                'status' => 3
            ]);
            return redirect()->route('kasir_transaksi.index')->with('success_msg', 'Data telah diproses, dimohon menunggu!, Terima Kasih!');
        }
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
                    $actionBtn = '';
                    if ($row->stock!=0) {
                        $actionBtn .= '<button type="button" class="btn btn-success btn-sm btn-icon" onclick="addMenu('.$row->id.')" data-toggle="tooltip" data-placement="top" title="Tambah Menu">
                                    <i class="fas fa-plus"></i>
                                </button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getDetailTransaksi(Request $request, Transaction $transaksi)
    {
        if ($request->ajax()) {
            $data = TransactionDetail::where('transaction_id', $transaksi->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $menu = $row->menu->name;
                    return ucfirst($menu);
                })
                ->addColumn('harga', function($row){
                    $harga = $row->menu->harga;
                    return $harga;
                })
                ->addColumn('qty', function($row){
                    $qty = $row->qty;
                    return $qty;
                })
                ->addColumn('total_harga', function($row){
                    $total_harga = $row->total_harga;
                    return $total_harga;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-danger btn-sm btn-icon" onclick="updateItem('.$row->menu->id.')" data-toggle="tooltip" data-placement="top" title="Kurangi Kuantitas">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="removeItem('.$row->menu->id.')" data-toggle="tooltip" data-placement="top" title="Hapus Item">
                                    <i class="fas fa-trash"></i>
                                </button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addDetailTransaksi(Request $request, Transaction $transaksi, Menu $menu)
    {
        if ($request->ajax()) {
            $message = '';
            $data = TransactionDetail::where('transaction_id', $transaksi->id)->where('menu_id', $menu->id)->first();
            $updateHarga = '';
            // var_dump($data);
            if ($data != NULL) {
                $data->update([
                    'qty' => $data->qty + 1,
                    'total_harga' => $data->total_harga + (1 * $menu->harga)
                ]);
                $updateHarga = $menu->harga;
                $message = 'data berhasil diupdate';
            } else {
                TransactionDetail::create([
                    'transaction_id'    => $transaksi->id,
                    'menu_id'           => $menu->id,
                    'qty'               => 1,
                    'total_harga'       => $menu->harga
                ]);
                $updateHarga = $menu->harga;
                $message = 'data berhasil ditambahkan';
            }
            $menu->update([
                'stock' => $menu->stock - 1
            ]);
            $transaksi->update([
                'total'=> $transaksi->total + $updateHarga
            ]);
            return response()->json([
                'data' => $data,
                'total_master' => $transaksi->total,
                'message' => $message,
            ]);
        }
    }

    public function updateItem(Request $request, Transaction $transaksi, Menu $menu)
    {
        $message = '';
        if ($request->ajax()) {
            $data = TransactionDetail::where('transaction_id', $transaksi->id)->where('menu_id', $menu->id)->first();
            $updateHarga = '';
            if ($data->qty == 1) {
                $data->delete();
                $message = 'data berhasil dihapus';
                $updateHarga = $menu->harga;
            } else {
                $data->update([
                    'qty' => $data->qty - 1,
                    'total_harga' => $data->total_harga - (1 * $menu->harga)
                ]);
                $updateHarga = $menu->harga;
                $message = 'data berhasil diupdate';
            }
            $menu->update([
                'stock' => $menu->stock + 1
            ]);
            $transaksi->update([
                'total'=> $transaksi->total - $updateHarga
            ]);
            return response()->json([
                'total_master' => $transaksi->total,
                'message' => $message,
            ]);
        } else {
            $message = 'only ajax request';
            return response()->json([
                'message' => $message,
            ]);
        }
    }

    public function deleteItem(Request $request, Transaction $transaksi, Menu $menu)
    {
        $message = '';
        if ($request->ajax()) {
            $data = TransactionDetail::where('transaction_id', $transaksi->id)->where('menu_id', $menu->id)->first();
            // $updateHarga = '';
            $menu->update([
                'stock' => $menu->stock + $data->qty
            ]);
            $transaksi->update([
                'total'=> $transaksi->total - $data->total_harga
            ]);
            $data->delete();
            $message = 'Item Berhasil Dihapus';
            return response()->json([
                'total_master' => $transaksi->total,
                'message' => $message,
            ]);
        } else {
            $message = 'only ajax request';
            return response()->json([
                'message' => $message,
            ]);
        }
    }
}
