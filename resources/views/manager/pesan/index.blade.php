@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pesanan {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <form action="{{ route('pesanan.store') }}" method="post">
                        @csrf
                        <input type="submit" class="btn btn-success" value="Tambah {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}">
                    </form>
                    {{-- <a href="{{ route('pesanan.store') }}" class="btn btn-success">Tambah {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pesanan-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('List Item')}}</th>
                            <th>{{__('Total Harga')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Aksi')}}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#pesanan-table').DataTable({
            "language": {
                "emptyTable": "Data Stock Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manager.getAllSupplyOrder') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_item', name: 'nama_item'},
                {data: 'price_total', name: 'price_total'}, 
                {data: 'status', name: 'status'}, 
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
    });

    function updateStatus(id) {
        var url = "{{ route('manager.updateStatus', ":id") }}";
        url = url.replace(':id', id);
        
        console.log(url);

        Swal.fire({
            title: 'Apa anda Yakin?',
            text: "Yakin ingin Mengubah Status Order Bahan Baku?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {id: id, '_method':'PUT'},
                    success: function (response) {
                        console.log('masuk success');
                        console.log(response);
                        toastEvent('Success!', response.message, 'topRight', 'success')
                        reloadTable('#pesanan-table', 100);
                    },
                    error: function (data) {
                        console.log('masuk error');
                        toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
                    }
                });
                console.log('masuk swall');
            }
        });
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
        // updateTotal()
        setTimeout(function() {
            $(selector).DataTable().ajax.reload();
        }, 100);
    }
</script>
@endpush
@include('import.datatable')