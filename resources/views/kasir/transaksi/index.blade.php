@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Menu</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="menu-table">
                        <thead>
                            <th class="text-center">#</th>
                            <th>{{__('Nama')}}</th>
                            <th>{{__('stok')}}</th>
                            <th>{{__('aksi')}}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail Order </h4>
            </div>
            <div class="card-body">
                @if ($transaksi)
                <form action="{{ route('kasir_transaksi.update', $transaksi->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-striped" id="detail-table">
                            <thead>
                                <th class="text-center">#</th>
                                <th>{{__('Nama')}}</th>
                                <th>{{__('harga')}}</th>
                                <th>{{__('kuantitas')}}</th>
                                <th>{{__('total')}}</th>
                                <th>{{__('aksi')}}</th>
                            </thead>
                        </table>
                    </div>
                    @if ($transaksi != null)
                    <input type="hidden" name="id_transaksi" value="{{$transaksi->id}}">
                    @endif
                    <div class="d-flex justify-content-between mt-3">
                        <span>
                            <span class="float-left">Total Harga</span><br>
                            <span class="float-left" id="total-harga">0</span>
                        </span>
                        <input type="submit" class="btn btn-success float-right" id="button-submit" value="Buat Transaksi">
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var idTransaksi = {{$transaksi_js}};
    $(document).ready(function() { 
        cekTransaksi(idTransaksi);
        $('#menu-table').DataTable({
            "language": {
                "emptyTable": "Menu Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('kasir.transaksi.getMenu') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'stock', name: 'stock'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
        $('#menu-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
        $('#detail-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    })

    function cekTransaksi(dataTransaksi) {
        if (dataTransaksi == undefined) {
            var url = "{{ route('kasir_transaksi.store') }}";
            createTransaksi(url)
        } else {
            var id = dataTransaksi
            detailTable(id)
        }
    }

    function createTransaksi(url) {
        $.ajax({
            url: url,
            type: 'POST',
            success: function (response) {
                console.log('masuk success');
                console.log(response);
                setTimeout(function(){ location.reload(); }, 5000);
            },
            error: function (data) {
                toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
            }
        });
    }

    function detailTable(id) {
        var url = "{{ route('kasir.transaksi.getDetailTransaksi', ":id") }}"
        url = url.replace(':id', id);

        $('#detail-table').DataTable({
            "language": {
                "emptyTable": "Data Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": url,
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'harga', name: 'stock'},
                {data: 'qty', name: 'qty'},
                {data: 'total_harga', name: 'total_harga'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
    }

    function addMenu(id) {
        var transaksi_id = {{$transaksi_js}}
        var url = '{{ route("kasir.transaksi.addDetailTransaksi", [':transaksi_id', ':menu']) }}';
        url = url.replace(':transaksi_id', transaksi_id);
        url = url.replace(':menu', id);

        console.log(url);

        $.ajax({
            url: url,
            type: 'POST',
            success: function (response) {
                console.log('masuk success');
                toastEvent('Success!', response.message, 'topRight', 'success')
                reloadTable('#menu-table', 100);
                reloadTable('#detail-table', 100);
                $('#total-harga').html(response.total_master)
            },
            error: function (data) {
                console.log('masuk error');
                toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
            }
        });
    }

    function updateItem(id) {
        var transaksi_id = {{$transaksi_js}}
        var url = '{{ route("kasir.transaksi.updateItem", [':transaksi_id', ':menu']) }}';
        url = url.replace(':transaksi_id', transaksi_id);
        url = url.replace(':menu', id);
        
        // console.log(url);
        
        $.ajax({
            url: url,
            type: 'POST',
            success: function (response) {
                console.log('masuk success');
                console.log(response);
                toastEvent('Success!', response.message, 'topRight', 'success')
                reloadTable('#menu-table', 100);
                reloadTable('#detail-table', 100);
                $('#total-harga').html(response.total_master)
            },
            error: function (data) {
                // console.log('masuk error');
                toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
            }
        });
    }
    
    function removeItem(id) {
        var transaksi_id = {{$transaksi_js}}
        var url = '{{ route("kasir.transaksi.deleteItem", [':transaksi_id', ':menu']) }}';
        url = url.replace(':transaksi_id', transaksi_id);
        url = url.replace(':menu', id);
        
        $.ajax({
            url: url,
            type: 'POST',
            success: function (response) {
                console.log('masuk success');
                console.log(response);
                toastEvent('Success!', response.message, 'topRight', 'success')
                reloadTable('#menu-table', 100);
                reloadTable('#detail-table', 100);
                $('#total-harga').html(response.total_master)
            },
            error: function (data) {
                // console.log('masuk error');
                toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
            }
        });
    }

    function cekDetailTransaksi(data) {
        $('#button-submit').prop('disabled', true)
    }

    function toastEvent(title, message, position, type) {
        if (type == 'error') {
            iziToast.error({
                title: title,
                message: message,
                position: position
            });   
        } else {
            iziToast.success({
                title: title,
                message: message,
                position: position
            });
        }
    }

    function reloadTable(selector, counter) {
        setTimeout(function() {
            $(selector).DataTable().ajax.reload();
        }, 100);
    }
    
</script>
@endpush
@include('import.datatable')