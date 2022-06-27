@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar {{ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('menu.create') }}" class="btn btn-success">Tambah {{ucfirst($title)}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="menu-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('Nama')}}</th>
                            <th>{{__('Harga Per item')}}</th>
                            <th>{{__('Stock')}}</th>
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
        $('#menu-table').DataTable({
            "language": {
                "emptyTable": "Menu Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manager.getMenu') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'harga', name: 'harga'},
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
        $('#menu-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });

    function emptyStock(id) {
        var url = "{{ route('manager.menu.emptyStock', ":id") }}";
        url = url.replace(':id', id);
        
        console.log(url);

        Swal.fire({
            title: 'Apa anda Yakin?',
            text: "Yakin ingin Merubah stok ke Habis?",
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
                        reloadTable('#menu-table', 100);
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