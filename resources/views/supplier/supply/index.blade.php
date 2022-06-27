@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('supplier.create') }}" class="btn btn-success">Tambah {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="supply-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('Nama')}}</th>
                            <th>{{__('Stock Sisa Produsen')}}</th>
                            <th>{{__('Status Bahan Baku')}}</th>
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
        $('#supply-table').DataTable({
            "language": {
                "emptyTable": "Data Stock Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('supplier.getSupply') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'stock', name: 'stock'}, 
                {data: 'status', name: 'status'}, 
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
    });


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

    function updateItem(id) {
        var url = "{{ route('supplier.update', ":id") }}";
        url = url.replace(':id', id);
        
        console.log(url);

        Swal.fire({
            title: 'Apa anda Yakin?',
            text: "Yakin ingin Mengubah Status Bahan Baku?",
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
                        reloadTable('#supply-table', 100);
                    },
                    error: function (data) {
                        console.log('masuk error');
                        toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
                    }
                });
            }
        });
    }
</script>
@endpush
@include('import.datatable')