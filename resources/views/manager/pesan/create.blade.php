@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Buat Pesanan {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <form action="{{ route('pesanan.destroy', $data->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" value="Batalkan" class="btn btn-danger">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.update', $data->id) }}" method="POST" id="final-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="list_supply_order_id" name="supply_order_id" value="{{$data->id}}">
                    <div class="table-responsive">
                        <table id="detail-supply-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('#')}}</th>
                                    <th>{{__('Nama')}}</th>
                                    <th>{{__('@')}}</th>
                                    <th>{{__('Kuantitas')}}</th>
                                    <th>{{__('Total Harga')}}</th>
                                    <th>{{__('Aksi')}}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th colspan="4" class="text-right">{{__('Total')}}</th>
                                <th colspan="2" id="kolom-hasil">{{$data->total}}</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col text-center">
                        <input type="submit" value="Buat Pesanan" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="#" id="detail-form" method="post">
                    @csrf
                    <input type="hidden" id="supply_order_id" name="supply_order_id" value="{{$data->id}}">
                    <div class="form-group">
                        <label>{{__('Nama')}}</label>
                        <select name="name" id="name" class="form-control @error('tipe') is-invalid @enderror"></select>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Kuantitas')}}</label>
                                <input name="qty" id="qty" type="number" class="form-control @error('qty') is-invalid @enderror"
                                    value="{{ old('qty') }}" autocomplete="qty" onkeyup="totalHarga()" autofocus>
                                @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Harga')}}</label>
                                <input name="price" id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" autocomplete="price" autofocus readonly>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__('Total Harga')}}</label>
                        <input name="total" id="total" type="text" class="form-control @error('total') is-invalid @enderror"
                            value="{{ old('total') }}" autocomplete="total" autofocus readonly>
                        @error('total')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary float-right" value="Tambah">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $("#name").select2();
        getNama();
        
        var urlDetailOrder = "{{ route('manager.getSupplyDetailOrder', ":id") }}"
        var id = $('#list_supply_order_id').val()
        urlDetailOrder = urlDetailOrder.replace(':id', id)

        $('#detail-supply-table').DataTable({
            "language": {
                "emptyTable": "Data Order Supply Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": urlDetailOrder,
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'satuan', name: 'satuan',orderable: false, searchable: false}, 
                {data: 'qty', name: 'qty'}, 
                {data: 'price', name: 'price'}, 
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
        $('#supply-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
        updateTotal();
    });

    function getNama() {
        var url = '{{ route("manager.getAllSupply") }}';
        var select = $('#name');
        const a = '<option value=null>Pilih Nama Bahan Baku</option>'

        $.get(url, function(data) {
            // console.log(data);
            select.empty();
            select.append(a)
            $.each(data, function(key, value) {
                console.log(value);
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    }

    function updateTotal() {
        var supplyOrder = {{ $data->id }}
        var url = "{{ route('manager.getSupplyOrder', ":supplyOrder") }}"
        url = url.replace(':supplyOrder', supplyOrder)
        
        $.get(url, function(data) {
            var kolomTotal = $('#kolom-hasil')
            $.each(kolomTotal, function(key, value) {
                var target = kolomTotal[key]
                target.val(data.total)
            });
        });
    }

    $('#name').on('select2:select', function(e) {
        var target = $('#name').val();
        var url = '{{ route("manager.getPrice", ':id') }}';
        url = url.replace(':id', target);
        $.get(url, function(data) {
            var input = $('#price');
            input.empty();
            input.val(data.price)
        });
    })

    function totalHarga() {
        var qty = $('#qty').val();
        var harga = $('#price').val();
        var hasil = 0;
        var input = $('#total');

        if (harga == '') {
            toastEvent('Error!', 'isi Data Bahan Baku dahulu', 'topRight', 'error')
        } else {
            input.empty();
            hasil = qty * harga;
            input.val(hasil)
        }
    }

    $('#detail-form').submit(function (e) { 
        e.preventDefault();
        
        var supply_id = $('#name').val();
        var qty = $('#qty').val();
        var price = $('#price').val();
        var total = $('#total').val();

        console.log(supply_id);
        console.log(qty);

        if (qty == '' && supply_id == '') {
            toastEvent('Error!', 'isi Data Kuantitas dan Nama dahulu', 'topRight', 'error')
        } else if (qty == '') {
            toastEvent('Error!', 'isi Data Kuantitas dahulu', 'topRight', 'error')
        } else if (supply_id == '') {
            toastEvent('Error!', 'isi Data Bahan Baku dahulu', 'topRight', 'error')
        } else {
            var id = $("#supply_order_id").val();
            
            var url = "{{ route('manager.storeDetailOrderSupply', ":id") }}";
            url = url.replace(':id', id);

            var data = {
                id: id,
                supply_id: supply_id,
                qty: qty,
                total: total
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log('masuk success');
                    toastEvent('Success!', response.message, 'topRight', 'success')
                    reloadTable('#detail-supply-table', 100);
                    $('#detail-form')[0].reset()
                },
                error: function (data) {
                    console.log('masuk success');
                    toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
                }
            });
            // this.submit();
        }
    });

    function reloadTable(selector, counter) {
        updateTotal()
        setTimeout(function() {
            $(selector).DataTable().ajax.reload();
        }, 100);
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

    function removeItem(id) {
        var supplyOrder = {{ $data->id }}
        var supply_id = id
        var url = "{{ route('manager.deleteDetailOrderSupplyItem', [":supplyOrder", ":supply"]) }}"
        url = url.replace(':supplyOrder', supplyOrder)
        url = url.replace(':supply', supply_id)

        console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            success: function(data) {
                console.log(data);
                toastEvent('Success!', data.message, 'topRight', 'success')
                reloadTable('#detail-supply-table', 100);
            }
        });
    }

    function minusItem(id) {
        var supplyOrder = {{ $data->id }}
        var supply_id = id
        console.log('masuk function update minus Item', supplyOrder, supply_id)
        var url = "{{ route('manager.minusDetailOrderSupplyItem', [":supplyOrder", ":supply"]) }}"
        url = url.replace(':supplyOrder', supplyOrder)
        url = url.replace(':supply', supply_id)

        console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            success: function(data) {
                console.log(data);
                toastEvent('Success!', data.message, 'topRight', 'success')
                reloadTable('#detail-supply-table', 100);
            }
        });
    }

    function plusItem(id) {
        var supplyOrder = {{ $data->id }}
        var supply_id = id
        console.log('masuk function update plus Item', supplyOrder, supply_id)
        var url = "{{ route('manager.plusDetailOrderSupplyItem', [":supplyOrder", ":supply"]) }}"
        url = url.replace(':supplyOrder', supplyOrder)
        url = url.replace(':supply', supply_id)

        console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            success: function(data) {
                console.log(data);
                toastEvent('Success!', data.message, 'topRight', 'success')
                reloadTable('#detail-supply-table', 100);
            }
        });
    }
</script>
@endpush
@include('import.datatable')
@include('import.select2')
@include('import.toastr')